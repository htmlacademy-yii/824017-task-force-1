<?php

declare(strict_types=1);

use yii\widgets\{ActiveForm, ListView};
use yii\helpers\{Html, Url};

$this->title = 'Список заданий';
$specializations = $searchForm->getSpecializations();
$specializationsCount = count($specializations);
?>

<section class="new-task">
    <div class="new-task__wrapper">
        <h1>Новые задания</h1>
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '/partials/_task',
            'layout' => "{summary}\n{items}\n</div>\n</div>\n"
                . '<div class="new-task__pagination">'
                . "{pager}",
            'pager' => [
                'activePageCssClass' => 'pagination__item--current',
                'pageCssClass' => 'pagination__item',
                'options' => [
                    'class' => 'new-task__pagination-list'
                ],
                'prevPageCssClass' => 'pagination__item pagination__item__zero_opacity',
                'prevPageLabel' => 'prev',
                'nextPageCssClass' => 'pagination__item pagination__item__zero_opacity',
                'nextPageLabel' => 'next',
            ]
        ]) ?>

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
                    'id' => $id,
                    'class' => 'visually-hidden checkbox__input'
                ]) ?>
                <?php $i++; ?>
                <label for="<?= $id ?>"><?= $name ?></label>

                <?php endforeach; ?>

        </fieldset>

        <fieldset class="search-task__categories">
            <legend>Дополнительно</legend>

            <?= $form->field($searchForm, "hasNoResponses", [
                'template' => "{input}",
                'options' => ['tag' => false]
            ])->checkbox([
                'label' => false,
                'value' => 1,
                'uncheck' => null,
                'id' => ($specializationsCount + 1),
                'class' => 'visually-hidden checkbox__input'
            ]) ?>
            <label for="<?= ($specializationsCount + 1) ?>">
                Без откликов
            </label>

            <?= $form->field($searchForm, "hasNoLocation", [
                'template' => "{input}",
                'options' => ['tag' => false]
            ])->checkbox([
                'label' => false,
                'value' => 1,
                'uncheck' => null,
                'id' => ($specializationsCount + 2),
                'class' => 'visually-hidden checkbox__input'
            ]) ?>
            <label for="<?= ($specializationsCount + 2) ?>">
                Удаленная работа
            </label>

        </fieldset>

        <label class="search-task__name" for="<?= ($specializationsCount + 3) ?>">
            Период
        </label>
        <?= $form->field($searchForm, "postingPeriod", [
            'template' => "{input}",
            'options' => ['tag' => false]
        ])->dropDownList([
            'day' => 'За день',
            'month' => 'За месяц'
        ], [
            'class' => 'multiple-select input',
            'id' => ($specializationsCount + 3),
            'size' => 1,
            'prompt' => [
                'text' => 'За неделю',
                'options' => ['value' => 'week']
            ]
        ]); ?>

        <label class="search-task__name" for="<?= ($specializationsCount + 4) ?>">
            Поиск по названию
        </label>
        <?= $form->field($searchForm, 'searchedName', [
            'template' => "{input}",
            'options' => ['tag' => false],
            'inputOptions' => [
                'class' => 'input-middle input',
                'type' => 'search',
                'id' => ($specializationsCount + 4)
            ]
        ]); ?>

        <button class="button" type="submit">Искать</button>
        <?php ActiveForm::end(); ?>

    </div>
</section>
