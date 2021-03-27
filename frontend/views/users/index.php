<?php

declare(strict_types=1);

use TaskForce\Exceptions\DateIntervalInverseException;
use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Список исполнителей';
$formatter = \Yii::$app->formatter;
$specializations = $searchForm->getSpecializations();
?>

<section class="user__search">
<?php foreach ($users as $user): ?>

    <div class="content-view__feedback-card user__search-wrapper">
        <div class="feedback-card__top">
            <div class="user__search-icon">
                <a href="<?= Url::to($user['avatar']) ?>"><img src="<?= $user['avatar'] ?>" width="65" height="65"></a>
                <span><?= $user['finished_tasks_count'] ?> заданий</span>
                <span><?= $user['comments_count'] ?> отзывов</span>
            </div>
            <div class="feedback-card__top--name user__search-card">
                <p class="link-name"><a href="<?= Url::to(['users/view', 'id' => $user['id']]) ?>" class="link-regular"><?= Html::encode($user['name']) ?></a></p>

                <?php $starCount = round((float) $user['rating']) ?>

                <?php for($i = 1; $i <= 5; $i++): ?>

                    <span class="<?= $starCount < $i ? 'star-disabled' : '' ?>"></span>
                <?php endfor; ?>

                <b><?= number_format((float) $user['rating'], 2) ?></b>
                <p class="user__search-content">
                    <?= Html::encode($user['description']) ?>
                </p>
            </div>
            <span class="new-task__time"><?= 'Был на сайте ' . $formatter->asRelativeTime($user['last_activity'], strftime("%F %T")) ?></span>
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
