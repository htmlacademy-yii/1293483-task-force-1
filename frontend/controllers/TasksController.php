<?php
namespace frontend\controllers;

use frontend\models\Task;
use yii\web\Controller;

class TasksController extends Controller
{
    public function actionIndex()
    {
        $tasks = Task::find()->with('category')->andWhere(['status' => 'new'])->orderBy('dt_add DESC')->all();

        return $this->render('index', ['tasks' => $tasks]);
    }
}
