<?php

declare(strict_types = 1);

use TaskForce\Utils\CsvToSqlConverter;

require_once 'vendor/autoload.php';

$tables = ['cities', 'users', 'users_optional_settings', 'tasks', 'notifications_history', 'responses', 'chat_messages', 'reviews', 'specializations', 'user_specialization'];

foreach ($tables as $table) {
    (new CsvToSqlConverter($table . '.csv'))->convert();
}

echo 'finished';
