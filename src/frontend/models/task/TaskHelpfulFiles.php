<?php

namespace frontend\models\task;

/**
 * This is the model class for table "task_helpful_files".
 *
 * @property int $task_id
 * @property string $path
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
            [['task_id', 'path'], 'required'],
            ['task_id', 'integer'],
            ['path', 'string', 'max' => 1000],
            [
                'task_id',
                'exist',
                'targetClass' => Tasks::class,
                'targetAttribute' => ['task_id' => 'id']
            ],
        ];
    }
}
