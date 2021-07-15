<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class YandexMapAsset extends AssetBundle
{
    private const API_KEY = 'e666f398-c983-4bde-8f14-e3fec900592a';

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'http://api-maps.yandex.ru/2.1/?apikey=' . self::API_KEY . '&lang=ru_RU',
        'js/yandexMap.js',
    ];
    public $jsOptions = ['type' => 'text/javascript'];
}
