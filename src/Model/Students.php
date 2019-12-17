<?php
namespace App\Model;

class Students
{
    protected $pdo;

    // konstruktor - połaczenie z bazą danych
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }


    public function showStudents()
    {
        $stmt = $this->pdo->prepare('Select * from uczen');
        $isExist = $stmt->execute();
        $row = $stmt->rowCount();
        $tab = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $tab;
    }

    public function addStudent($imie, $nazwisko, $klasa, $rocznik)
    {
        $stmt = $this->pdo->prepare("Insert into uczen (imie, nazwisko,klasa, rocznik) VALUES (:imie, :nazwisko,:klasa, :rocznik)");
        $stmt->bindParam(':imie', $imie, PDO::PARAM_STR);
        $stmt->bindParam(':nazwisko', $nazwisko, PDO::PARAM_STR);
        $stmt->bindParam(':klasa', $klasa, PDO::PARAM_INT);
        $stmt->bindParam(':rocznik', $rocznik, PDO::PARAM_INT);
        $stmt->execute();
        $amount = $stmt->rowCount();
        $stmt->closeCursor();
        if ($amount > 0) {
            echo "dodano " . $amount . " wierszy";
        } else {
            echo "Błąd - nie dodano danych do bazy";
        }
    }//add_student end

    public function editStudent($imie, $nazwisko, $klasa, $rocznik)
    {
        $stmt = $this->pdo->prepare("UPDATE uczen Set imie = :imie, nazwisko = :nazwisko, klasa = :klasa, rocznik = :rocznik Where nazwisko = :nazwisko");
        $stmt->bindParam(':imie', $imie, PDO::PARAM_STR);
        $stmt->bindParam(':nazwisko', $nazwisko, PDO::PARAM_STR);
        $stmt->bindParam(':klasa', $klasa, PDO::PARAM_INT);
        $stmt->bindParam(':rocznik', $rocznik, PDO::PARAM_INT);
        $stmt->execute();
        $amount = $stmt->rowCount();
        $stmt->closeCursor();
        if ($amount > 0) {
            echo "Zedytowano " . $amount . " wierszy";
        } else {
            echo "Błąd edycji danych";
        }
    }

    public function oneStudent($nazwisko)
    {
        $stmt = $this->pdo->prepare("Select * from uczen WHERE nazwisko = :nazwisko");
        $stmt->bindParam(':nazwisko', $nazwisko, PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $data;
    }

    public function deleteStudent($nazwisko, $id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM uczen WHERE nazwisko = :nazwisko and Id = :id");
        $stmt->bindParam(':nazwisko', $nazwisko, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $amount = $stmt->rowCount();
        if ($amount > 0) {
            echo "Usunięto " . $amount . " wierszy";
        } else {
            echo "Błąd usuwanie danych";
        }
    }//delete_student end

    public function sprawdzId($nazwisko, $id_)
    {
        $czyZgodneDane = false;
        $tab = $this->oneStudent($nazwisko);
        if ($id_ == $tab["Id"]) {
            $czyZgodneDane = true;
        }
        return $czyZgodneDane;
    }//sprawdz_id end

}