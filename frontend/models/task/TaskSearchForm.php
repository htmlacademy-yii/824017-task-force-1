<?php

namespace frontend\models\task;

use frontend\models\specializations\Specializations;
use yii\helpers\ArrayHelper;

class TaskSearchForm extends \yii\base\Model
{
    public ?array $searchedSpecializations = null;
    public ?string $hasNoResponses = null;
    public ?string $hasNoLocation = null;
    public ?string $postingPeriod = null;
    public ?string $searchedName = null;

    private array $specializations;

    public function getSpecializations(): array
    {
        if (!isset($this->specializations)) {
            $this->specializations = ArrayHelper::map(Specializations::getAll(), 'id', 'name');
        }

        return $this->specializations;
    }

    public function rules()
    {
        return [
            [['searchedSpecializations', 'hasNoResponses', 'hasNoLocation', 'postingPeriod', 'searchedName'], 'safe']
        ];
    }
}
