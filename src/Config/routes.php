<?php

use Slim\Http\Request;
use Slim\Http\Response;

$app->get('/', function (Request $request, Response $response) use ($container) {
    echo require __DIR__.'/../View/view.php';

});

$app->get('/show', function (Request $request, Response $response) use ($container) {
    $model = $container->get(\App\Model\Students::class);
    $tab = $model->showStudents();
    echo "<table border='1' cellpadding='3' cellspacing='0'>";

    foreach ($tab as $row) {
        echo "<tr><td>".$row["Id"]."</td><td>".$row["imie"]."</td><td>".$row["nazwisko"]."</td><td> ".$row["klasa"]."</td><td> ".$row["rocznik"]."</td></tr>";

    }
    echo "</table>";
   // echo require __DIR__.'/../View/view.php';
});

$app->get('/add', function (Request $request, Response $response) use ($container) {

    if(!isset($_GET["operation"])) {
        echo "
        <form action='add' method='GET'>
        <input name='imie' placeholder='wpisz imie' required>
        <input name='nazwisko' placeholder='wpisz nazwisko' required>
         <input name='klasa' placeholder='wpisz klasę' required>
        <input name='rocznik' type='number' placeholder='wpisz rocznik'>
        <input type='hidden' name='operation' value='add'>
        <button>dodaj</button>
        </form>";
    }
    else {
        $model = $container->get(\App\Model\Students::class);
        $imie = $_GET["imie"];
        $nazwisko = $_GET["nazwisko"];
        $klasa = $_GET["klasa"];
        $rocznik = $_GET["rocznik"];
        $model->addStudent($imie, $nazwisko, $klasa, $rocznik);
    }
});

$app->get('/delete', function (Request $request, Response $response) use ($container) {
    $model = $container->get(\App\Model\Students::class);

    if (!isset($_GET["uczniowie"])) {
        $tab =  $model->showStudents();
        echo "
            <form action='delete' method='GET'>
            <select name='uczniowie' id='ucz_id'>";
        foreach ($tab as $row) {
            echo "<option value=" . $row["nazwisko"] . ">" . $row["nazwisko"] . " " . $row["imie"] . "</option>";
        }
        echo "</select>
            <input type='hidden' name='operation' value='delete'>
            <button>Usuń</button>
            </form>";
    } else if(isset($_GET["uczniowie"])) {

        $chooseStudent = $model->oneStudent($_GET["uczniowie"]);
        $model->deleteStudent($chooseStudent["nazwisko"], $chooseStudent["Id"]);
    }
});

$app->get('/edit', function (Request $request, Response $response) use ($container){
    $model = $container->get(\App\Model\Students::class);

    if(!isset($_GET["id"])) {
        $tab = $model->showStudents(); //return array with data of students
        echo "
            <form action='edit' method='GET'>
            <select name='id' id='ucz_id'>";
        foreach ($tab as $row) {
            echo "<option value=" . $row["Id"] . ">" . $row["nazwisko"]." ". $row["imie"]."</option>";
        }
        echo "</select>
            <input type='hidden' name='operation' value='edit'>
            <button>Wybierz ucznia</button>
            </form>";
    }
    else  if(isset($_GET["id"])){
        //echo "test";
        $chooseStudent = $model->oneStudent($_GET["id"]);  //downloading data of one student
        $id = $chooseStudent["Id"];
        echo "
            <form action='editNow' method='GET' name='zapytanie'>
            <input name='imie' placeholder='wpisz imie' value=".$chooseStudent["imie"].">
            <input name='nazwisko' placeholder='wpisz nazwisko' value=".$chooseStudent["nazwisko"].">
            <input name='klasa' placeholder='wpisz klasę' value=".$chooseStudent["klasa"].">
            <input name='rocznik' type='number' placeholder='wpisz rocznik' value=".$chooseStudent["rocznik"].">
            <input type='hidden' name='id' value='$id'>
            <button>Zmień</button>
            </form><br>";
    }

});

$app->get('/editNow', function (Request $request, Response $response) use ($container){
    $model = $container->get(\App\Model\Students::class);
    $model->editStudent($_GET["imie"], $_GET["nazwisko"], $_GET["klasa"], $_GET["rocznik"], $_GET["id"]);
});
