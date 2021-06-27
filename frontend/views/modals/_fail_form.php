<?php 

declare(strict_types=1);

use yii\widgets\ActiveForm;
use yii\helpers\Url;

?>

<section class="modal form-modal refusal-form" id="refuse-form">
  <h2>Отказ от задания</h2>
  <p>
    Вы собираетесь отказаться от выполнения задания.
    Это действие приведёт к снижению вашего рейтинга.
    Вы уверены?
  </p>
  <!-- я не знаю что это за извращение, но в задании прямо сказано 'форма', 'кнопка батн должна иметь тип submit и отправлять форму'.
        какого же убогого качества материалы интенсива...) -->
  <?php $form = ActiveForm::begin([
        'id' => 'fail-form', 
        'method' => 'post',
        'action' => Url::to(['tasks/fail']),
    ]); ?>
    <?= $form->field($model, 'task_id', [
                      'inputOptions' => [
                          'type' => 'hidden',
                          'value' => $this->params['task_id']
                      ],
                      'template' => "{input}"
                  ]) ?>
    
    <button class="button__form-modal refusal-button button"
            type="submit">Отказаться
    </button>
  <?php ActiveForm::end(); ?>
  <button class="button__form-modal button" id="close-modal"
            type="button">Отмена
    </button><!-- внес кнопку 'отмена' из формы, чтобы js срабатывал и скрывал окно, если оставить в форме - не скрывает. -->
  <button class="form-modal-close" type="button">Закрыть</button>
</section>