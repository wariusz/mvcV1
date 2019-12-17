<?php

use Slim\Http\Request;
use Slim\Http\Response;

$app->get('/', function (Request $request, Response $response) {
});

$app->get('/show', function (Request $request, Response $response) use ($container) {
    $model = $container->get(\App\Model\Students::class);
    $model->showStudents();
    return $response;
});

$app->post('/add', function (Request $request, Response $response) use ($container) {
});

$app->post('/edit', function (Request $request, Response $response) {
});


