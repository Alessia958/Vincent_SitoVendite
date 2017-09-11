<?php

    session_start();
    require_once "Connessione.php";
    require_once "Function.php";

    if(!isset($_SESSION['Utente']) || $_SESSION['Utente'] == 'Guest'){
        $_SESSION['Utente'] = "Guest";
        header("Location: Login.php");
    }
    else{
        echo file_get_contents("Pagine/AdminInizio.xhtml");

        if (isset($_POST['Aggiungi_Prod'])){

            $nome = $_POST['nomep'];
            $descrizione = $_POST['descrizionep'];
            $prezzo = $_POST['prezzo'];
            $taglia = $_POST['Tagliap'];
            $tipo = $_POST['Tipop'];
            $foto = $_FILES;

            if (!empty($nome) && !empty($prezzo) && !empty($descrizione) && !empty($foto["picture"]["name"])) {

                $conn = new Connessione();
                $prod = new Prodotto($nome, $descrizione, $prezzo, $taglia, $tipo, $foto);
                $presente = false;

                if (empty($prod->__toString())){
                    global $presente;
                    $presente = $conn->insertProduct($prod);

                    if ($presente == true){
                        echo "<p class = 'text'>Nuovo prodotto aggiunto correttamente</p>";
                    }
                    else{
                        if($tipo == 'Zaino'){
                            $target_dir = "Pagine/Immagini/zaini/";
                        }
                        else if($tipo == 'Borsa'){
                            $target_dir = "Pagine/Immagini/borse/";
                        }
                        else if($tipo == 'Portafoglio'){
                            $target_dir = "Pagine/Immagini/portafogli/";
                        }
                        unlink($target_dir.$foto["picture"]["name"]);
                        echo "<p class = 'errore'>Prodotto già inserito</p>";
                    }

                }
                else{
                    echo $prod->__toString();
                }

            }
            else{
                echo "<p class = 'errore'>Compilare tutti i campi!</p>";
            }

            echo file_get_contents("Pagine/AdminForm.xhtml");

        }
        else{
            echo file_get_contents("Pagine/AdminForm.xhtml");
        }

        echo file_get_contents("Pagine/Footer.xhtml");

    }


