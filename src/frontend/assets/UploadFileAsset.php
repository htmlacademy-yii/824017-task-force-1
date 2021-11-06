<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class UploadFileAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'js/uploadFile.js',
    ];
    public $depends = [
        'frontend\assets\AppAsset'
    ];
}
