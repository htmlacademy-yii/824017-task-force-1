<?php

declare(strict_types = 1);

use yii\helpers\Url;
use yii\helpers\Html;

$formatter = \Yii::$app->formatter;
?>

<div class="landing-bottom">
    <div class="landing-bottom-container">
        <h2>Последние задания на сайте</h2>

        <?php foreach($tasks as $task): ?>
        <div class="landing-task">
            <div class="landing-task-top task-<?= $task['specialization']['icon'] ?>"></div>
            <div class="landing-task-description">
                <h3>
                    <a href="<?= Url::toRoute(['tasks/view', 'id' => $task['id']]) ?>" class="link-regular">
                        <?= Html::encode($task['name']) ?>
                    </a>
                </h3>
                <p><?= Html::encode(mb_substr($task['description'], 0, 65)) . '...' ?></p>
            </div>
            <div class="landing-task-info">
                <div class="task-info-left">
                    <p><a href="<?= Url::toRoute(['tasks/index', 'specialization_id' => $task['specialization']['id']]) ?>" class="link-regular"><?= $task['specialization']['name'] ?></a></p>
                    <p><?= $formatter->asRelativeTime($task['posting_date'], strftime("%F %T")) ?></p>
                </div>
                <?php if ($task['payment']): ?>
                <span>
                    <?= $formatter->asInteger($task['payment']) ?><b> ₽</b>
                </span>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <div class="landing-bottom-container">
        <a class="button red-button"
            href="<?= Url::toRoute(['tasks/index']) ?>"
            style="height: 15px;
                padding-top: 20px;
                padding-bottom: 22px;
                width: 210px;
                display: block">смотреть все задания</a>
    </div>
</div>
