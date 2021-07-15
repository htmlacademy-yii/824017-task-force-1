<?php

declare(strict_types=1);

use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\web\View;
use frontend\assets\{AppAsset, UploadFileAsset};


UploadFileAsset::register($this);
$specializations = $taskCreatingForm->getSpecializations();

$this->title = 'Добавление задания';

?>

<section class="create__task">
    <h1>Публикация нового задания</h1>
    <div class="create__task-main">
    <?php $form = ActiveForm::begin([
        'id' => 'task-form',
        'method' => 'post',
        'action' => Url::to(['tasks/add']),
        'options' => [
            'class' => 'create__task-form form-create'
        ],
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}",
            'errorOptions' => ['tag' => 'span']
        ],
        'errorCssClass' => 'input-danger',
        'validationStateOn' => 'input',
    ]) ?>
    <?= $form->field($taskCreatingForm, "name", [
        'options' => ['style' => 'margin-top: 29px;'],
        'inputOptions' => [
            'class' => 'input textarea',
            'rows' => 1,
            'placeholder' => 'Повесить полку',
            'style' => 'width: 488px; margin-top: 12px; margin-bottom: 2px;'
        ]
    ])->textArea() ?>
    <?= $form->field($taskCreatingForm, "description", [
        'options' => ['style' => 'margin-top: 28px;'],
        'inputOptions' => [
            'class' => 'input textarea',
            'rows' => 7,
            'placeholder' => 'Place your text',
            'style' => 'width: 488px; height: 128.5px; margin-top: 12px; margin-bottom: 2px;'
        ]
    ])->textArea() ?>
    <?= $form->field($taskCreatingForm, "specialization_id", [
        'options' => ['style' => 'margin-top: 27px; margin-bottom: 0;'],
        'inputOptions' => ['style' => 'width: 520px; margin-top: 12px; margin-bottom: 7px;']
    ])->dropDownList($specializations, [
        'class' => 'multiple-select input multiple-select-big',
        'size' => 1
    ]) ?>
    <label>Файлы</label>
    <span>Загрузите файлы, которые помогут исполнителю лучше выполнить или оценить работу</span>
    <div class="create__file">
        <span>Добавить новый файл</span>
    </div>
    <?= $form->field($taskCreatingForm, "address", [
            'options' => ['style' => 'margin-top: 29px;'],
            'template' =>
                "{label}\n{input}\n"
                . "<span>Укажите адрес исполнения, если задание требует присутствия</span>",
            'inputOptions' => [
                'id' => 13,
                'class' => 'input-navigation input-middle input',
                'placeholder' => 'Санкт-Петербург, Калининский район',
                'type' => 'search',
                'style' => 'width: 520px; margin-top: 12px; margin-bottom: 2px;',
            ]
        ]) ?>
    <div class="create__price-time">
    <?= $form->field($taskCreatingForm, "payment", [
        'options' => ['class' => 'create__price-time--wrapper', 'style' => 'margin-top: 0'],
        'inputOptions' => [
            'class' => 'input textarea input-money',
            'rows' => 1,
            'placeholder' => '1000',
            'style' => 'width: 198px'
        ]
    ])->textArea() ?>
    <?= $form->field($taskCreatingForm, "deadline_date", [
        'options' => ['class' => 'create__price-time--wrapper', 'style' => 'margin-top: 0'],
        'inputOptions' => [
            'class' => 'input-middle input input-date',
            'type' => 'date',
            'style' => 'width: 196px; height: 18px; background-image: none'
        ]
    ]) ?>
    </div>
    <?php ActiveForm::end(); ?>
    <div class="create__warnings">
        <div class="warning-item warning-item--advice">
            <h2>Правила хорошего описания</h2>
            <h3>Подробности</h3>
            <p>Друзья, не используйте случайный<br>
                контент – ни наш, ни чей-либо еще. Заполняйте свои
                макеты, вайрфреймы, мокапы и прототипы реальным
                содержимым.</p>
            <h3>Файлы</h3>
            <p>Если загружаете фотографии объекта, то убедитесь,
                что всё в фокусе, а фото показывает объект со всех
                ракурсов.</p>
        </div>
        <?php if ($taskCreatingForm->hasErrors()): ?>
        <div class="warning-item warning-item--error">
            <h2>Ошибки заполнения формы</h2>
            <?php $labels = $taskCreatingForm->attributeLabels(); ?>
            <?php foreach ($taskCreatingForm->errors as $attribute => $message): ?>
                <h3><?= $labels[$attribute] ?></h3>
                <p><?= $message[0] ?></p>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
    </div>
    <button form="task-form" class="button" type="submit">Опубликовать</button>
</section>
