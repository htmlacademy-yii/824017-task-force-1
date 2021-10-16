<?php

namespace frontend\models\user;

use Yii;

/**
 * This is the model class for table "users_accomplished_tasks_photos".
 *
 * @property int $user_id
 * @property string $accomplished_task_photo
 *
 * @property User $user
 */
class UsersAccomplishedTasksPhotos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users_accomplished_tasks_photos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'accomplished_task_photo'], 'required'],
            [['user_id'], 'integer'],
            [['accomplished_task_photo'], 'string', 'max' => 1000],
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
            'accomplished_task_photo' => 'Accomplished Task Photo',
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
     * @return UsersAccomplishedTasksPhotosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UsersAccomplishedTasksPhotosQuery(get_called_class());
    }
}
