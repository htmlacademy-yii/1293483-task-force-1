<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $email
 * @property string $name
 * @property string $password
 * @property string $dt_add
 * @property string|null $dt_last_visit
 * @property string|null $dt_birth
 * @property string|null $avatar
 * @property string|null $info
 * @property string|null $phone
 * @property string|null $skype
 * @property string|null $telegram
 * @property int|null $rating
 * @property string $role
 * @property int|null $view_count
 * @property int|null $show_new_message
 * @property int|null $show_task_actions
 * @property int|null $show_new_review
 * @property int|null $show_contacts_customer
 * @property int|null $show_profile
 * @property int $city_id
 *
 * @property Favorites[] $customerFavorites
 * @property Favorites[] $executorFavorites
 * @property User[] $executors
 * @property User[] $customers
 * @property Message[] $senderMessages
 * @property Message[] $receiverMessages
 * @property Opinion[] $customerOpinions
 * @property Opinion[] $executorOpinions
 * @property PhotoOfWork[] $photoOfWorks
 * @property Reply[] $replies
 * @property Task[] $customerTasks
 * @property Task[] $executorTasks
 * @property City $city
 * @property UserSpecialization[] $userSpecializations
 * @property Category[] $categories
 * @property User[] $opinionsCount
 * @property User[] $tasksCount
 */
class User extends ActiveRecord implements IdentityInterface
{
    const ROLE_CUSTOMER = 'customer';
    const ROLE_EXECUTOR = 'executor';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'name', 'password', 'role', 'city_id'], 'required'],
            [['dt_add', 'dt_last_visit', 'dt_birth'], 'safe'],
            [['info'], 'string'],
            [['rating', 'view_count', 'show_new_message', 'show_task_actions', 'show_new_review', 'show_contacts_customer', 'show_profile', 'city_id'], 'integer'],
            [['email', 'name', 'avatar'], 'string', 'max' => 100],
            [['password'], 'string', 'max' => 64],
            [['phone', 'skype', 'telegram', 'role'], 'string', 'max' => 50],
            [['email'], 'unique'],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'name' => 'Name',
            'password' => 'Password',
            'dt_add' => 'Dt Add',
            'dt_last_visit' => 'Dt Last Visit',
            'dt_birth' => 'Dt Birth',
            'avatar' => 'Avatar',
            'info' => 'Info',
            'phone' => 'Phone',
            'skype' => 'Skype',
            'telegram' => 'Telegram',
            'rating' => 'Rating',
            'role' => 'Role',
            'view_count' => 'View Count',
            'show_new_message' => 'Show New Message',
            'show_task_actions' => 'Show Task Actions',
            'show_new_review' => 'Show New Review',
            'show_contacts_customer' => 'Show Contacts Customer',
            'show_profile' => 'Show Profile',
            'city_id' => 'City ID',
        ];
    }

    /**
     * Gets query for [[CustomerFavorites]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCustomerFavorites()
    {
        return $this->hasMany(Favorites::className(), ['customer_id' => 'id']);
    }

    /**
     * Gets query for [[ExecutorFavorites]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExecutorFavorites()
    {
        return $this->hasMany(Favorites::className(), ['executor_id' => 'id']);
    }

    /**
     * Gets query for [[Executors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExecutors()
    {
        return $this->hasMany(User::className(), ['id' => 'executor_id'])->viaTable('favorites', ['customer_id' => 'id']);
    }

    /**
     * Gets query for [[Customers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCustomers()
    {
        return $this->hasMany(User::className(), ['id' => 'customer_id'])->viaTable('favorites', ['executor_id' => 'id']);
    }

    /**
     * Gets query for [[SenderMessages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSenderMessages()
    {
        return $this->hasMany(Message::className(), ['sender_id' => 'id']);
    }

    /**
     * Gets query for [[ReceiverMessages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReceiverMessages()
    {
        return $this->hasMany(Message::className(), ['receiver_id' => 'id']);
    }

    /**
     * Gets query for [[CustomerOpinions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCustomerOpinions()
    {
        return $this->hasMany(Opinion::className(), ['customer_id' => 'id']);
    }

    /**
     * Gets query for [[ExecutorOpinions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExecutorOpinions()
    {
        return $this->hasMany(Opinion::className(), ['executor_id' => 'id']);
    }

    /**
     * Gets query for [[PhotoOfWorks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPhotoOfWorks()
    {
        return $this->hasMany(PhotoOfWork::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Replies]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReplies()
    {
        return $this->hasMany(Reply::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[CustomerTasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCustomerTasks()
    {
        return $this->hasMany(Task::className(), ['customer_id' => 'id']);
    }

    /**
     * Gets query for [[ExecutorTasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExecutorTasks()
    {
        return $this->hasMany(Task::className(), ['executor_id' => 'id']);
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    /**
     * Gets query for [[UserSpecializations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserSpecializations()
    {
        return $this->hasMany(UserSpecialization::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Categories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['id' => 'category_id'])->viaTable('user_specialization', ['user_id' => 'id']);
    }

    /**
     * Получение количества отзывов об исполнителе
     *
     * @return int
     */
    public function getOpinionsCount()
    {
        return $this->executorOpinions ? count($this->executorOpinions) : 0;
    }

    /**
     * Получение количества заданий у исполнителя
     *
     * @return int
     */
    public function getExecutorTasksCount()
    {
        return $this->executorTasks ? count($this->executorTasks) : 0;
    }

    /**
     * Получение количества заданий у заказчика
     *
     * @return int
     */
    public function getCustomerTasksCount()
    {
        return $this->customerTasks ? count($this->customerTasks) : 0;
    }

    /**
     * Finds an identity by the given ID.
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface|null the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|int an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled. The returned key will be stored on the
     * client side as a cookie and will be used to authenticate user even if PHP session has been expired.
     *
     * Make sure to invalidate earlier issued authKeys when you implement force user logout, password change and
     * other scenarios, that require forceful access revocation for old sessions.
     *
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return bool whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }

    /**
     * Валидация пароля
     *
     * @param string $password Проверяемый пароль
     *
     * @return bool
     */
    public function validatePassword(string $password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }
}
