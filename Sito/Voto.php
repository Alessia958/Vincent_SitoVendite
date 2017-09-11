<?php

    session_start();
    require_once "Connessione.php";

    $conn = (new Connessione())->connection();
    $conne = new Connessione();
    $idProdotto = $_POST['idProd'];
    $valutazione = $_POST['vota'];
    $tipo = $conn->query("SELECT Tipo FROM Prodotto WHERE IdProdotto = '$idProdotto'");
    $tipoP = $tipo->fetch_array(MYSQLI_ASSOC);
    $tryVoto = 3;
    $tipoProd = "";

    if($valutazione == 0)
    $tryVoto=4;

    if($tipoP['Tipo'] == 'Zaino'){
        $tipoProd = 'zaini';
    }

    if($tipoP['Tipo'] == 'Portafoglio'){
        $tipoProd= 'portafogli';
    }

    if($tipoP['Tipo'] == 'Borsa'){
        $tipoProd = 'borse';
    }

    if($_SESSION['Utente'] === 'Guest' || $valutazione == 0){
        header("Location: Vetrina.php?tipo=" . $tipoProd . "&tryVoto=" . $tryVoto . "");
    }
    else{

        $user = $_SESSION['Utente'];
        $userid = $conne->getUtenteId($user);

        if(isset($_POST['idProd'])){
            $votopresente = $conn->query("SELECT * FROM Valutazione WHERE IdProdotto='$idProdotto' AND Utente='$userid'");
            $ver = $votopresente->fetch_array(MYSQLI_ASSOC);

            if(!isset($ver)){
                $sql = $conn->query("INSERT INTO Valutazione(Utente,IdProdotto,Voto) VALUES ('$userid', '$idProdotto', '$valutazione')");
                $tryVoto = 1;
                header("Location: Vetrina.php?tipo=" . $tipoProd . "&tryVoto=" . $tryVoto . "");
            }
            else{
                $sql = $conn->query("UPDATE Valutazione SET Voto='$valutazione' WHERE IdProdotto='$idProdotto' AND Utente='$userid' ");
                $tryVoto = 2;
                header("Location: Vetrina.php?tipo=" . $tipoProd . "&tryVoto=" . $tryVoto . "");
            }

        }

        $conn->close();
    }