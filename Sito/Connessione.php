<?php

    require_once "Prodotto.php";
    require_once "Registrazione.php";

    class Connessione{

        private $server;
        private $database;
        private $username;
        private $password;

        function __construct(){
            $this->server = "localhost";
            $this->database = "vincent";
            $this->username = "root";
            $this->password= "";
        }

        function connection(){
            mysqli_report(MYSQLI_REPORT_STRICT);

            try{
                $mysqli = new mysqli($this->server, $this->username, $this->password, $this->database);
            }
            catch(mysqli_sql_exception $exc){
                $_SESSION['Utente'] = 'Guest';
                echo file_get_contents("Pagine/ContattiInizio.xhtml");
                echo "<p class = 'errore'>Si è verificato un problema, provare a contattare il gestore del sito ai seguenti <span xml:lang=\"en\">link</span></p>";
                echo file_get_contents("Pagine/Contatti.xhtml");
                echo file_get_contents("Pagine/Footer.xhtml");
                exit;
            }

            return $mysqli;
        }

        function insertProduct($prod){
            $connessione = $this->connection();

            $sql = "INSERT INTO Prodotto (Nome, Descrizione, Prezzo, Taglia, Tipo, Foto)
                      VALUES ('" . $prod->getNome() . "','" . $prod->getDescrizione() . "'," . $prod->getPrezzo() . ",
                            '" . $prod->getTaglia() . "','" . $prod->getTipo() . "','" . $prod->getFoto() . "')";

            $result2 = $connessione->query(" SELECT IdProdotto, Foto FROM Prodotto WHERE Nome = '" . $prod->getNome() . "' ");
            $row2 = $result2->fetch_assoc();

            if (isset($row2)){
                $connessione->close();
                return false;
            }

            if ($connessione->query($sql) == TRUE) {
                $connessione->close();
                return true;
            }
            else{
                echo $connessione->error . "<br>";
            }

            $connessione->close();
        }

        function deleteProduct($id){
            $connessione = $this->connection();
            $fotoDeleteQuery = $connessione->query("SELECT Foto FROM Prodotto WHERE IdProdotto = $id");
            $sql = "DELETE FROM Prodotto WHERE IdProdotto =	$id";

            if($connessione->query($sql)){
                $fotoDelete = $fotoDeleteQuery->fetch_array(MYSQLI_ASSOC);
                $fotoDel = $fotoDelete['Foto'];
                unlink($fotoDel);
                return 1;
            }
            else{
                return 2;
            }
        }

        function getUtente2($username){
            $connessione = $this->connection();
            $check = false;
            $sql1 = "SELECT Username FROM Administrator WHERE Username='".$username."'";
            $result1 = $connessione->query($sql1);

            while($row1 = $result1->fetch_assoc()){

                if ($row1['Username'] === $username){
                    $check = true;
                }

            }

            $sql2 = "SELECT Username FROM Utente WHERE Username='$username'";
            $result2 = $connessione->query($sql2);

            while ($row2 = $result2->fetch_assoc()){

                if ($row2['Username'] === $username){
                    $check = true;
                }

            }

            $connessione->close();
            return $check;
        }

        function insertUtente($reg){
            $connessione = $this->connection();

            if($this->getUtente2($reg->getUsername())){
                return false;
            }

            $sql = "INSERT INTO Utente (Username,Email,Nome,Cognome,Password,Citta,Via,Civico,Cap)
                VALUES ('".$reg->getUsername()."','".$reg->getEmail()."','".$reg->getNome()."','".$reg->getCognome()."','".$reg->getPassword()."','"
                .$reg->getCitta()."','".$reg->getVia()."','".$reg->getCivico()."',".$reg->getCap().")";

            if ($connessione->query($sql) == TRUE){
                $connessione->close();
                return true;
            }
            else{
                echo $connessione->error;
                $connessione->close();
                return false;
            }
        }

        function getUtente($username, $password){
            $cond = 0;
            $connessione = $this->connection();
            $username = $connessione->real_escape_string($username);
            $password = $connessione->real_escape_string($password);
            $sql1 = "SELECT Username, Password FROM Administrator WHERE Username='".$username."'";
            $result1 = $connessione->query($sql1);

            while($row1 = $result1->fetch_assoc()){

                if ($row1['Username'] === $username && $row1['Password'] === hash("sha1", $password)){
                    $cond = 2;
                }

            }

            if($cond != 2){
                $sql2 = "SELECT Username, Password FROM Utente WHERE Username='$username'";
                $result2 = $connessione->query($sql2);

                while ($row2 = $result2->fetch_assoc()){

                    if ($row2['Username'] === $username && $row2['Password'] === hash("sha1", $password)){
                        $cond = 1;
                    }

                }
            }

            $connessione->close();
            return $cond;
        }

        function getUtenteId($username){
            $connessione = $this->connection();
            $sql1 = "SELECT IdUtente FROM Utente WHERE Username='".$username."'";
            $result1 = $connessione->query($sql1);
            $row = $result1->fetch_assoc();
            $connessione->close();
            return $row['IdUtente'];
        }

        function insertCarrello($user,$idprodotto,$quantita){
            $connessione = $this->connection();
            $presente = $connessione->query("SELECT IdProdotto FROM Carrello WHERE IdProdotto ='$idprodotto' AND IdUtente='$user' ");
            $ver = $presente->fetch_array(MYSQLI_ASSOC);

            if(isset($ver)){
                $connessione->query("UPDATE Carrello SET Quantita=Quantita+1  WHERE IdProdotto =$idprodotto AND IdUtente=$user");
            }
            else{
                $inserisci = "INSERT INTO Carrello (IdUtente, IdProdotto,Quantita)VALUES ($user,$idprodotto,$quantita)";
                $connessione->query($inserisci);
            }

            $connessione->close();
        }

        function delCarrelloAll($user){
            $connessione = $this->connection();
            $connessione->query("DELETE FROM Carrello WHERE IdUtente=$user");
            $connessione->close();
        }

        function delCarrello($user,$idprodotto){
            $connessione = $this->connection();
            $presente = $connessione->query("SELECT IdProdotto FROM Carrello WHERE IdProdotto =$idprodotto AND IdUtente=$user ");

            if($presente){
                $connessione->query("UPDATE Carrello SET Quantita=Quantita-1  WHERE IdProdotto =$idprodotto AND IdUtente=$user");
            }

            $qtprodotto = $connessione->query("SELECT Quantita FROM Carrello WHERE IdProdotto =$idprodotto AND IdUtente=$user");
            $qt = $qtprodotto->fetch_array(MYSQLI_ASSOC);

            if($qt['Quantita']<1){
                $connessione->query("DELETE FROM Carrello WHERE IdProdotto =$idprodotto AND IdUtente=$user");
            }

            $connessione->close();

        }
    }
