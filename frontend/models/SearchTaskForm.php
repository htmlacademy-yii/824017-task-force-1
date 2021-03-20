<?php

//declare(strict_types = 1); стоит ли здесь объявлять строгую типизацию?

//У меня была мысль, не создавать данную модель, а описать приведенные ниже свойства параметров поиска в уже имеющейся модели Tasks. Также добавить в Tasks сценарий для поиска задач, в котором будут использоваться эти свойства-параметры поиска (только в этом сценарии для поиска  задач). Но я не был уверен правильно ли будет так делать. Поэтому в данный момент создан отдельный класс SearchTaskForm, в котором описаны эти свойства-параметры поиска.

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
