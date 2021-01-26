<?php
namespace frontend\controllers;

use frontend\models\SignupForm;
use frontend\models\City;
use yii\helpers\Url;
use yii\web\Controller;
use Yii;
use frontend\models\LoginForm;
use yii\filters\AccessControl;
use frontend\models\Task;
use yii\web\Response;
use yii\widgets\ActiveForm;

class LandingController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'signup'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => false,
                        'actions' => ['index'],
                        'roles' => ['@'],
                        'denyCallback' => function ($rule, $action) {
                            Yii::$app->response->redirect(Url::to('tasks'));
                        },
                    ],
                    [
                        'allow' => true,
                        'actions' => ['logout'],
                        'roles' => ['@'],
                    ],
                ]
            ]
        ];
    }

    public function actionIndex()
    {
        $this->layout = 'landing';

        $tasks = Task::find()->with('category')->orderBy('dt_add DESC')->limit(4)->all();

        $model = new LoginForm();

        if (Yii::$app->request->getIsPost()) {
            $model->load(Yii::$app->request->post());

            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;

                return ActiveForm::validate($model);
            }

            if ($model->validate()) {
                $user = $model->getUser();
                Yii::$app->user->login($user);
                Yii::$app->response->redirect(Url::to('tasks'));
            }
        }

        return $this->render('index', ['model' => $model, 'tasks' => $tasks]);
    }

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

    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
