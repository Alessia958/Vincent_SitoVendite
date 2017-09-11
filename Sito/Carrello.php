<?php

	session_start();
    require_once "Connessione.php";

    if(!isset($_SESSION['Utente'])){
        $_SESSION['Utente'] = 'Guest';
    }

    $conne = (new Connessione());
    $conn = $conne->connection();

    if($_SESSION['Utente'] === 'Guest'){
        echo file_get_contents("Pagine/CarrelloInizio.xhtml");
        echo "<div id ='content'>
                  <p class = 'errore'>Per  visualizzare il carrello è necessario fare il <span xml:lang='en'>login</span></p>
              </div>";
    }
    else{
        $template = file_get_contents("Pagine/CarrelloInizio.xhtml");
        $cercata = "<a href = \"Login.php\"><img id = \"login\" src = \"Pagine/Immagini/login2.png\" alt = \"Effettua l'accesso al tuo profilo\"/></a>";
        $sostituita = "<a href = \"Logout.php\"><img id = \"login\" src = \"Pagine/Immagini/logout.png\" alt = \"Effettua la disconnessione dal tuo profilo\"/></a>";
        $template = str_replace($cercata, $sostituita, $template);
        $cercata = "<li><a href=\"Login.php\"><span xml:lang=\"en\">Login</span></a></li>";
        $sostituita = "<li><a href=\"Logout.php\"><span xml:lang=\"en\">Logout</span></a></li>";
        $template = str_replace($cercata, $sostituita, $template);
        echo $template;

        $user = $_SESSION['Utente'];
        $userid = $conne->getUtenteId($user);

        echo "<div id ='content'>";

        if(isset($_POST['idP'])){
            $idProdotto = $_POST['idP'];
            $conne->delCarrello($userid,$idProdotto);

            echo "<p class = 'text'> Un' unità di prodotto rimossa correttamente </p>";
        }

        if(isset($_POST['svuota'])){
            $idProdotto = $_POST['svuota'];
            $conne->delCarrelloAll($userid);
            echo "<p class = 'text'> Carrello svuotato </p>";
        }

        $resultprod = $conn->query("SELECT * FROM Prodotto WHERE IdProdotto IN (SELECT IdProdotto FROM Carrello WHERE IdUtente =$userid)");

        if(!$resultprod){
            echo "<p class = 'text'> Carrello vuoto </p>
                  </div>";
        }
        else{

            if($resultprod->num_rows > 0){

                echo "<h2>Elementi nel carrello</h2>
                          <div id='center'>
                              <dl id='foto'>";
                $tabindex = 0;
                while($row = $resultprod->fetch_assoc()){

                    $qtprodotto = $conn->query("SELECT Quantita FROM Carrello WHERE IdProdotto ='" . $row['IdProdotto'] . "' AND IdUtente = $userid");
                    $qt = $qtprodotto->fetch_assoc();

                    echo "<dd class = 'imgprodotto'>
                              <img src = '" . $row['Foto'] . "' alt = '".$row['Descrizione']."'/>
                              <p class = 'prod'>" . $row['Nome'] . " (" . $row['Taglia'] . ")</p>
                              <p class = 'prod'>Prezzo: " . $row['Prezzo'] . "€</p>
                              <p class = 'prod'>Quantità: " .$qt['Quantita']. " unità</p>
                              <form method = 'post' action = 'Carrello.php' >
                                  <div>      
                                      <input type = 'hidden' name = 'quantita' value = '1'/>
                                      <input type = 'hidden' name = 'idP' value = '" . $row['IdProdotto'] . "'/>
                                      <input type = 'submit' value = 'Rimuovi dal Carrello' class = 'delcar' tabindex = '".++$tabindex."'/>
                                  </div>
                              </form>
                          </dd>";
                }

                echo"</dl>
                     </div>";

                echo "<form method='post' action='Carrello.php' class='formcar'>
                          <fieldset class='senzabordi'>
                              <input type = 'hidden' id = 'svuota' name = 'svuota'/>
                              <input type = 'submit' value = 'Svuota il Carrello' class= 'delcar' tabindex = '".++$tabindex."'/>
                          </fieldset>
                      </form>
                      <button class = 'cart' tabindex = '".++$tabindex."'>Completa Acquisto</button>
                      ";
                }
                else{
                     echo "<p class = 'errore'> Carrello vuoto </p>";
                }

                echo "</div>";
            }

            $conn->close();
    }

	echo file_get_contents("Pagine/Footer.xhtml");