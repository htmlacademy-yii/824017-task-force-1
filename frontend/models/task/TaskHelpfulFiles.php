<?php

namespace frontend\models\task;

use Yii;

/**
 * This is the model class for table "task_helpful_files".
 *
 * @property int $task_id
 * @property string $helpful_file
 *
 * @property Task $task
 */
class TaskHelpfulFiles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task_helpful_files';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task_id', 'helpful_file'], 'required'],
            [['task_id'], 'integer'],
            [['helpful_file'], 'string', 'max' => 1000],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::className(), 'targetAttribute' => ['task_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'task_id' => 'Task ID',
            'helpful_file' => 'Файлы',
        ];
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery|TaskQuery
     */
    public function getTask()
    {
        return $this->hasOne(Tasks::className(), ['id' => 'task_id']);
    }

    /**
     * {@inheritdoc}
     * @return TaskHelpfulFilesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TaskHelpfulFilesQuery(get_called_class());
    }
}
