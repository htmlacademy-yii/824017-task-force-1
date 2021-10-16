<?php

namespace frontend\models\reviews;

class ReviewForm extends \yii\base\Model
{
    public $completion;
    public $comment;
    public $rate;
    public $task_id;

    public function rules()
    {
        return [
            [['completion', 'rate', 'comment', 'task_id'], 'safe'],
            ['rate', 'integer', 'min' => 1, 'max' => 5],
            [['completion', 'rate'], 'required']
        ];
    }

    public function attributeLabels()
    {
        return [
            'comment' => 'Комментарий'
        ];
    }
}
