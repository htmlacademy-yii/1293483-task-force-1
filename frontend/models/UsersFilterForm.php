<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class UsersFilterForm extends Model
{
    const USER_ONLINE_TIMEOUT = 30;

    public $categories;
    public $free;
    public $online;
    public $hasOpinions;
    public $inFavorites;
    public $search;

    /**
     * Получение категорий
     *
     * @return array
     */
    static public function getCategories()
    {
        return Category::find()->asArray()->all();
    }

    /**
     * Меняет имя формы для получения более красивых URL при фильтрации
     *
     * @return string
     */
    public function formName() {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['categories', 'free', 'online', 'hasOpinions', 'inFavorites', 'search'], 'safe'],
            ['search', 'filter', 'filter' => 'trim'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'free' => 'Сейчас свободен',
            'online' => 'Сейчас онлайн',
            'hasOpinions' => 'Есть отзывы',
            'inFavorites' => 'В избранном',
            'search' => 'Поиск по имени',
        ];
    }

    /**
     * Получение отфильтрованных исполнителей
     *
     * @return object
     */
    public function getDataProvider()
    {
        $query = User::find()
            ->with(['categories'])
            ->where(['role' => User::ROLE_EXECUTOR]);

        if (!empty($this->categories)) {
            $query->joinWith('userSpecializations')->andWhere(['category_id' => $this->categories]);
        }

        if (!empty($this->free)) {
            $query->joinWith('executorTasks')->andWhere(['IN', 'status', [Task::STATUS_CANCELED, Task::STATUS_DONE, Task::STATUS_FAILED, null]]);
        }

        if (!empty($this->online)) {
            $query->andWhere('dt_last_visit > NOW() - INTERVAL :period MINUTE', [':period' => self::USER_ONLINE_TIMEOUT]);
        }

        if (!empty($this->hasOpinions)) {
            $query->innerJoin('opinion', 'user.id = opinion.executor_id')->groupBy('user.id');;
        }

        if (!empty($this->inFavorites)) {
        $query->joinWith('executorFavorites')->andWhere(['customer_id' => 1]); //TODO здесь вместо 1 должен быть id авторизованного пользователя
    }

        if (!empty($this->search)) {
            $query->andWhere(['like', 'user.name', $this->search]);
        }

        $sort = Yii::$app->request->get('sort');

        if (!empty($sort)) {
            switch ($sort) {
                case 'rating':
                    $query->orderBy('user.rating DESC');
                    break;
                case 'tasksCount':
                    $query->orderBy('(SELECT COUNT(t.id) FROM task t WHERE user.id = t.executor_id) DESC');
                    break;
                case 'popular':
                    $query->orderBy('user.view_count DESC');
                    break;
            }
        } else {
            $query->orderBy('user.dt_add DESC');
        }

        $query->all();

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' =>[
                'pageSize' => 5,
            ],
        ]);
    }
}