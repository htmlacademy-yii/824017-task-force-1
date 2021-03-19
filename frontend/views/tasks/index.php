<?php

declare(strict_types=1);

use TaskForce\Exceptions\DateIntervalInverseException;

function getPassedTimeSinceLastActivity(string $startingDate): ?string
{
    $passedTime = null;

    $dt_now = date_create();
    $startingDate = date_create($startingDate);
    $dt_diff = date_diff($startingDate, $dt_now);

    if ($dt_diff->invert) {
        throw new DateIntervalInverseException("Дата публикации задания больше текущей даты");
    }

    $minute_endings = [1 => 'у', 2 => 'ы', 3 => 'ы', 4 => 'ы', 5 => '', 6 => '', 7 => '', 8 => '', 9 => '', 10 => '', 11 => '', 12 => '', 13 => '', 14 => '', 15 => '', 16 => '', 17 => '', 18 => '', 19 => '', 20 => '', 21 => 'у', 22 => 'ы', 23 => 'ы', 24 => 'ы', 25 => '', 26 => '', 27 => '', 28 => '', 29 => '', 30 => '', 31 => 'у', 32 => 'ы', 33 => 'ы', 34 => 'ы', 35 => '', 36 => '', 37 => '', 38 => '', 39 => '', 40 => '', 41 => 'у', 42 => 'ы', 43 => 'ы', 44 => 'ы', 45 => '', 46 => '', 47 => '', 48 => '', 49 => '', 50 => '', 51 => 'у', 52 => 'ы', 53 => 'ы', 54 => 'ы', 55 => '', 56 => '', 57 => '', 58 => '', 59 => ''];
    $hour_endings = [1 => '', 2 => 'а', 3 => 'а', 4 => 'а', 5 => 'ов', 6 => 'ов', 7 => 'ов', 8 => 'ов', 9 => 'ов', 10 => 'ов', 11 => 'ов', 12 => 'ов', 13 => 'ов', 14 => 'ов', 15 => 'ов', 16 => 'ов', 17 => 'ов', 18 => 'ов', 19 => 'ов', 20 => 'ов', 21 => '', 22 => 'а', 23 => 'а'];
    $y = $dt_diff->y;
    $m = $dt_diff->m;
    $d = $dt_diff->d;
    $h = $dt_diff->h;
    $i = $dt_diff->i;

    $dt_yesterday = date_add($dt_now, date_interval_create_from_date_string('yesterday'));
        
    if (date_format($dt_yesterday, 'Y-m-d') === date_format($startingDate, 'Y-m-d')) {
        $passedTime = 'Вчера, в ' . date_format($startingDate, 'H:i');
    } else {

        if ($y || $m || $d) {
            $passedTime = date_format($startingDate, 'd.m.y в H:i');
        } else {

            if (!$h && !$i) {
                $passedTime = 'только что';
            } else {

                if ($h) {
                    $passedTime = $h . ' час' . $hour_endings[$h] . ' назад';
                } else {
                    $passedTime = $i . ' минут' . $minute_endings[$i] . ' назад';
                }
            }
        }
    }

    return $passedTime;
}
?>

<section class="new-task">
    <div class="new-task__wrapper">
        <h1>Новые задания</h1>
        
        
        <?php foreach ($tasks as $task): ?>
        
            <div class="new-task__card">
                <div class="new-task__title">
                    <a href="#" class="link-regular"><h2><?= htmlspecialchars($task['name']) ?></h2></a>
                    <a  class="new-task__type link-regular" href="#"><p><?= htmlspecialchars($task['specialization']['name']) ?></p></a>
                </div>
                <div class="new-task__icon new-task__icon--<?= htmlspecialchars($task['specialization']['icon']) ?>"></div>
                <p class="new-task_description">
                    <?= htmlspecialchars($task['description']) ?>
                </p>
                <b class="new-task__price new-task__price--<?= htmlspecialchars($task['specialization']['icon']) ?>"><?= htmlspecialchars($task['payment']) ?><b> ₽</b></b>
                <p class="new-task__place">Санкт-Петербург, Центральный район</p><!-- как я понял, это реализуется в будущих заданиях посредством geocoder API -->
                <span class="new-task__time"><?= getPassedTimeSinceLastActivity($task['posting_date']) ?></span>
            </div>

        <?php endforeach; ?>
        
        <!-- у <fieldset>-ов почему-то рамка не появляется, в отличии от файла верстки /frontend/web/browse.html 
        не смог понять почему... -->

    </div>
    <div class="new-task__pagination">
        <ul class="new-task__pagination-list">
            <li class="pagination__item"><a href="#"></a></li>
            <li class="pagination__item pagination__item--current">
                <a>1</a></li>
            <li class="pagination__item"><a href="#">2</a></li>
            <li class="pagination__item"><a href="#">3</a></li>
            <li class="pagination__item"><a href="#"></a></li>
        </ul>
    </div>
</section>
<section  class="search-task">
    <div class="search-task__wrapper">
        <form class="search-task__form" name="test" method="post" action="#">
            <fieldset class="search-task__categories">
                <legend>Категории</legend>
                <input class="visually-hidden checkbox__input" id="1" type="checkbox" name="" value="" checked>
                <label for="1">Курьерские услуги </label>
                <input class="visually-hidden checkbox__input" id="2" type="checkbox" name="" value="" checked>
                <label  for="2">Грузоперевозки </label>
                <input class="visually-hidden checkbox__input" id="3" type="checkbox" name="" value="">
                <label  for="3">Переводы </label>
                <input class="visually-hidden checkbox__input" id="4" type="checkbox" name="" value="">
                <label  for="4">Строительство и ремонт </label>
                <input class="visually-hidden checkbox__input" id="5" type="checkbox" name="" value="">
                <label  for="5">Выгул животных </label>
            </fieldset>
            <fieldset class="search-task__categories">
                <legend>Дополнительно</legend>
                <input class="visually-hidden checkbox__input" id="6" type="checkbox" name="" value="">
                <label for="6">Без откликов</label>
               <input class="visually-hidden checkbox__input" id="7" type="checkbox" name="" value="" checked>
                <label for="7">Удаленная работа </label>
            </fieldset>
           <label class="search-task__name" for="8">Период</label>
               <select class="multiple-select input" id="8"size="1" name="time[]">
                <option value="day">За день</option>
                <option selected value="week">За неделю</option>
                <option value="month">За месяц</option>
            </select>
            <label class="search-task__name" for="9">Поиск по названию</label>
                <input class="input-middle input" id="9" type="search" name="q" placeholder="">
            <button class="button" type="submit">Искать</button>
        </form>
    </div>
</section>
