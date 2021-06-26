<?php

declare(strict_types=1);

namespace frontend\controllers\actions\tasks;

use yii\base\Action;
use TaskForce\Utils\Uploader;

class UploadFileAction extends Action
{
    /**
     * Сохраненяет файл задания на сервере при помощи Uploader'а.
     *
     * @return void
     */
    public function run()
    {
        Uploader::uploadFile();
    }
}
