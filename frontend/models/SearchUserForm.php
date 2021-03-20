<?php

namespace frontend\models;

class SearchUserForm extends \yii\base\Model
{
    public $searchedSpecializations;
    public $isFreeNow;
    public $isOnline;
    public $hasReviews;
    public $isFavorite;
    public $searchedName;

    public function rules()
    {
        return [
            [['searchedSpecializations', 'isFreeNow', 'isOnline', 'hasReviews', 'isFavorite', 'searchedName'], 'safe']
        ];
    }
}
