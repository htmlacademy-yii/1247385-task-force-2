<?php
/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
use Taskforce\Logic\Task;

$task = new Task(1);
$statuses = array_keys($task->getStatusesMap());

return [
    'title' => $faker->sentence(),
    'description' => $faker->realText(250, 2),
    'price' => $faker->numberBetween(100, 100000),
    'published_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
    'expired_at' => $faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
    'current_status' => $faker->randomElement($statuses),
    'category_id' => $faker->numberBetween(0, 15),
    'client_id' => $faker->numberBetween(0, 5),
    'worker_id' => $faker->numberBetween(0, 5),
    'city_id' => $faker->numberBetween(0, 500)
];