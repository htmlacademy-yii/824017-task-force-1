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

$this->title = 'Просмотр профиля пользователя';

 ?>

    <section class="content-view">
        <div class="user__card-wrapper">
            <div class="user__card">
                <img src="<?= Html::encode($user->avatar) ?>" width="120" height="120" alt="Аватар пользователя">
                 <div class="content-view__headline">
                    <h1><?= Html::encode($user->name) ?></h1>
                     <p>Россия, <?= $user->city->name ?>, 30 лет</p>
                    <div class="profile-mini__name five-stars__rate">
                      <?php
                        $reviews = $user->executantReviews;
                        $rating = 0;

                        if (!empty($reviews)) {
                            $ratesCount = 0;
                            $ratesSum = 0;

                            foreach ($reviews as $review) {
                              $ratesCount++;
                              $ratesSum += $review->rate;
                            } 

                            $rating = round(($ratesSum / $ratesCount), 2);
                        } ?>
                                
                        <?php $starCount =  round($rating) ?>

                        <?php for($i = 1; $i <= 5; $i++): ?>
                            <span class="<?= $starCount < $i ? 'star-disabled' : '' ?>"></span>
                        <?php endfor; ?>
                        <b><?= $rating ?></b>
                    </div>
                    <b class="done-task">Выполнил <?= count($user->executantReviews) ?> заказов</b>

                    <?php $reviews = $user->executantReviews;
                          $commentCount = 0;

                          foreach ($reviews as $review) {

                            if ($review->comment) {
                              $commentCount++;
                            }
                          }?>

                    <b class="done-review">Получил <?= $commentCount ?> отзывов</b>
                 </div>
                <div class="content-view__headline user__card-bookmark user__card-bookmark--current">
                    <span>Был на сайте <?= getPassedTimeSinceLastActivity($user->last_activity) ?></span>
                     <a href="#"><b></b></a>
                </div>
            </div>
            <div class="content-view__description">
                <p><?= Html::encode($user->description) ?></p>
            </div>
            <div class="user__card-general-information">
                <div class="user__card-info">
                    <h3 class="content-view__h3">Специализации</h3>
                    <div class="link-specialization">

                      <?php foreach ($user->specializations as $specialization): ?>

                        <a href="<?= Url::to(['tasks/index', 'specialization_id' => $specialization->id]) ?>" class="link-regular"><?= $specialization->name ?></a>
                      <?php endforeach; ?>

                    </div>
                    <h3 class="content-view__h3">Контакты</h3>
                    <div class="user__card-link">
                        <a class="user__card-link--tel link-regular" href="#"><?= Html::encode($user->phone) ?></a>
                        <a class="user__card-link--email link-regular" href="#"><?= Html::encode($user->email) ?></a>
                        <a class="user__card-link--skype link-regular" href="#"><?= Html::encode($user->skype) ?></a>
                    </div>
                 </div>
                <div class="user__card-photo">
                    <h3 class="content-view__h3">Фото работ</h3>

                    <?php foreach($user->usersAccomplishedTasksPhotos as $photo): ?>
                      <a href="<?= Url::to($photo->accomplished_task_photo) ?>"><img src="<?= $photo->accomplished_task_photo ?>" width="85" height="86" alt="Фото работы"></a>
                    <?php endforeach ?>
                </div>
            </div>
        </div>

        <?php if ($commentCount): ?>
        <div class="content-view__feedback">
            <h2>Отзывы<span>(<?= $commentCount ?>)</span></h2>
            <div class="content-view__feedback-wrapper reviews-wrapper">

              <?php foreach ($reviews as $review): ?>
                <?php if ($review->comment): ?>
                <div class="feedback-card__reviews">
                    <p class="link-task link">Задание <a href="<?= Url::to(['tasks/view', 'id' => $review->task->id]) ?>" class="link-regular">«<?= Html::encode($review->task->name) ?>»</a></p>
                    <div class="card__review">
                        <a href="#"><img src="<?= $review->customer->avatar ?>" width="55" height="54"></a>
                        <div class="feedback-card__reviews-content">
                            <p class="link-name link"><a href="<?= Url::to(['users/view', 'id' => $review->customer->id]) ?>" class="link-regular">
                              <?= Html::encode($review->customer->name) ?></a></p>
                            <p class="review-text">
                                <?= Html::encode($review->comment) ?>
                            </p>
                        </div>
                        <div class="card__review-rate">

                            <p class="<?= $review->rate > 3 ? 'five' : 'three' ?>-rate big-rate"><?= $review->rate ?><span></span></p>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
              <?php endforeach; ?>

            </div>
        </div>
      <?php endif; ?>
    </section>
    <section class="connect-desk">
        <div class="connect-desk__chat">

        </div>
    </section>
