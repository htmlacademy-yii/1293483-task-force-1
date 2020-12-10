<?php
namespace frontend\controllers;

use frontend\models\User;
use yii\web\Controller;

class UsersController extends Controller
{
    public function actionIndex()
    {
        $users = User::find()
            ->select(['user.*', 'COUNT(opinion.id) AS opinionsCount', 'COUNT(task.id) AS tasksCount'])
            ->joinWith(['categories', 'opinions0', 'tasks0'])
            ->where(['role' => 'executor'])
            ->groupBy('user.id')
            ->orderBy('user.dt_add DESC')
            ->all();

        return $this->render('index', ['users' => $users]);
    }
}
