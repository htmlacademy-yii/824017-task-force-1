<?php

declare(strict_types = 1);

use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;

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
                        'fieldConfig' => [
                            'template' => "{label}\n{input}\n{error}",         
                            'inputOptions' => ['class' => 'input'],
                            'errorOptions' => ['tag' => 'span'],/*,
                            'options' => ['tag' => false]*/
                            'labelOptions' => ['class' => null],/*'input-danger'*/
                            /*'addAriaAttributes' => false,*/
                        ]
                    ]); ?>


                            <?= $form->field($model, "email", [
                                /*'options' => ['tag' => false],*/
                                'inputOptions' => [
                                    'id' => 16,
                                    'class' => 'input textarea',
                                    'row' => 1,
                                ]
                            ])->textArea() ?> 


                            <?= $form->field($model, "name", [
                                /*'options' => ['tag' => false],*/
                                'inputOptions' => [
                                    'id' => 17,
                                    'class' => 'input textarea',
                                    'row' => 1,
                                ]
                            ])->textArea() ?> 

                            <?= $form->field($model, "city_id"/*, [
                                            'options' => ['tag' => false]
                                        ]*/)->dropDownList($cities, [
                                            'class' => 'multiple-select input town-select registration-town',
                                            'id' => 18,
                                            'size' => 1
                                        ]); ?>

                            <?= $form->field($model, "password", [
                                /*'options' => ['tag' => false],*/
                                'inputOptions' => [
                                    'id' => 19,
                                    'class' => 'input textarea'
                                ]
                            ])->passwordInput()?>

                            <button class="button button__registration" type="submit">Cоздать аккаунт</button>
                            <?php ActiveForm::end(); ?>
                </div>
            </section>

        