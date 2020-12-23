<?php
namespace frontend\controllers;

use frontend\models\User;
use yii\web\Controller;

class UsersController extends Controller
{
    public function actionIndex()
    {
        $users = User::find()
            ->with(['categories', 'executorOpinions', 'executorTasks'])
            ->where(['role' => 'executor'])
            ->groupBy('user.id')
            ->orderBy('user.dt_add DESC')
            ->all();

        return $this->render('index', ['users' => $users]);
    }
}
