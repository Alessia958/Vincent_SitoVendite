<?php

    session_start();
    require_once "Connessione.php";
    require_once "Function.php";

    if(!isset($_SESSION['Utente'])){
        $_SESSION['Utente'] = 'Guest';
    }

    if($_SESSION['Utente'] === 'Guest') {

        if (isset($_POST['submit'])) {

            $username = $_POST['username'];
            $nome = $_POST['nome'];
            $cognome = $_POST['cognome'];
            $email = $_POST['email2'];
            $password = $_POST['password2'];
            $citta = $_POST['città'];
            $civico = $_POST['civico'];
            $via = $_POST['via'];
            $cap = $_POST['cap'];

            if ($username != "" && $nome != "" && $cognome != "" && $email != "" && $password != "" && $citta != "" && $civico != "" &&
                $via != "" && $cap != ""){

                $reg = new Registrazione($username, $nome, $cognome, $email, $password, $citta, $civico, $via, $cap);

                if(empty($reg->__toString())){
                    $conn = new Connessione();
                    $cond = $conn->insertUtente($reg);

                    if($cond === true){
                        echo file_get_contents("Pagine/RegistratiInizio.xhtml");
                        echo "<p class = 'text'>Registrazione avvenuta con successo</p>
                                </div>";
                    }
                    else {
                        echo file_get_contents("Pagine/RegistratiInizio.xhtml");
                        echo "<p class = 'errore'>L'<span xml:lang='en'>username</span> scelto non è disponibile</p>";
                        echo file_get_contents("Pagine/RegistratiForm.xhtml");
                    }
                }
                else{
                    echo file_get_contents("Pagine/RegistratiInizio.xhtml");
                    echo $reg->__toString();
                    echo file_get_contents("Pagine/RegistratiForm.xhtml");
                }
            }
            else {
                echo file_get_contents("Pagine/RegistratiInizio.xhtml");
                echo "<p class = 'errore'>Compilare tutti i campi!</p>";
                echo file_get_contents("Pagine/RegistratiForm.xhtml");
            }
        }
        else{
            echo file_get_contents("Pagine/RegistratiInizio.xhtml");
            echo file_get_contents("Pagine/RegistratiForm.xhtml");
        }
    }
    else{
        $template = file_get_contents("Pagine/RegistratiInizio.xhtml");
        $cercata = "<a href = \"Login.php\"><img id = \"login\" src = \"Pagine/Immagini/login2.png\" alt = \"Effettua l'accesso al tuo profilo\"/></a>";
        $sostituita = "<a href = \"Logout.php\"><img id = \"login\" src = \"Pagine/Immagini/logout.png\" alt = \"Effettua la disconnessione dal tuo profilo\"/></a>";
        $template = str_replace($cercata, $sostituita, $template);
        $cercata = "<li><a href=\"Login.php\"><span xml:lang=\"en\">Login</span></a></li>";
        $sostituita = "<li><a href=\"Logout.php\"><span xml:lang=\"en\">Logout</span></a></li>";
        $template = str_replace($cercata, $sostituita, $template);
        echo $template;

        echo "<p class = 'errore'>Effettuare il <span xml:lang=\"en\">Logout</span> per registrare un nuovo utente</p>
               </div>";
    }

    echo file_get_contents("Pagine/Footer.xhtml");

