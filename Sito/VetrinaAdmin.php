<?php

    session_start();
    require_once "Connessione.php";

    if(!isset($_SESSION['Utente']) || $_SESSION['Utente'] == 'Guest'){
        $_SESSION['Utente'] = "Guest";
        header("Location: Login.php");
    }
    else{
        $conn = (new Connessione())->connection();
        $var = $_REQUEST['tipo'];
        $delete = $_REQUEST['isDelete'];
        $result = '';

        if($var == 'zaini' || $var == 'Zaino'){
            echo file_get_contents("Pagine/ZainiInizioAdmin.xhtml");
            global $result;
            $result = $conn->query("SELECT * FROM Prodotto WHERE tipo = 'Zaino'");
        }
        else if($var == 'borse' || $var == 'Borsa'){
            echo file_get_contents("Pagine/BorseInizioAdmin.xhtml");
            global $result;
            $result = $conn->query("SELECT * FROM Prodotto WHERE tipo = 'Borsa'");
        }
        else if($var == 'portafogli' || $var == 'Portafoglio'){
            echo file_get_contents("Pagine/PortafogliInizioAdmin.xhtml");
            global $result;
            $result = $conn->query("SELECT * FROM Prodotto WHERE tipo = 'Portafoglio'");
        }

        if(!$result){
            echo "Errore nella query: ". $conn->error .".";
            exit();
        }
        else{
            global $delete;

            if($delete == 1){
                echo "<p class = 'text'>Prodotto eliminato</p>";
            }
            else if($delete == 2){
                echo "<p class = 'errore'>Prodotto non eliminato</p>";
            }

            echo "<div id = 'cbutton'>
                      <a href = 'CreaProdotto.php'>
                          <button id = 'bottoneadd' type = 'button' tabindex='1'>Aggiungi Prodotto</button>
                      </a>
                    </div>
                    <div id='center'>
                    <dl id='foto'>";

            if($result->num_rows > 0){
                $tabindex = 1;
                while($row = $result->fetch_array(MYSQLI_ASSOC)){

                    echo "<dd class='imgprodotto'>
                            <img src = '" . $row['Foto'] . "' alt = '" . $row['Descrizione'] . "'/>
                            <p class = 'prod'>" . $row['Nome'] . " (" . $row['Taglia'] . ")</p>
                            <p class = 'prod'>Prezzo: " . $row['Prezzo'] . "€</p>
                            <form action='EliminaProdotto.php?tipo=" . $row['Tipo'] . "&amp;isDelete=0' method = 'post'>
                                <div>
                                    <input type = 'hidden' value = '" . $row['IdProdotto'] . "' name = 'IdProdotto'/>
                                    <input class = 'delcar' type = 'submit' value = 'Elimina prodotto' tabindex = '" .++$tabindex. "'/>
                                </div>
                            </form>
                            </dd>";

                }

                $result->free();

            }
            else{
                echo "<p class = 'text'> Nessun prodotto disponibile </p>";
            }

            echo "</dl>
                    </div>
                    <a class='aiuti' href='#breadcrump'>Torna su</a>
                    </div>";
        }

        $conn->close();

        echo file_get_contents("Pagine/Footer.xhtml");

    }























