<?php
namespace frontend\controllers;

use yii\web\Controller;
use frontend\models\UsersFilterForm;
use Yii;
use frontend\models\User;
use yii\web\NotFoundHttpException;

class UsersController extends Controller
{
    public function actionIndex()
    {
        $model = new UsersFilterForm();
        $model->load(Yii::$app->request->get());

        return $this->render('index', ['dataProvider' => $model->getDataProvider(), 'model' => $model]);
    }

    public function actionView($id)
    {
        $user = User::find()->where(['id' => $id, 'role' => User::ROLE_EXECUTOR])->one();

        if (!$user) {
            throw new NotFoundHttpException("Исполнитель не найден");
        }

        return $this->render('view', ['user' => $user]);
    }
}
