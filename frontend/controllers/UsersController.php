<?php
namespace frontend\controllers;

use yii\web\Controller;
use frontend\models\UsersFilterForm;
use Yii;

class UsersController extends Controller
{
    public function actionIndex()
    {
        $model = new UsersFilterForm();
        $model->load(Yii::$app->request->get());

        return $this->render('index', ['dataProvider' => $model->getDataProvider(), 'model' => $model]);
    }
}
