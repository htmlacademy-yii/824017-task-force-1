<?php

declare(strict_types = 1);

use frontend\assets\MessengerAsset;
use frontend\assets\YandexMapAsset;
use frontend\models\responses\Responses;
use frontend\models\task\Tasks;
use frontend\models\user\UserIdentity;
use TaskForce\Controllers\Task as TaskHelper;
use yii\helpers\{Html, Url};

/** @var yii\web\View $this */
/** @var Tasks $task Отображаемое задание */
/** @var Responses[] $responses Отклики к заданию */
/** @var bool $needShowChat Показать ли окно переписки */

$this->title = 'Просмотр задания';

/** @var UserIdentity $user Залогиненный пользователь. */
$user = \Yii::$app->user->getIdentity();

MessengerAsset::register($this);

YandexMapAsset::register($this);
$this->registerJsVar('latitude', $task->latitude);
$this->registerJsVar('longitude', $task->longitude);

$taskHelper = new TaskHelper($task->id, $task->customer_id, $task->executant_id, $task->status);

$formatter = \Yii::$app->formatter;

?>

<section class="content-view">
    <div class="content-view__card">
        <div class="content-view__card-wrapper">
            <div class="content-view__header">
                <div class="content-view__headline">
                    <h1><?= Html::encode($task->name) ?></h1>
                    <span>Размещено в категории
                    <a href="<?= Url::to(['tasks/index', 'specialization_id' => $task->specialization->id]) ?>" class="link-regular"><?= $task->specialization->name ?></a>
                    <?= $formatter->asRelativeTime($task->posting_date, strftime("%F %T")) ?></span>
                </div>
                <b class="new-task__price new-task__price--<?= $task->specialization->icon ?> content-view-price"><?= $task->payment ?><b> ₽</b></b>
                <div class="new-task__icon new-task__icon--<?= $task->specialization->icon ?> content-view-icon"></div>
            </div>
            <div class="content-view__description">
                <h3 class="content-view__h3">Общее описание</h3>
                <p><?= Html::encode($task->description) ?></p>
            </div>
            <?php if ($task->taskHelpfulFiles): ?>
                <div class="content-view__attach">
                    <h3 class="content-view__h3">Вложения</h3>
                    <?php foreach($task->taskHelpfulFiles as $file): ?>
                        <a href="<?= $file->path ?>"><?= $file->path ?></a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <div class="content-view__location">
                <h3 class="content-view__h3">Расположение</h3>
                <div class="content-view__location-wrapper">
                    <div class="content-view__map">
                        <div id="map" style="width: 361px; height: 292px"></div>
                    </div>
                    <div class="content-view__address">
                        <span class="address__town"><?= $task->city->name ?></span><br>
                        <span><?= Html::encode($task->address) ?></span>
                        <p>Вход под арку, код домофона 1122</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-view__action-buttons">
            <?php $action = $taskHelper->getAvailableAction($user->id, $user->role); ?>
            <?php if ($action): ?>
                <button class="button button__big-color <?= $action->getInternalName() ?>-button open-modal" type="button" data-for="<?= $action->getInternalName() ?>-form">
                    <?= $action->getDisplayingName() ?>
                </button>
            <?php endif; ?>
        </div>
    </div>
    <?php if ($responses): ?>
    <div class="content-view__feedback">
        <h2>Отклики <span>(<?= count($responses) ?>)</span></h2>
        <div class="content-view__feedback-wrapper">
        <?php foreach ($responses as $response): ?>
            <div class="content-view__feedback-card">
                <div class="feedback-card__top">
                    <a href="<?= Url::to(['users/view', 'id' => $response->author->id]) ?>"><img src="<?= $response->author->avatar ?>" width="55" height="55"></a>
                    <div class="feedback-card__top--name">
                        <p><a href="<?= Url::to(['users/view', 'id' => $response->author->id]) ?>" class="link-regular"><?= Html::encode($response->author->name) ?></a></p>
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <span class="<?= round($response->author->getRating()) < $i ? 'star-disabled' : '' ?>"></span>
                        <?php endfor; ?>
                        <b><?= $response->author->getRating() ?></b>
                    </div>
                    <span class="new-task__time"><?= $formatter->asRelativeTime($response->date_time, strftime("%F %T")) ?></span>
                </div>
                <div class="feedback-card__content">
                    <p>
                        <?= Html::encode($response->comment) ?>
                    </p>
                    <span><?= $response->payment ?> ₽</span>
                </div>
                <?php if ($user->id === $task->customer_id && !$response->is_refused && $task->status === TaskHelper::STATUS_NEW): ?>
                <div class="feedback-card__actions">
                    <a class="button__small-color request-button button"
                         type="button" href="<?= Url::to(['tasks/start-executing', 'taskId' => $task->id, 'executantId' => $response->user_id]) ?>">Подтвердить</a>
                    <a class="button__small-color refusal-button button"
                         type="button" href="<?= Url::to(['tasks/refuse-response', 'responseId' => $response->id]) ?>">Отказать</a>
                </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
    </div>
<?php endif; ?>
</section>
<section class="connect-desk">
    <div class="connect-desk__profile-mini">
        <div class="profile-mini__wrapper">
            <h3>Заказчик</h3>
            <div class="profile-mini__top">
                <img src="<?= $task->customer->avatar ?>" width="62" height="62" alt="Аватар заказчика">
                <div class="profile-mini__name five-stars__rate">
                    <p><?= Html::encode($task->customer->name) ?></p>
                </div>
            </div>
            <p class="info-customer"><span><?= count($task->customer->customerTasks) ?> заданий</span>
                <span class="last-"><?= (int)strftime("%Y") - (int)substr($task->customer->signing_up_date, 0, 4) ?> года на сайте</span></p>
            <a href="<?= Url::to(['users/view', 'id' => $task->customer->id]) ?>" class="link-regular">Смотреть профиль</a>
        </div>
    </div>
    <div id="chat-container">
        <?php if ($needShowChat): ?>
        <chat class="connect-desk__chat" task="<?= $task->id ?>"></chat>
        <?php endif; ?>
    </div>
</section>
