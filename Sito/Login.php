<?php

    session_start();
    require_once "Connessione.php";
    require_once "Function.php";

    if(!isset($_SESSION['Utente'])){
        $_SESSION['Utente'] = 'Guest';
    }

    if($_SESSION['Utente'] === 'Guest'){

        if (isset($_POST['submit'])) {

            $username = $_POST['username'];
            $password = $_POST['password'];

            if ($username != "" && $password != "") {
                $conn = new Connessione();
                $username = pulisciTesto($username);
                $password = pulisciTesto($password);
                $cond = $conn->getUtente($username, $password);
                if ($cond == 1) {
                    $_SESSION['Utente'] = (string)$username;
                    $template = file_get_contents("Pagine/LoginInizio.xhtml");
                    $cercata = "<a href = \"Carrello.php\"><img id = \"carrello\" src = \"Pagine/Immagini/carrello2.png\" alt = \"Entra nella pagina del carrello\"/></a>";
                    $sostituita = "<a href = \"Logout.php\"><img id = \"login\" src = \"Pagine/Immagini/logout.png\" alt = \"Effettua la disconessione dal tuo profilo\"/></a>
                                    <a href = \"Carrello.php\"><img id = \"carrello\" src = \"Pagine/Immagini/carrello2.png\" alt = \"Entra nella pagina del carrello\"/></a>";
                    $template = str_replace($cercata, $sostituita, $template);

                    echo $template;
                    echo "<p class = 'text'>Benvenuto $username</p>
                            </div>";
                }
                else if ($cond == 2) {
                    header("Location: CreaProdotto.php");
                    $_SESSION['Utente'] = $username;
                }
                else{
                    echo file_get_contents("Pagine/LoginInizio.xhtml");
                    echo "<p class = 'errore'><span xml:lang=\"en\">Email</span> o <span xml:lang=\"en\">password</span> non corretti </p>";
                    echo file_get_contents("Pagine/LoginForm.xhtml");
                }
            }
            else {
                echo file_get_contents("Pagine/LoginInizio.xhtml");
                echo "<p class = 'errore'>Compilare tutti i campi!</p>";
                echo file_get_contents("Pagine/LoginForm.xhtml");
            }
        }
        else{
            echo file_get_contents("Pagine/LoginInizio.xhtml");
            echo file_get_contents("Pagine/LoginForm.xhtml");
        }
    }
    else{
        $template = file_get_contents("Pagine/LoginInizio.xhtml");
        $cercata = "<a href = \"Carrello.php\"><img id = \"carrello\" src = \"Pagine/Immagini/carrello2.png\" alt = \"Entra nella pagina del carrello\"/></a>";
        $sostituita = "<a href = \"Logout.php\"><img id = \"login\" src = \"Pagine/Immagini/logout.png\" alt = \"Effettua la disconessione dal tuo profilo\"/></a>
                                    <a href = \"Carrello.php\"><img id = \"carrello\" src = \"Pagine/Immagini/carrello2.png\" alt = \"Entra nella pagina del carrello\"/></a>";
        $template = str_replace($cercata, $sostituita, $template);

        echo $template;
        echo "<p class = 'errore'>Hai già effettuato l'accesso </p>
                </div>";
    }

    echo file_get_contents("Pagine/Footer.xhtml");

