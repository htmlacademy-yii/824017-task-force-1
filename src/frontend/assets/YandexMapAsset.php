<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class YandexMapAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $jsOptions = ['type' => 'text/javascript'];

    public function init()
    {
        parent::init();

        $this->js = [
            'http://api-maps.yandex.ru/2.1/?apikey=' . $_ENV['YANDEX_MAPS_API_KEY'] . '&lang=ru_RU',
            'js/yandexMap.js',
        ];
    }
}
