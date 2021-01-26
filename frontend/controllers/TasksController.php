<?php
namespace frontend\controllers;

use Yii;
use frontend\models\Task;
use frontend\models\User;
use frontend\models\Category;
use frontend\models\TasksFilterForm;
use frontend\models\CreateTaskForm;
use yii\base\Exception;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

class TasksController extends SecuredController
{
    public function behaviors()
    {
        $rules = parent::behaviors();
        $rule = [
            'allow' => false,
            'actions' => ['create'],
            'matchCallback' => function ($rule, $action) {
                $userId = Yii::$app->user->getId();
                $user = User::findOne($userId);

                return User::ROLE_EXECUTOR === $user->role;
            }
        ];

        array_unshift($rules['access']['rules'], $rule);

        return $rules;
    }

    public function actionIndex()
    {
        $model = new TasksFilterForm();
        $model->load(Yii::$app->request->get());

        return $this->render('index', ['dataProvider' => $model->getDataProvider(), 'model' => $model]);
    }

    public function actionView($id)
    {
        $task = Task::findOne($id);

        if (!$task) {
            throw new NotFoundHttpException("Задание не найдено");
        }

        return $this->render('view', ['task' => $task]);
    }

    public function actionCreate()
    {
        $categories = Category::find()->asArray()->all();

        $model = new CreateTaskForm();

        if (Yii::$app->request->getIsPost()) {
            $model->load(Yii::$app->request->post());

            if ($model->validate() && $model->createTask()) {

                Yii::$app->response->redirect(Url::to('tasks'));
            }
        }

        return $this->render('create', ['model' => $model, 'categories' => $categories]);
    }

    public function actionLoadFiles()
    {
        if (Yii::$app->request->isAjax) {
            $files = UploadedFile::getInstancesByName('files');

            foreach ($files as $file) {
                $filePath = 'uploads/' . uniqid() . '.' . $file->getExtension();

                if (!$file->saveAs($filePath)) {
                    throw new Exception('Не удалось сохранить файл(ы)');
                }

                Yii::$app->session->set('files', array_merge(Yii::$app->session->get('files') ?? [], [$filePath]));
            }
        }

        return true;
    }

    public function beforeAction($action)
    {
        if ($this->action->id === 'load-files') {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }
}
