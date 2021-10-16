<?php 

declare(strict_types=1);

use yii\helpers\Url;

?>

<section class="modal form-modal refusal-form" id="cancel-form">
  <h2>Отмена задания</h2>
  <p style="background-color: green">
    Задание будет отменено. Вы уверены?
  </p>
  <a class="button__form-modal refusal-button button"
          href="<?= Url::to(['tasks/cancel', 'taskId' => $this->params['task_id']]) ?>" type="button">Да
  </a>
  <button class="form-modal-close" type="button">Закрыть</button>
</section>
