<?php

declare(strict_types = 1);

namespace TaskForce\Utils;

use yii\web\UploadedFile;
use Yii;

final class Uploader
{
    /**
     * Сохраняет файл в публичной директории.
     *
     * С помощью класса UploadedFile сохраняет файл в папке /uploads,
     * и записывает в сессию путь к этому файлу для последующего
     * сохранения этого пути в БД при создании задания.
     *
     * @return void
     */
    public static function uploadFile(): void
    {
        $file = UploadedFile::getInstanceByName('Attach');
        $path = '/uploads/' . uniqid() . '.' . $file->extension;
        $file->saveAs('@webroot' . $path);
        $session = Yii::$app->session;

        if (isset($session['paths'])) {
            $paths = $session['paths'];
        } else {
            $paths = [];
        }

        $paths[] = $path;
        $session['paths'] = $paths;
    }
}
