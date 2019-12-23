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
            $tab = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            return $tab;
        }

        public function addStudent($imie, $nazwisko, $klasa, $rocznik)
        {
            $stmt = $this->pdo->prepare("Insert into uczen (imie, nazwisko,klasa, rocznik) VALUES (:imie, :nazwisko,:klasa, :rocznik)");
            $stmt->bindParam(':imie', $imie, \PDO::PARAM_STR);
            $stmt->bindParam(':nazwisko', $nazwisko, \PDO::PARAM_STR);
            $stmt->bindParam(':klasa', $klasa, \PDO::PARAM_INT);
            $stmt->bindParam(':rocznik', $rocznik, \PDO::PARAM_INT);
            $stmt->execute();
            $amount = $stmt->rowCount();
            $stmt->closeCursor();
            if ($amount > 0) {
                echo "dodano " . $amount . " wierszy";
                echo "<a href='/show'>powrót</a>";
            } else {
                echo "Błąd - nie dodano danych do bazy";
                echo "<a href='/show'>powrót</a>";
            }
        }//add_student end

        public function editStudent($imie, $nazwisko, $klasa, $rocznik)
        {
            $stmt = $this->pdo->prepare("UPDATE uczen Set imie = :imie, nazwisko = :nazwisko, klasa = :klasa, rocznik = :rocznik Where nazwisko = :nazwisko");
            $stmt->bindParam(':imie', $imie);
            $stmt->bindParam(':nazwisko', $nazwisko);
            $stmt->bindParam(':klasa', $klasa);
            $stmt->bindParam(':rocznik', $rocznik);
            $stmt->execute();
            $amount = $stmt->rowCount();
            $stmt->closeCursor();
            if ($amount > 0) {
                echo "Zedytowano " . $amount . " wierszy";
                echo "<a href='/show'>powrót</a>";
            } else {
                echo "Błąd edycji danych";
                echo "<a href='/show'>powrót</a>";
            }
        }

        public function oneStudent($nazwisko)
        {
            $stmt = $this->pdo->prepare("Select * from uczen WHERE nazwisko = :nazwisko");
            $stmt->bindParam(':nazwisko', $nazwisko);
            $stmt->execute();
            $data = $stmt->fetch();
            $stmt->closeCursor();
            return $data;
        }

        public function deleteStudent($nazwisko, $id)
        {
            $stmt = $this->pdo->prepare("DELETE FROM uczen WHERE nazwisko = :nazwisko and Id = :id");
            $stmt->bindParam(':nazwisko', $nazwisko);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $amount = $stmt->rowCount();
            if ($amount > 0) {
                echo "Usunięto " . $amount . " wierszy";
                echo "<a href='/show'>powrót</a>";
            } else {
                echo "Błąd usuwanie danych";
                echo "<a href='/show'>powrót</a>";
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
