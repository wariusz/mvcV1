<?php

class Control{

    public function __construct($config)
    {
        $this->obiekt = new Model($config);
    }
    public function show(){

        $tab = $this->obiekt->showStudents();
        echo "<table border='1' cellpadding='3' cellspacing='0'>";

        foreach ($tab as $row) {
            echo "<tr><td>".$row["Id"]."</td><td>".$row["imie"]."</td><td>".$row["nazwisko"]."</td><td> ".$row["klasa"]."</td><td> ".$row["rocznik"]."</td></tr>";

        }
        echo "</table>";
    }

    public function add($imie,$nazwisko,$klasa,$rocznik){
        //$this->obiekt->addStudent($_GET["imie"], $_GET["nazwisko"], $_GET["klasa"] ,$_GET["rocznik"]);
    }

    public function delete()
    {

        if (!isset($_GET["uczniowie"])) {
            $tab = $this->obiekt->showStudents(); //return array with data of students
            echo "
            <form action='index.php' method='GET'>
            <select name='uczniowie' id='ucz_id'>";
            foreach ($tab as $row) {
                echo "<option value=" . $row["nazwisko"] . ">" . $row["nazwisko"] . " " . $row["imie"] . "</option>";
            }
            echo "</select>
            <input type='hidden' name='operation' value='delete'>
            <button>Usuń</button>
            </form>";
        } else if(isset($_GET["uczniowie"])) {

            $chooseStudent = $this->obiekt->oneStudent($_GET["uczniowie"]);
            $this->obiekt->deleteStudent($chooseStudent["nazwisko"], $chooseStudent["Id"]);
        }
    }
    function edit(){

        if(!isset($_GET["uczniowie"])) {
            $tab = $this->obiekt->showStudents(); //return array with data of students
            echo "
            <form action='index.php' method='GET'>
            <select name='uczniowie' id='ucz_id'>";
            foreach ($tab as $row) {
                echo "<option value=" . $row["nazwisko"] . ">" . $row["nazwisko"]." ". $row["imie"]."</option>";
            }
            echo "</select>
            <input type='hidden' name='operation' value='edit'>
            <button>Wybierz ucznia</button>
            </form>";
        }
        else  if(isset($_GET["uczniowie"])){
            //echo "test";
            $chooseStudent = $this->obiekt->oneStudent($_GET["uczniowie"]);  //downloading data of one student
            echo "
            <form action='index.php' method='GET' name='zapytanie'>
            <input name='imie' placeholder='wpisz imie' value=".$chooseStudent["imie"].">
            <input name='nazwisko' placeholder='wpisz nazwisko' value=".$chooseStudent["nazwisko"].">
            <input name='klasa' placeholder='wpisz klasę' value=".$chooseStudent["klasa"].">
            <input name='rocznik' type='number' placeholder='wpisz rocznik' value=".$chooseStudent["rocznik"].">
            <input type='hidden' name='operation' value='editNow'>
            <button>Zmień</button>
            </form><br>";
        }
    }

    function editNow(){
        $this->obiekt->editStudent($_GET["imie"],$_GET["nazwisko"],$_GET["klasa"], $_GET["rocznik"]);

    }
}
	
?>