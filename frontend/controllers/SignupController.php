<?php
namespace frontend\controllers;

use frontend\models\SignupForm;
use yii\helpers\Url;
use yii\web\Controller;
use Yii;

class SignupController extends Controller
{
    public function actionIndex()
    {
        $errors =[];

        $model = new SignupForm();

        if (Yii::$app->request->getIsPost()) {
            $model->load(Yii::$app->request->post());

            if ($model->validate() && $model->signup()) {
                Yii::$app->response->redirect(Url::to('tasks'));
            }

            $errors = $model->getErrors();
        }

        return $this->render('index', ['model' => $model, 'errors' => $errors]);
    }
}
