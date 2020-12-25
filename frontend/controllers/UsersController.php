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
            ->where(['role' => User::ROLE_EXECUTOR])
            ->orderBy('user.dt_add DESC')
            ->all();

        return $this->render('index', ['users' => $users]);
    }
}
