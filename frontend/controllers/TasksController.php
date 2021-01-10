<?php
namespace frontend\controllers;

use yii\web\Controller;
use frontend\models\TasksFilterForm;
use Yii;
use frontend\models\Task;
use yii\web\NotFoundHttpException;

class TasksController extends Controller
{
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
}
