<?php

declare(strict_types = 1);

namespace frontend\controllers;

use yii\web\Controller;

class LandingController extends Controller
{
    public function actionIndex()
    {
        $this->layout = 'anon';

        return $this->render('index');
    }
}