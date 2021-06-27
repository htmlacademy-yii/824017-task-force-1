<?php

use TaskForce\Controllers\Task;

$existingStatuses = [Task::STATUS_NEW, Task::STATUS_CANCELED, Task::STATUS_EXECUTING, Task::STATUS_FAILED, Task::STATUS_ACCOMPLISHED];

$statusValues = [Task::STATUS_NEW, array_rand(array_flip($existingStatuses))];
$executantIdValues = [rand(1, 10), null];
$paymentValues = [rand(1, 999999), null];
$addressValues = [$faker->address(), null];

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
return [
    'customer_id' => rand(11, 20),
    'executant_id' => $executantIdValues[rand(0, 1)],
    'city_id' => rand(1, 1000),
    'specialization_id' => rand(1, 8),
    'posting_date' => $faker->dateTimeBetween('-2 days')->format('Y-m-d H:i:s'),
    'status' => array_rand(array_flip($statusValues)),
    'name' => $faker->realText(30, 1),
    'description' => $faker->realText(500, 1),
    'latitude' => $faker->latitude(),
    'longitude' => $faker->longitude(),
    'payment' => $paymentValues[rand(0, 1)],
    'deadline_date' => $faker->dateTimeBetween('now', '+15 days')->format('Y-m-d H:i:s'),
    'address' => $addressValues[rand(0, 1)],
];
