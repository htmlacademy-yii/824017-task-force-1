<?php

declare(strict_types = 1);

use yii\helpers\Html;
use yii\helpers\Url;
use TaskForce\Controllers\{
    Task,
    ExecuteAction,
    CancelAction,
    FailAction,
    AccomplishAction
};

$taskHelper = new Task($task->customer_id, $task->executant_id, $task->status);
$user = \Yii::$app->user->getIdentity();

$this->registerJsFile('/js/messenger.js');
$this->title = 'Просмотр задания';
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
              <p>
                <?= Html::encode($task->description) ?>
              </p>
            </div>

            <?php if ($task->taskHelpfulFiles): ?>
            <div class="content-view__attach">
              <h3 class="content-view__h3">Вложения</h3>
              <?php foreach($task->taskHelpfulFiles as $helpfulFile): ?>
                <a href="<?= $helpfulFile->helpful_file ?>"><?= $helpfulFile->helpful_file ?></a>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>

            <div class="content-view__location">
              <h3 class="content-view__h3">Расположение</h3>
              <div class="content-view__location-wrapper">
                <div class="content-view__map">
                  <a href="#"><img src="./img/map.jpg" width="361" height="292"
                                   alt="Москва, Новый арбат, 23 к. 1"></a>
                </div>
                <div class="content-view__address">
                  <span class="address__town">Москва</span><br>
                  <span>Новый арбат, 23 к. 1</span>
                  <p>Вход под арку, код домофона 1122</p>
                </div>
              </div>
            </div>
          </div>
          <div class="content-view__action-buttons">

            <?php $isUserAuthorOfResponse = false;

                  foreach ($task->responses as $response) {
                    if ($response->user_id === $user->id) {
                      $isUserAuthorOfResponse = true;
                      break;
                    }
                  } ?>
            <?php $action = $taskHelper->getAvailableAction($user->id, $user->role); ?>
            
            <?php if (
                      $action instanceof ExecuteAction && !$isUserAuthorOfResponse
                      || $action instanceof CancelAction
                      || $action instanceof FailAction
                      || $action instanceof AccomplishAction
                  ): ?>
            <button class="button button__big-color <?= $action->getInternalName() ?>-button open-modal"
                    type="button" data-for="<?= $action->getInternalName() ?>-form"><?= $action->getDisplayingName() ?>
            </button>
            <?php endif; ?>
          </div>
        </div>

        <?php $responseCount = count($task->responses); ?> 

        <?php if ($responseCount and $user->id === $task->customer_id || $isUserAuthorOfResponse): ?>
        <div class="content-view__feedback">
          <h2>Отклики <span>(<?= $responseCount ?>)</span></h2>
          <div class="content-view__feedback-wrapper">

          <?php foreach ($task->responses as $response): ?>

            <?php if ($response->user_id === $user->id || $user->id === $task->customer_id): ?>
            <div class="content-view__feedback-card">
              <div class="feedback-card__top">
                <a href="<?= Url::to(['users/view', 'id' => $response->user->id]) ?>"><img src="<?= $response->user->avatar ?>" width="55" height="55"></a>
                <div class="feedback-card__top--name">
                  <p><a href="<?= Url::to(['users/view', 'id' => $response->user->id]) ?>" class="link-regular"><?= Html::encode($response->user->name) ?></a></p>
                  <?php
                    $rating = 0;
                    $reviews = $response->user->executantReviews;
                    $ratesCount = 0;
                    $ratesSum = 0;

                    foreach ($reviews as $review) {
                      $ratesCount++;
                      $ratesSum += $review->rate;
                      $rating = round(($ratesSum / $ratesCount), 2);
                    }
                  ?>

                <?php $starCount =  round($rating) ?>
                <?php for($i = 1; $i <= 5; $i++): ?>

                    <span class="<?= $starCount < $i ? 'star-disabled' : '' ?>"></span>
                <?php endfor; ?>

                  <b><?= $rating ?></b>
                </div>
                <span class="new-task__time"><?= $formatter->asRelativeTime($response->date_time, strftime("%F %T")) ?></span>
              </div>
              <div class="feedback-card__content">
                <p>
                  <?= Html::encode($response->comment) ?>
                </p>
                <span><?= $response->payment ?> ₽</span>
              </div>

              <?php if ($user->id === $task->customer_id && !$response->is_refused && $task->status === Task::STATUS_NEW): ?>
              <div class="feedback-card__actions">
                <a class="button__small-color request-button button"
                   type="button" href="<?= Url::to(['tasks/start-executing', 'taskId' => $task->id, 'executantId' => $response->user_id]) ?>">Подтвердить</a>
                <a class="button__small-color refusal-button button"
                   type="button" href="<?= Url::to(['tasks/refuse-response', 'responseId' => $response->id]) ?>">Отказать</a>
              </div>
              <?php endif; ?>

            </div>
            <?php endif; ?>

          <?php endforeach; ?>

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
              <?php $passedTimeSinceSigningUp = strftime("%Y") - substr($task->customer->signing_up_date, 0, 4); ?>

              <span class="last-"><?= $passedTimeSinceSigningUp ?> года на сайте</span></p>
            <a href="<?= Url::to(['users/view', 'id' => $task->customer->id]) ?>" class="link-regular">Смотреть профиль</a>
          </div>
        </div>
        <div id="chat-container">
          <!--                    добавьте сюда атрибут task с указанием в нем id текущего задания-->
          <chat class="connect-desk__chat" task="<?= $task->id ?>"></chat>
        </div>
      </section>
