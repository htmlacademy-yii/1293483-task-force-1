<?php
namespace frontend\controllers;

use yii\web\Controller;
use frontend\models\TasksFilterForm;
use Yii;

class TasksController extends Controller
{
    public function actionIndex()
    {
        $model = new TasksFilterForm();
        $model->load(Yii::$app->request->get());

        return $this->render('index', ['dataProvider' => $model->getDataProvider(), 'model' => $model]);
    }
}
