<?php
namespace frontend\controllers;

use frontend\models\SignupForm;
use frontend\models\City;
use yii\helpers\Url;
use yii\web\Controller;
use Yii;

class LandingController extends Controller
{
    public function actionSignup()
    {
        $cities = City::find()->asArray()->all();

        $model = new SignupForm();

        if (Yii::$app->request->getIsPost()) {
            $model->load(Yii::$app->request->post());

            if ($model->validate() && $model->signup()) {
                Yii::$app->response->redirect(Url::to('tasks'));
            }
        }

        return $this->render('signup', ['model' => $model, 'cities' => $cities]);
    }
}
