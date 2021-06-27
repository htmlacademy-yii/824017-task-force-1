<?php

namespace frontend\models;

class FailForm extends \yii\base\Model
{
    public $task_id;

    public function rules()
    {
        return [
            [['task_id'], 'safe'],
        ];
    }
}
