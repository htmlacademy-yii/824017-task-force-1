<?php 

declare(strict_types=1);

use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use frontend\assets\UploadFileAsset;
use yii\web\View;
use frontend\assets\AppAsset;

/*use yii\helpers\Html;*/
/*Html::csrfMetaTags();*/

$this->registerJsFile('/js/uploadFile.js', ['depends' => [AppAsset::class]]);

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
                'template' => "{label}\n{input}\n{error}",  /*\n{error}*/         
                /*'inputOptions' => ['class' => 'enter-form-email input input-middle'],*/
                'errorOptions' => ['tag' => 'span'/*, 'class' => 'help-block help-block-error' , 'style' => 'display: block;'*/],
                'options' => ['tag' => 'p'],
                /*'labelOptions' => ['class' => null],*/
                /*'addAriaAttributes' => false,*/
            ],
            /*'validationStateOn' => 'input',*/
            'enableClientValidation' => false /*поставлено в false, чтобы имелась возможность добавлять блок с ошибками, (посредством перезагрузки страницы)*/
        ]); ?>

                <?= $form->field($taskCreatingForm, "name", [
                    'options' => ['tag' => 'div', /*'id' => 'myFieldContainer'*/],
                    'inputOptions' => [
                        'id' => 10,
                        'class' => 'input textarea',
                        'rows' => 1,
                        'placeholder' => 'Повесить полку'
                    ],
                    /*'errorOptions' => ['id' => 'nameError'],
                    'selectors' => [
                        'container' => '#task-form',
                        'input' => '#10',
                        'error' => '#nameError'
                    ],
                    'labelOptions' => ['id' => null]*/
                ])->textArea() ?>


                <?= $form->field($taskCreatingForm, "description", [
                    'options' => ['tag' => 'div'],
                    'inputOptions' => [
                        'id' => 11,
                        'class' => 'input textarea',
                        'rows' => 7,
                        'placeholder' => 'Place your text'
                    ]
                ])->textArea() ?>

                <?= $form->field($taskCreatingForm, "specialization_id", [
                                'options' => ['tag' => 'div']
                            ])->dropDownList($specializations, [
                                'class' => 'multiple-select input multiple-select-big',
                                'id' => 12,
                                'size' => 1
                            ]); ?>

                 <!-- $form->field($filesUploadingForm, "files[]", [
                    'options' => ['tag' => 'div'],
                    'inputOptions' => [
                        'id' => null,
                        'class' => 'dropzone',
                        'type' => 'hidden',
                    ],
                    'template' => "{label}\n{error}\n<div class='create__file'><span>Добавить новый файл</span>{input}</div>",
                    'labelOptions' => ['for' => null]
                ])->fileInput(['multiple' => true]); ?> -->

                <label>Файлы</label>
                        <span>Загрузите файлы, которые помогут исполнителю лучше выполнить или оценить работу</span>
                        <div class="create__file">
                            <span>Добавить новый файл</span>
<!--                          <input type="file" name="files[]" class="dropzone">-->
                        </div>

                
            <label for="13">Локация</label>
            <input class="input-navigation input-middle input" id="13" type="search" name="q" placeholder="Санкт-Петербург, Калининский район">
            <span>Укажите адрес исполнения, если задание требует присутствия</span>

            <div class="create__price-time">
            <?= $form->field($taskCreatingForm, "payment", [
                    'options' => ['class' => 'create__price-time--wrapper', 'tag' => 'div'],
                    'inputOptions' => [
                        'id' => 14,
                        'class' => 'input textarea input-money',
                        'rows' => 1,
                        'placeholder' => '1000'
                    ]
                ])->textArea() ?>

            <?= $form->field($taskCreatingForm, "deadline_date", [
                    'options' => ['class' => 'create__price-time--wrapper', 'tag' => 'div'],
                    'inputOptions' => [
                        'id' => 15,
                        'class' => 'input-middle input input-date',
                        'placeholder' => '2021-01-01',
                        'type' => 'date'
                    ]
                ]) ?>

            </div>
        <?php ActiveForm::end(); ?>

        <!-- код из верстки для информации

         <form class="create__task-form form-create" action="/" enctype="multipart/form-data" id="task-form">
            <label for="10">Мне нужно</label>
            <textarea class="input textarea" rows="1" id="10" name="" placeholder="Повесить полку"></textarea>
            <span>Кратко опишите суть работы</span>

            <label for="11">Подробности задания</label>
            <textarea class="input textarea" rows="7" id="11" name="" placeholder="Place your text"></textarea>
            <span>Укажите все пожелания и детали, чтобы исполнителям было проще соориентироваться</span>

            <label for="12">Категория</label>
            <select class="multiple-select input multiple-select-big" id="12"size="1" name="category[]">
                <option value="day">Уборка</option>
                <option selected value="week">Курьерские услуги</option>
                <option value="month">Доставка</option>
            </select>
            <span>Выберите категорию</span>

            <label>Файлы</label>
            <span>Загрузите файлы, которые помогут исполнителю лучше выполнить или оценить работу</span>
            <div class="create__file">
                <span>Добавить новый файл</span>
            !--      <input type="file" name="files[]" class="dropzone"> --
            </div>

            <label for="13">Локация</label>
            <input class="input-navigation input-middle input" id="13" type="search" name="q" placeholder="Санкт-Петербург, Калининский район">
            <span>Укажите адрес исполнения, если задание требует присутствия</span>

            <div class="create__price-time">
                <div class="create__price-time--wrapper">
                    <label for="14">Бюджет</label>
                    <textarea class="input textarea input-money" rows="1" id="14" name="" placeholder="1000"></textarea>
                    <span>Не заполняйте для оценки исполнителем</span>
                </div>
                <div class="create__price-time--wrapper">
                    <label for="15">Срок исполнения</label>
                    <input id="15"  class="input-middle input input-date" type="text" placeholder="2021-01-01">
                    <span>Укажите крайний срок исполнения</span>
                </div>
            </div>
        </form> -->
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
        