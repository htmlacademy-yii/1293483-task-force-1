<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class TasksFilterForm extends Model
{
    const INTERVAL_DAY = 1;
    const INTERVAL_WEEK = 7;
    const INTERVAL_MONTH = 30;

    public $categories;
    public $noReply;
    public $remoteWork;
    public $period;
    public $search;

    /**
     * Получение периодов фильтрации
     *
     * @return array
     */
    static public function getPeriod()
    {
        return [
            self::INTERVAL_DAY => 'За день',
            self::INTERVAL_WEEK => 'За неделю',
            self::INTERVAL_MONTH => 'За месяц',
        ];
    }

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
     * Изменение имя формы для получения более красивых URL при фильтрации
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
            [['categories', 'noReply', 'remoteWork', 'period', 'search'], 'safe'],
            ['search', 'filter', 'filter' => 'trim'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'noReply' => 'Без откликов',
            'remoteWork' => 'Удаленная работа',
            'period' => 'Период',
            'search' => 'Поиск по названию',
        ];
    }

    /**
     * Получение отфильтрованных заданий
     *
     * @return object
     */
    public function getDataProvider()
    {
        $query = Task::find()->with('category')->where(['status' => Task::STATUS_NEW]);

        if (!empty($this->categories)) {
            $query->andWhere(['category_id' => $this->categories]);
        }

        if (!empty($this->noReply)) {
            $query->joinWith('replies')->having('COUNT(reply.id) = 0')->groupBy('task.id');
        }

        if (!empty($this->remoteWork)) {
            $query->andWhere(['address' => null]);
        }

        if (!empty($this->period)) {
            $query->andWhere('dt_add > NOW() - INTERVAL :period DAY', [':period' => $this->period]);
        }

        if (!empty($this->search)) {
            $query->andWhere(['like', 'title', $this->search]);
        }

        $query->orderBy('dt_add DESC')->all();

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' =>[
                'pageSize' => 5,
            ],
        ]);
    }
}
