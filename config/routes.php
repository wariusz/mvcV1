<?php
use Slim\Http\Request;
use Slim\Http\Response;


$app->get('/', function (Request $request, Response $response) {
    require("view/view.php");
    return $response;
});

$app->get('/show', function (Request $request, Response $response) {
    //$name = $request->getAttribute('name');
    //$response->getBody()->write("Hello, $name");
    $config = require("config/config.php");
    require("model/model.php");
    require("controller/control.php");
    $control = new Control($config);
    $control->show();

    return $response;
});

$app->post('/add', function (Request $request, Response $response) use ($container) {
    //$config = require("config/config.php");
    //require("model/model.php");
    $data = $request->getParsedBody();
    $tab = [];
    $imie = filter_var($data['imie'], FILTER_SANITIZE_STRING);
    $nazwisko = filter_var($data['nazwisko'], FILTER_SANITIZE_STRING);
    $klasa = filter_var($data['klasa'], FILTER_SANITIZE_STRING);
    $rocznik = filter_var($data['rocznik'], FILTER_SANITIZE_NUMBER_INT);

    /** @var Model $model */
//    $model = $container->get(Model::class);
//    $model->addStudent($imie,$nazwisko,$klasa,$rocznik);//z control

    return $response;
});

$app->post('/edit', function (Request $request, Response $response) {
    //$name = $request->getAttribute('name');
    //$response->getBody()->write("Hello, $name");
    $config = require("config/config.php");
    require("model/model.php");
    require("controller/control.php");
    $control = new Control($config);
    $control->show();

    return $response;
});


