<ol>
    <li>
         Создайте базу данных:<br>  
        <pre><code>CREATE DATABASE task_force_1
            DEFAULT CHARACTER SET utf8
            DEFAULT COLLATE UTF8_GENERAL_CI;
USE task_force_1;</code></pre>
    </li>
    <li>
         Накатите миграцию:<br>
        <pre><code>php yii migrate</code></pre>
    </li>
    <li>
        Загрузите дамп заданий:
        <pre><code>php yii fixture/load Task</code></pre>
    </li>
</ol>