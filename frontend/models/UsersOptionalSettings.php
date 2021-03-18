<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "users_optional_settings".
 *
 * @property int $user_id
 * @property int $is_hidden_contacts
 * @property int $is_hidden_account
 * @property int $is_subscribed_messages
 * @property int $is_subscribed_actions
 * @property int $is_subscribed_reviews
 *
 * @property User $user
 */
class UsersOptionalSettings extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users_optional_settings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'is_hidden_contacts', 'is_hidden_account', 'is_subscribed_messages', 'is_subscribed_actions', 'is_subscribed_reviews'], 'required'],
            [['user_id', 'is_hidden_contacts', 'is_hidden_account', 'is_subscribed_messages', 'is_subscribed_actions', 'is_subscribed_reviews'], 'integer'],
            [['user_id'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'is_hidden_contacts' => 'Is Hidden Contacts',
            'is_hidden_account' => 'Is Hidden Account',
            'is_subscribed_messages' => 'Is Subscribed Messages',
            'is_subscribed_actions' => 'Is Subscribed Actions',
            'is_subscribed_reviews' => 'Is Subscribed Reviews',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return UsersOptionalSettingsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UsersOptionalSettingsQuery(get_called_class());
    }
}
