<?php

declare(strict_types=1);

namespace frontend\controllers\actions\tasks;

use TaskForce\Utils\Uploader;
use yii\base\Action;

class UploadFileAction extends Action
{
    /**
     * Сохраненяет файл задания на сервере при помощи Uploader'а.
     *
     * @return void
     */
    public function run(): void
    {
        Uploader::uploadFile();
    }
}
