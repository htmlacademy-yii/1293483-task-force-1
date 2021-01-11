<?php
namespace frontend\models;

use Yii;
use yii\base\Exception;
use yii\base\Model;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $email;
    public $name;
    public $city_id;
    public $password;

    static public function getCities()
    {
        return City::find()->asArray()->all();
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'name', 'city_id', 'password'], 'required'],
            [['email', 'name', 'city_id', 'password'], 'safe'],
            [['name', 'email'], 'string', 'min' => 2, 'max' => 100],

            ['email', 'email', 'message' => 'Введите валидный адрес электронной почты'],
            ['email', 'unique', 'targetClass' => '\frontend\models\User', 'message' => 'Пользователь с таким Email уже существует'],

            ['city_id', 'exist', 'targetClass' => '\frontend\models\City', 'targetAttribute' => 'id'],

            ['password', 'string', 'min' => 8, 'message' => 'Длина пароля от 8 символов'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'email' => 'Электронная почта',
            'name' => 'Ваше имя',
            'city_id' => 'Город проживания',
            'password' => 'Пароль',
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     * @throws Exception
     */
    public function signup()
    {
        $user = new User();

        $user->email = $this->email;
        $user->name = $this->name;
        $user->city_id = $this->city_id;
        $user->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
        $user->role = User::ROLE_CUSTOMER;

        return $user->save();
    }
}
