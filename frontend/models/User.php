<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

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
class User extends ActiveRecord
{
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
    public function getTasksCount()
    {
        return $this->executorTasks ? count($this->executorTasks) : 0;
    }
}
