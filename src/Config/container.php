<?php

/** @var \Slim\App $app */
$container = $app->getContainer();

$container[\App\Model\Students::class] = function ($c) {
    return new App\Model\Students($c->get(PDO::class));
};

$container[PDO::class] = function () use($settings) {
    $host = $settings['db']['host'];
    $dbName = $settings['db']['database'];
    $username = $settings['db']['username'];
    $password = $settings['db']['password'];
    return new PDO("mysql:host=$host; dbname=$dbName", $username, $password);
};