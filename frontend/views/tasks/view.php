<?php 

declare(strict_types = 1);

use yii\helpers\Html;
use yii\helpers\Url;
use TaskForce\Exceptions\DateIntervalInverseException;

function getPassedTimeSinceLastActivity(string $startingDate): ?string
{
    $passedTime = null;

    $dt_now = date_create();
    $startingDate = date_create($startingDate);
    $dt_diff = date_diff($startingDate, $dt_now);

    if ($dt_diff->invert) {
        throw new DateIntervalInverseException("Дата публикации задания больше текущей даты");
    }

    $minute_endings = [1 => 'у', 2 => 'ы', 3 => 'ы', 4 => 'ы', 5 => '', 6 => '', 7 => '', 8 => '', 9 => '', 10 => '', 11 => '', 12 => '', 13 => '', 14 => '', 15 => '', 16 => '', 17 => '', 18 => '', 19 => '', 20 => '', 21 => 'у', 22 => 'ы', 23 => 'ы', 24 => 'ы', 25 => '', 26 => '', 27 => '', 28 => '', 29 => '', 30 => '', 31 => 'у', 32 => 'ы', 33 => 'ы', 34 => 'ы', 35 => '', 36 => '', 37 => '', 38 => '', 39 => '', 40 => '', 41 => 'у', 42 => 'ы', 43 => 'ы', 44 => 'ы', 45 => '', 46 => '', 47 => '', 48 => '', 49 => '', 50 => '', 51 => 'у', 52 => 'ы', 53 => 'ы', 54 => 'ы', 55 => '', 56 => '', 57 => '', 58 => '', 59 => ''];
    $hour_endings = [1 => '', 2 => 'а', 3 => 'а', 4 => 'а', 5 => 'ов', 6 => 'ов', 7 => 'ов', 8 => 'ов', 9 => 'ов', 10 => 'ов', 11 => 'ов', 12 => 'ов', 13 => 'ов', 14 => 'ов', 15 => 'ов', 16 => 'ов', 17 => 'ов', 18 => 'ов', 19 => 'ов', 20 => 'ов', 21 => '', 22 => 'а', 23 => 'а'];
    $y = $dt_diff->y;
    $m = $dt_diff->m;
    $d = $dt_diff->d;
    $h = $dt_diff->h;
    $i = $dt_diff->i;

    $dt_yesterday = date_add($dt_now, date_interval_create_from_date_string('yesterday'));
        
    if (date_format($dt_yesterday, 'Y-m-d') === date_format($startingDate, 'Y-m-d')) {
        $passedTime = 'Вчера, в ' . date_format($startingDate, 'H:i');
    } else {

        if ($y || $m || $d) {
            $passedTime = date_format($startingDate, 'd.m.y в H:i');
        } else {

            if (!$h && !$i) {
                $passedTime = 'только что';
            } else {

                if ($h) {
                    $passedTime = $h . ' час' . $hour_endings[$h] . ' назад';
                } else {
                    $passedTime = $i . ' минут' . $minute_endings[$i] . ' назад';
                }
            }
        }
    }

    return $passedTime;
}

$this->title = 'Просмотр задания';

 ?>

      <section class="content-view">
        <div class="content-view__card">
          <div class="content-view__card-wrapper">
            <div class="content-view__header">
              <div class="content-view__headline">
                <h1><?= Html::encode($task->name) ?></h1>
                <span>Размещено в категории
                                    <a href="<?= Url::to(['tasks/index', 'specialization_id' => $task->specialization->id]) ?>" class="link-regular"><?= $task->specialization->name ?></a>
                                    <?= getPassedTimeSinceLastActivity($task->posting_date) ?></span>
              </div>
              <b class="new-task__price new-task__price--<?= $task->specialization->icon ?> content-view-price"><?= $task->payment /*А вот стоит ли кодировать вывод суммы вознаграждения, если мы при валидации формы создания задания будем проверять, чтобы значение было целым числом, а также если нам известно, что тип данных этого поля в БД - INT ? Я не закодировал.*/ ?><b> ₽</b></b>
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
            <button class=" button button__big-color response-button open-modal"
                    type="button" data-for="response-form">Откликнуться
            </button>
            <button class="button button__big-color refusal-button open-modal"
                    type="button" data-for="refuse-form">Отказаться
            </button>
            <button class="button button__big-color request-button open-modal"
                    type="button" data-for="complete-form">Завершить
            </button>
          </div>
        </div>

        <?php $responseCount = count($task->responses); ?>
        
        <?php if ($responseCount): ?>
        <div class="content-view__feedback">
          <h2>Отклики <span>(<?= $responseCount ?>)</span></h2>
          <div class="content-view__feedback-wrapper">

          <?php foreach ($task->responses as $response): ?>

            <div class="content-view__feedback-card">
              <div class="feedback-card__top">
                <a href="<?= Url::to(['users/view', 'id' => $response->user->id]) ?>"><img src="<?= $response->user->avatar /*вывод пути к картинке тоже не кодирую. Мы же сами будем создавать и сохранять в бд путь. А не пользователь.*/ ?>" width="55" height="55"></a>
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
                <span class="new-task__time"><?= getPassedTimeSinceLastActivity($response->date_time) ?></span>
              </div>
              <div class="feedback-card__content">
                <p>
                  <?= Html::encode($response->comment) ?>
                </p>
                <span><?= $response->payment ?> ₽</span>
              </div>
              <div class="feedback-card__actions">
                <a class="button__small-color request-button button"
                   type="button">Подтвердить</a>
                <a class="button__small-color refusal-button button"
                   type="button">Отказать</a>
              </div>
            </div>

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
          <chat class="connect-desk__chat"></chat>
        </div>
      </section>
