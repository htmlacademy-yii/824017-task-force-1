<?php

declare(strict_types = 1);

use yii\helpers\{Url, Html};

$formatter = \Yii::$app->formatter;
?>

<div class="new-task__card">
    <div class="new-task__title">
        <a href="<?= Url::to(['tasks/view', 'id' => $model['id']]) ?>" class="link-regular"><h2><?= Html::encode($model['name']) ?></h2></a>
        <a  class="new-task__type link-regular" href="<?= Url::to(['tasks/index', 'specialization_id' => $model['specialization']['id']]) ?>"><p><?= Html::encode($model['specialization']['name']) ?></p></a>
    </div>
    <div class="new-task__icon new-task__icon--<?= Html::encode($model['specialization']['icon']) ?>"></div>
    <p class="new-task_description">
        <?= Html::encode($model['description']) ?>
    </p>
    <b class="new-task__price new-task__price--<?= Html::encode($model['specialization']['icon']) ?>"><?= Html::encode($model['payment']) ?><b> ₽</b></b>
    <p class="new-task__place">Санкт-Петербург, Центральный район</p>
    <span class="new-task__time"><?= $formatter->asRelativeTime($model['posting_date'], strftime("%F %T")) ?></span>
</div>
