<?php 

declare(strict_types=1);

use yii\widgets\ActiveForm;
use yii\helpers\Url;

?>

<section class="modal response-form form-modal" id="response-form">
  <h2>Отклик на задание</h2>
  <?php $form = ActiveForm::begin([
          'id' => 'response-form', 
          'method' => 'post',
          'action' => Url::to(['tasks/add-response']),
          'fieldConfig' => [
              'template' => "{label}\n{input}\n{error}",
              'options' => ['tag' => 'p'],
              'errorOptions' => ['tag' => 'span', 'style' => 'color: red']
          ]
      ]); ?>
    <?= $form->field($model, 'payment', [
                    'inputOptions' => [
                        'id' => 'response-payment',
                        'class' => 'response-form-payment input input-middle input-money'
                    ],
                    'labelOptions' => ['class' => 'form-modal-description']
                ]) ?>
    <?= $form->field($model, 'comment', [
                    'inputOptions' => [
                        'id' => 'response-comment',
                        'class' => 'input textarea',
                        'rows' => 4,
                        'placeholder' => 'Place your text'
                    ],
                    'labelOptions' => ['class' => 'form-modal-description']
                ])->textArea() ?>
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
