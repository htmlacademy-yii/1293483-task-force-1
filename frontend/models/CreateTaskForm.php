<?php
namespace frontend\models;

use Yii;
use yii\base\Model;

class CreateTaskForm extends Model
{
    public $title;
    public $description;
    public $categoryId;
    public $files;
    public $location;
    public $budget;
    public $dtEnd;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'description', 'categoryId'], 'required'],
            [['title', 'description', 'categoryId', 'files', 'budget', 'dtEnd'], 'safe'],

            ['title', 'string', 'min' => 10, 'max' => 100],
            ['description', 'string', 'min' => 30],
            ['categoryId', 'exist', 'targetClass' => '\frontend\models\Category', 'targetAttribute' => 'id'],
            ['files', 'file', 'skipOnEmpty' => true],
            ['budget', 'integer', 'min' => 1],
            ['dtEnd', 'date', 'format' => 'Y-m-d'],
            ['dtEnd', function ($attribute, $params) {
                if (strtotime($this->dtEnd) < strtotime('today')) {
                    $this->addError($attribute, 'Нельзя установить прошедшую дату');
                }
            }],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'title' => 'Мне нужно',
            'description' => 'Подробности задания',
            'categoryId' => 'Категория',
            'files' => 'Файлы',
            'location' => 'Локация',
            'budget' => 'Бюджет',
            'dtEnd' => 'Срок исполнения',
        ];
    }

    /**
     * Сохранение файлов задания в БД
     *
     * @param int $taskId id задания
     *
     * @return bool
     */
    public function createFiles($taskId): bool
    {
        foreach (Yii::$app->session->get('files') as $filePath) {
            $file = new File;

            $file->url = $filePath;
            $file->task_id = $taskId;

            if (!$file->save()) {
                return false;
            }
        }

        Yii::$app->session->remove('files');

        return true;
    }

    /**
     * Сохранение задания в БД
     *
     * @return bool
     * @throws \yii\db\Exception
     */
    public function createTask(): bool
    {
        $transaction = Yii::$app->db->beginTransaction();

        $task = new Task();

        $task->dt_end = $this->dtEnd;
        $task->title = $this->title;
        $task->description = $this->description;
        $task->budget = $this->budget;
        $task->status = Task::STATUS_NEW;
        $task->category_id = $this->categoryId;
        $task->customer_id = Yii::$app->user->getId();

        if (!$task->save()) {
            $transaction->rollback();

            return false;
        }

        $taskId = $task->getPrimaryKey();

        if (Yii::$app->session->has('files')) {
            if (!$this->createFiles($taskId)) {
                $transaction->rollback();

                return false;
            }
        }

        $transaction->commit();

        return true;
    }
}
