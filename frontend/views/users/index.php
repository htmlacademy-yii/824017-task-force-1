<?php

declare(strict_types=1);

use TaskForce\Exceptions\DateIntervalInverseException;
use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Список исполнителей';

function getPassedTimeSinceLastActivity(string $startingDate): ?string
{
    $passedTime = null;

    $dt_now = date_create();
    $startingDate = date_create($startingDate);
    $dt_diff = date_diff($startingDate, $dt_now);

    if ($dt_diff->invert) {
        throw new DateIntervalInverseException("Дата последней активности пользователя больше текущей даты");
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

?>
<?php $specializations = $searchForm->getSpecializations(); ?>

<section class="user__search">


<?php foreach ($users as $user): ?>

    <div class="content-view__feedback-card user__search-wrapper">
        <div class="feedback-card__top">
            <div class="user__search-icon">
                <a href="#"><img src="<?= $user['avatar'] ?>" width="65" height="65"></a>
                <span><?= $user['finished_tasks_count'] ?> заданий</span>
                <span><?= $user['comments_count'] ?> отзывов</span>
            </div>
            <div class="feedback-card__top--name user__search-card">
                <p class="link-name"><a href="#" class="link-regular"><?= Html::encode($user['name']) ?></a></p>

                <?php $starCount = round((float) $user['rating']) ?>

                <?php for($i = 1; $i <= 5; $i++): ?>

                    <span class="<?= $starCount < $i ? 'star-disabled' : '' ?>"></span>
                <?php endfor; ?>

                <b><?= number_format((float) $user['rating'], 2) ?></b>
                <p class="user__search-content">
                    <?= Html::encode($user['description']) ?>
                </p>
            </div>
            <span class="new-task__time"><?= 'Был на сайте ' . getPassedTimeSinceLastActivity($user['last_activity']) ?></span>
        </div>
        <div class="link-specialization user__search-link--bottom">

            <?php foreach($user['specializations'] as $specialization): ?>
                <a href="<?= Url::to(['users/index', 'specialization_id' => $specialization['id']]) ?>" class="link-regular"><?= $specialization['name'] ?></a>
            <?php endforeach; ?>
        </div>
    </div>

<?php endforeach; ?>

</section>

<section  class="search-task">
    <div class="search-task__wrapper">

        <?php $form = ActiveForm::begin([
            'id' => 'searchForm', 
            'method' => 'post',
            'options' => [
                'class' => 'search-task__form'
            ]
        ]); ?>

            <fieldset class="search-task__categories">
                <legend>Категории</legend>
                
                <?php $i = 1; ?>
                <?php foreach($specializations as $id => $name): ?>

                    <?= $form->field($searchForm, "searchedSpecializations[$i]", [
                        'template' => "{input}",
                        'options' => ['tag' => false]
                    ])->checkbox([
                        'label' => false,
                        'value' => $id,
                        'uncheck' => null,
                        'id' => "10$id",
                        'class' => 'visually-hidden checkbox__input'
                    ]) ?>
                    <?php $i++; ?>
                    <label for="10<?= $id ?>"><?= $name ?></label>

                <?php endforeach; ?> 

            </fieldset>

            <fieldset class="search-task__categories">
                <legend>Дополнительно</legend>

                <?= $form->field($searchForm, "isFreeNow", [
                    'template' => "{input}",
                    'options' => ['tag' => false]
                ])->checkbox([
                    'label' => false,
                    'value' => 1,
                    'uncheck' => null,
                    'id' => 109,
                    'class' => 'visually-hidden checkbox__input'
                ]) ?>
                <label for="109">Сейчас свободен</label>

                <?= $form->field($searchForm, "isOnline", [
                    'template' => "{input}",
                    'options' => ['tag' => false]
                ])->checkbox([
                    'label' => false,
                    'value' => 1,
                    'uncheck' => null,
                    'id' => 110,
                    'class' => 'visually-hidden checkbox__input'
                ]) ?>
                <label for="110">Сейчас онлайн</label>

                <?= $form->field($searchForm, "hasReviews", [
                    'template' => "{input}",
                    'options' => ['tag' => false]
                ])->checkbox([
                    'label' => false,
                    'value' => 0,
                    'uncheck' => null,
                    'id' => 111,
                    'class' => 'visually-hidden checkbox__input'
                ]) ?>
                <label for="111">Есть отзывы</label>

                <?= $form->field($searchForm, "isFavorite", [
                    'template' => "{input}",
                    'options' => ['tag' => false]
                ])->checkbox([
                    'label' => false,
                    'value' => 0,
                    'uncheck' => null,
                    'id' => 112,
                    'class' => 'visually-hidden checkbox__input'
                ]) ?>
                <label for="112">В избранном</label>

            </fieldset> 

            <label class="search-task__name" for="113">Поиск по имени</label>
            <?= $form->field($searchForm, 'searchedName', [
                'template' => "{input}",
                'options' => ['tag' => false],
                'inputOptions' => [
                    'class' => 'input-middle input',
                    'type' => 'search',
                    'id' => 113
                ]
            ]); ?>

            <button class="button" type="submit">Искать</button>
        <?php ActiveForm::end(); ?>

    </div>
</section>
