<?php

namespace frontend\controllers;

use frontend\controllers\SecuredController;

class SiteController extends SecuredController
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
}
