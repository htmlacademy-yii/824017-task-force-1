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
class FilesUploadingForm extends \yii\db\ActiveRecord
{
    public $files;

    public $filePaths;

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
            /*[['files'], 'file', 'skipOnEmpty' => false, 'maxFiles' => 0],*/
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            /*'task_id' => 'Task ID',*/
            'files' => 'Файлы',
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

    /*public function upload(): void
    {
        foreach ($this->files as $file) {
            $newname = uniqid() . '.' . $file->extension;
            $file->saveAs('@webroot/uploads/' . $newname);
            $filePaths[] = "/uploads/$newname";
        }
    }*/
}
