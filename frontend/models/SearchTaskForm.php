<?php

//declare(strict_types = 1); стоит ли здесь объявлять строгую типизацию?

namespace frontend\models;

class SearchTaskForm extends \yii\base\Model
{
    public $searchedSpecializations;
    public $hasNoResponses;
    public $hasNoLocation;
    public $postingPeriod;
    public $searchedName;

    public function rules()
    {
        return [
            [['searchedSpecializations', 'hasNoResponses', 'hasNoLocation', 'postingPeriod', 'searchedName'], 'safe']
        ];
    }
}
