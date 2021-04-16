<?php

namespace frontend\models\user;

use frontend\models\specializations\Specializations;
use yii\helpers\ArrayHelper;

class UserSearchForm extends \yii\base\Model
{
    public ?array $searchedSpecializations = null;
    public ?string $isFreeNow = null;
    public ?string $isOnline = null;
    public ?string $hasReviews = null;
    public ?string $isFavorite = null;
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
            [['searchedSpecializations', 'isFreeNow', 'isOnline', 'hasReviews', 'isFavorite', 'searchedName'], 'safe']
        ];
    }
}
