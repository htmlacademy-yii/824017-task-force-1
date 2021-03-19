<?php

//declare(strict_types = 1); стоит здесь объявлять строгую типизацию, да?

//У меня была мысль, не создавать данную модель, а описать приведенные ниже свойства параметров поиска в уже имеющейся модели Tasks. Также добавить в Tasks сценарий для поиска задач, в котором и будут использоваться эти свойства-параметры поиска (только в этом сценарии для поиска  задач). Но я не был уверен правильно ли будет так делать. Поэтому в данный момент создан отдельный класс SearchTaskForm, в котором описаны эти свойства-параметры поиска.

namespace frontend\models;

class SearchTaskForm extends \yii\base\Model
{
    public $searchedSpecializations;
    public $hasNoResponses;
    public $hasNoLocation;
    public $postingPeriod;
    public $searchedTaskName;

    public function rules()
    {
        return [
            [['searchedSpecializations', 'hasNoResponses', 'hasNoLocation', 'postingPeriod', 'searchedTaskName'], 'safe']
        ];
    }
}
