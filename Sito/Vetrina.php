<?php

    session_start();
    require_once "Connessione.php";

    if(!isset($_SESSION['Utente'])){
        $_SESSION['Utente'] = 'Guest';
    }

    $conn = (new Connessione())->connection();
    $conne = new Connessione();
    $tipo = $_GET['tipo'];
    $result = '';
    $stringa = '';

    if(isset($_GET['tryVoto'])){
        $checkVoto = $_GET['tryVoto'];
    }


    if($tipo != "zaini" && $tipo != 'borse' && $tipo != 'portafogli'){
        header("Location: Home.php");
    }

    if($tipo == 'zaini'){

        if ($_SESSION['Utente'] === 'Guest'){
            echo file_get_contents("Pagine/ZainiInizio.xhtml");
        }
        else{
            $template = file_get_contents("Pagine/ZainiInizio.xhtml");
            $cercata = "<a href = \"Login.php\"><img id = \"login\" src = \"Pagine/Immagini/login2.png\" alt = \"Effettua l'accesso al tuo profilo\"/></a>";
            $sostituita = "<a href = \"Logout.php\"><img id = \"login\" src = \"Pagine/Immagini/logout.png\" alt = \"Effettua la disconnessione dal tuo profilo\"/></a>";
            $template = str_replace($cercata, $sostituita, $template);
            $cercata = "<li><a href=\"Login.php\"><span xml:lang=\"en\">Login</span></a></li>";
            $sostituita = "<li><a href=\"Logout.php\"><span xml:lang=\"en\">Logout</span></a></li>";
            $template = str_replace($cercata, $sostituita, $template);
            echo $template;
        }

        global $stringa;
        global $result;

        $stringa = '<h2>I nostri zaini</h2>';
        $result = $conn->query("SELECT * FROM Prodotto WHERE tipo = 'Zaino'");

    }
    else if($tipo == 'borse'){

        if($_SESSION['Utente'] === 'Guest'){
            echo file_get_contents("Pagine/BorseInizio.xhtml");
        }
        else{
            $template = file_get_contents("Pagine/BorseInizio.xhtml");
            $cercata = "<a href = \"Login.php\"><img id = \"login\" src = \"Pagine/Immagini/login2.png\" alt = \"Effettua l'accesso al tuo profilo\"/></a>";
            $sostituita = "<a href = \"Logout.php\"><img id = \"login\" src = \"Pagine/Immagini/logout.png\" alt = \"Effettua la disconnessione dal tuo profilo\"/></a>";
            $template = str_replace($cercata, $sostituita, $template);
            $cercata = "<li><a href=\"Login.php\"><span xml:lang=\"en\">Login</span></a></li>";
            $sostituita = "<li><a href=\"Logout.php\"><span xml:lang=\"en\">Logout</span></a></li>";
            $template = str_replace($cercata, $sostituita, $template);
            echo $template;
        }

        global $stringa;
        global $result;

        $stringa = '<h2>Le nostre borse</h2>';
        $result = $conn->query("SELECT * FROM Prodotto WHERE tipo = 'Borsa'");

    }
    else if($tipo == 'portafogli'){

        if($_SESSION['Utente'] === 'Guest') {
            echo file_get_contents("Pagine/PortafogliInizio.xhtml");
        }
        else{
            $template = file_get_contents("Pagine/PortafogliInizio.xhtml");
            $cercata = "<a href = \"Login.php\"><img id = \"login\" src = \"Pagine/Immagini/login2.png\" alt = \"Effettua l'accesso al tuo profilo\"/></a>";
            $sostituita = "<a href = \"Logout.php\"><img id = \"login\" src = \"Pagine/Immagini/logout.png\" alt = \"Effettua la disconnessione dal tuo profilo\"/></a>";
            $template = str_replace($cercata, $sostituita, $template);
            $cercata = "<li><a href=\"Login.php\"><span xml:lang=\"en\">Login</span></a></li>";
            $sostituita = "<li><a href=\"Logout.php\"><span xml:lang=\"en\">Logout</span></a></li>";
            $template = str_replace($cercata, $sostituita, $template);
            echo $template;
        }

        global $stringa;
        global $result;

        $stringa = '<h2>I nostri portafogli</h2>';
        $result = $conn->query("SELECT * FROM Prodotto WHERE tipo = 'Portafoglio'");

    }

    if(!$result){
        echo "Errore nella query: ". $conn->error .".";
        exit();
    }
    else{

        global $checkVoto;

        echo "<div id = 'content'> 
                $stringa
                <dl id = 'taglie'>
                    <dt class = 'bold'>Taglie</dt>
                    <dd><span class = 'bold'>S:</span> taglia piccola</dd>
                    <dd><span class = 'bold'> M:</span> taglia media</dd>
                    <dd><span class = 'bold'> L:</span> taglia grande</dd>
                </dl>";

        if($checkVoto == 1 && $_SESSION['Utente'] != 'Guest'){
            echo "<p class = 'text'>Grazie per aver votato!</p>";
        }
        else if($checkVoto == 2 && $_SESSION['Utente'] != 'Guest'){
            echo "<p class = 'text'>Il tuo voto è stato aggiornato!</p>";
        }
        else if($checkVoto == 3 || ($checkVoto == 4 && $_SESSION['Utente'] == 'Guest')){
            echo "<p class = 'errore'>Devi effettuare il <span xml:lang='en'>login</span> per poter votare!</p>";
        }
        else if($checkVoto == 4 && $_SESSION['Utente'] != 'Guest'){
            echo "<p class = 'errore'>Devi scegliere un voto da 1 a 5 per poter votare!</p>";
        }
        if(isset($_POST['idP'])){
            if($_SESSION['Utente'] === 'Guest'){
                echo "<p class = 'errore'>Devi effettuare il <span xml:lang='en'>login</span> per poter aggiungere elementi al carrello</p>";
            }
            else{
                $user = $_SESSION['Utente'];
                $idProdotto = $_POST['idP'];
                $quantita = $_POST['quantita'];

                $userid = $conne->getUtenteId($user);
                $conne->insertCarrello($userid, $idProdotto,$quantita);

                echo "<p class = 'text'>Un' unità di prodotto aggiunta correttamente</p>";
            }
        }

        global $tipo;
        echo "<div id = 'center'>
                    <dl id = 'foto'>";
        if($result->num_rows > 0){

            $tabindex = 0;


            while($row = $result->fetch_array(MYSQLI_ASSOC)){

                echo "<dd class = 'imgprodotto'>
                        <p class = 'nomeP'>" . $row['Nome'] . " (" . $row['Taglia'] . ")</p>
						<img src = '" . $row['Foto'] . "' alt = '" . $row['Descrizione'] . "'/>
						<div class = 'rating'>
                            <form method = 'post' action = 'Voto.php'>
                                <fieldset class='senzabordi'>
                                    <div class = 'radio'>
                                        <label for='a".$row['IdProdotto']."'>1</label>
                                        <input id='a".$row['IdProdotto']."' type = 'radio' name = 'vota' value = '1' checked= 'checked' tabindex= '" .++$tabindex. "'/>
                                        <label for='b".$row['IdProdotto']."'>2</label>
                                        <input id='b".$row['IdProdotto']."' type = 'radio' name = 'vota' value = '2' />
                                        <label for='c".$row['IdProdotto']."'>3</label>
                                        <input id='c".$row['IdProdotto']."' type = 'radio' name = 'vota' value = '3' />                                  
                                        <label for='d".$row['IdProdotto']."'>4</label>
                                        <input id='d".$row['IdProdotto']."' type = 'radio' name = 'vota' value = '4' />              
                                        <label for='e".$row['IdProdotto']."'>5</label>
                                        <input id='e".$row['IdProdotto']."' type = 'radio' name = 'vota' value = '5' />
                                     </div>
                                        <input type = 'hidden' class='idP' name='idProd' value = '" . $row['IdProdotto'] . "'/>
                                        <input class = 'button' type = 'submit' value = 'Vota' tabindex= '" .++$tabindex. "'/>
                                 </fieldset>
                            </form>
                        </div>";

                if($_SESSION['Utente'] != 'Guest'){
                    $userid = $conne->getUtenteId($_SESSION['Utente']);
                    $result2 = $conn->query("SELECT Voto FROM Valutazione WHERE IdProdotto = ". $row['IdProdotto'] ." AND Utente = ". $userid);

                    if($result2->num_rows > 0){
                        $row2 = $result2->fetch_array(MYSQLI_ASSOC);
                        echo "<p class = 'prod'>Il tuo voto: ". $row2['Voto'] ."</p>";
                    }
                    else{
                        echo "<p class = 'prod'>Il tuo voto: -</p>";
                    }
                }

                echo "<p class = 'prod'>Media Voto: " . $row['MediaValutazione'] ." </p>
                  	  <p class = 'prod'>Prezzo: " . $row['Prezzo'] . "€</p>
                  	  <form action = 'Vetrina.php?tipo=" . $tipo ."' method = 'post'>
                          <fieldset class='senzabordi'>
                              <input type = 'hidden' class = 'quantita' name = 'quantita' value = '1'/>
                              <input type = 'hidden' class = 'tryVoto' name = 'tryVoto' value = '5'/>
                              <input type = 'hidden' class = 'idP' name = 'idP' value = '" . $row['IdProdotto'] . "'/>
                              <input type = 'submit' value = 'Aggiungi al Carrello' class = 'cart' tabindex= '" .++$tabindex. "'/>
                          </fieldset>
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
                <a class = 'aiuti' href = '#breadcrump'>Torna su</a>
                </div>";

    }

    $conn->close();

    echo file_get_contents("Pagine/Footer.xhtml");





















