<?php

    require_once "Connessione.php";

    $idProd = $_POST['IdProdotto'];
    $tipoProd = $_REQUEST['tipo'];

    $conn = new Connessione();
    $isDelete = $conn->deleteProduct($idProd);

    header("Location: VetrinaAdmin.php?tipo=" . $tipoProd . "&isDelete=" . $isDelete . "");
