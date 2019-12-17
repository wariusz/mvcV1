<!doctype htlm>
<html>
<head>
    <title>Html5 </title>
    <meta charset="utf-8">

    <body>
<h1>Wybierz operację do wykonania</h1>
    <?php

    if(isset($_GET["operation"])){

       if ($_GET["operation"]=="add"){
        echo "
        <form action='add' method='post'>
        <input name='imie' placeholder='wpisz imie' required>
        <input name='nazwisko' placeholder='wpisz nazwisko' required>
         <input name='klasa' placeholder='wpisz klasę' required>
        <input name='rocznik' type='number' placeholder='wpisz rocznik'>
        <input type='hidden' name='operation' value='add'>
        <button>dodaj</button>
        </form>";
        }
       elseif ($_GET['operation']=="edit"){


       }

        elseif ($_GET["operation"]=="delete"){


            if(!isset($_GET["uczniowie"])) {
                $tab = $obiekt->showStudents(); //return array with data of students

            }
        }
    }
    else
    {echo "<br> Nie wybranu żadnej operacji";}
    ?>

    <form >
        <a href="show"><input type="button" value="show"></a>
        <button name="operation" value="add">Dodaj ucznia</button>
        <button name="operation" value="edit">Edytuj ucznia</button>
        <button name="operation" value="delete">Usuń ucznia</button>
    </form>


    </body>

</head>
</html>



	
