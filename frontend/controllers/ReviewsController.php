<?php

declare(strict_types = 1);

namespace frontend\controllers;

use yii\web\Controller;
use frontend\models\Reviews;

class ReviewsController extends Controller
{
    public function actionShowAll(): string
    {
        $reviews = Reviews::find()->all();

        return $this->render('show-all', ['reviews' => $reviews]);
    }
}