<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "profile".
 *
 * @property int $id
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
 * @property int $user_id
 *
 * @property User $user
 */
class Profile extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dt_last_visit', 'dt_birth'], 'safe'],
            [['info'], 'string'],
            [['rating', 'view_count', 'show_new_message', 'show_task_actions', 'show_new_review', 'show_contacts_customer', 'show_profile', 'user_id'], 'integer'],
            [['role', 'user_id'], 'required'],
            [['avatar'], 'string', 'max' => 100],
            [['phone', 'skype', 'telegram', 'role'], 'string', 'max' => 50],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
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
            'user_id' => 'User ID',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
