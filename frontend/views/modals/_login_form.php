<?php
/* @var $model User */

use frontend\models\User;
use yii\widgets\ActiveForm;
?>

<section class="modal enter-form form-modal" id="enter-form">
        <h2>Вход на сайт</h2>
        
        <?php $form = ActiveForm::begin([
                        'id' => 'login-form', 
                        'method' => 'post',
                        'action' => '/user/login',
                        'fieldConfig' => [
                            'template' => "{label}\n{input}\n{error}",  /*\n{error}*/         
                            'inputOptions' => ['class' => 'enter-form-email input input-middle'],
                            'errorOptions' => ['tag' => 'span', 'style' => 'color: red; margin: -30px 0 20px;'],
                            'options' => ['tag' => 'p'],
                            'labelOptions' => ['class' => 'form-modal-description'],
                            /*'addAriaAttributes' => false,*/
                        ],
                        'enableAjaxValidation' => true,
                    ]); ?>

                    <?= $form->errorSummary($model, ['header' => '']) ?>

        <?= $form->field($model, "email", [
                                /*'options' => ['tag' => false],*/
                                'inputOptions' => [
                                    'id' => 'enter-email',
                                    'type' => 'email'
                                ]
                            ]) ?> 


                            <?= $form->field($model, "password", [
                                /*'options' => ['tag' => false],*/
                                'inputOptions' => [
                                    'id' => 'enter-password'
                                ]
                            ])->passwordInput()?>

                            <button class="button" type="submit">Войти</button>
                             <?php ActiveForm::end(); ?>



        <!-- <form action="#" method="post">
            <p>
                <label class="form-modal-description" for="enter-email">Email</label>
                <input class="enter-form-email input input-middle" type="email" name="enter-email" id="enter-email">
            </p>
            <p>
                <label class="form-modal-description" for="enter-password">Пароль</label>
                <input class="enter-form-email input input-middle" type="password" name="enter-email" id="enter-password">
            </p>
            <button class="button" type="submit">Войти</button>
        </form> -->
        <button class="form-modal-close" type="button">Закрыть</button>
    </section>