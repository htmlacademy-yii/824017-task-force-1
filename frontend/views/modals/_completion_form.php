<?php 

declare(strict_types=1);

use yii\widgets\ActiveForm;
use yii\helpers\Url;

?>

<section class="modal completion-form form-modal" id="complete-form">
  <h2>Завершение задания</h2>
  <p class="form-modal-description">Задание выполнено?</p>
  <?php $form = ActiveForm::begin([
        'id' => 'completion-form', 
        'method' => 'post',
        'action' => Url::to(['tasks/accomplish']),
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}",
            'options' => ['tag' => null],
            'errorOptions' => ['tag' => 'span']
        ]
    ]); ?>
    <?= $form->field($model, 'completion', [
                  'labelOptions' => ['class' => 'completion-label completion-label--yes'],
                  'template' => "{input}"
              ])->radioList([1 => 'Да', 2 => 'Возникли проблемы'], [
                  'unselect' => null,
                  'item' => function ($index, $label, $name, $checked, $value) {
                      return '<input class="visually-hidden completion-input '
                          . 'completion-input--' . ($value === 1 ? 'yes' : 'difficult') . '" '
                          . 'id="completion-radio--' . ($value === 1 ? 'yes' : 'yet') . '" '
                          . 'type="radio" name="' . $name . '" value="' . $value . '">'
                          . '<label class="completion-label completion-label--'
                          . ($value === 1 ? 'yes' : 'difficult') . '" for="' . 'completion-radio--'
                          . ($value === 1 ? 'yes' : 'yet') . '">'. $label . '</label>';
                  }
              ]) ?>           
    <?= $form->field($model, 'comment', [
                  'options' => ['tag' => 'p'],
                  'inputOptions' => [
                      'id' => 'completion-comment',
                      'class' => 'input textarea',
                      'rows' => 4,
                      'placeholder' => 'Place your text'
                  ],
                  'labelOptions' => ['class' => 'form-modal-description'],
                  'template' => "{label}\n{input}"
              ])->textArea() ?>
    <p class="form-modal-description">
      Оценка
    <div class="feedback-card__top--name completion-form-star">
      <span class="star-disabled"></span>
      <span class="star-disabled"></span>
      <span class="star-disabled"></span>
      <span class="star-disabled"></span>
      <span class="star-disabled"></span>
    </div>
    </p>
    <?= $form->field($model, 'rate', [
                  'inputOptions' => [
                      'id' => 'rating',
                      'type' => 'hidden'
                  ],
                  'template' => "{input}"
              ]) ?>
    <?= $form->field($model, 'task_id', [
                    'inputOptions' => [
                        'type' => 'hidden',
                        'value' => $this->params['task_id']
                    ],
                    'template' => "{input}"
                ]) ?>
    <button class="button modal-button" type="submit">Отправить</button>
  <?php ActiveForm::end(); ?>
  <button class="form-modal-close" type="button">Закрыть</button>
</section>
