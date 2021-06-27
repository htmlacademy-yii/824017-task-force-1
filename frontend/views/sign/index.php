<?php

declare(strict_types = 1);

use yii\widgets\ActiveForm;

$this->title = 'Регистрация аккаунта';
$cities = $model->getCities();
?>

<section class="registration__user">
    <h1>Регистрация аккаунта</h1>
    <div class="registration-wrapper">
        <?php $form = ActiveForm::begin([
            'id' => 'signup-form',
            'method' => 'post',
            'options' => [
                'class' => 'registration__user-form form-create'
            ],
            'validationStateOn' => 'input',
            'errorCssClass' => 'input-danger',
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
                'options' => ['style' => 'margin-bottom: 27px'],
                'inputOptions' => [
                    'class' => 'input textarea',
                    'style' => 'width: 328px; margin-top: 12px; margin-bottom: 0px;',
                ],
                'errorOptions' => ['tag' => 'span'],
                'labelOptions' => ['class' => null],
            ]
        ]); ?>

            <?= $form->field($model, "email", [
                'inputOptions' => [
                    'id' => 16,
                    'rows' => 1
                ]
            ])->textArea() ?>

            <?= $form->field($model, "name", [
                'inputOptions' => [
                    'id' => 17,
                    'rows' => 1
                ]
            ])->textArea() ?>

            <?= $form->field($model, "city_id")->dropDownList($cities, [
                'class' => 'multiple-select input town-select registration-town',
                'id' => 18,
                'size' => 1,
                'style' => 'width: 360px; margin-top: 12px; margin-bottom: 0px;'
            ]); ?>
            <?= $form->field($model, "password", [
                'inputOptions' => [
                    'id' => 19,
                    'style' => 'width: 328px; margin-top: 12px; margin-bottom: 5px;'
                ]
            ])->passwordInput()?>

            <button class="button button__registration" type="submit">Cоздать аккаунт</button>
        <?php ActiveForm::end(); ?>
    </div>
</section>
