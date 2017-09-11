<?php

    session_start();

    if(!isset($_SESSION['Utente'])){
        $_SESSION['Utente'] = 'Guest';
    }

    if($_SESSION['Utente'] === 'Guest') {
        echo file_get_contents("Pagine/Home.xhtml");
    }
    else{
        $template = file_get_contents("Pagine/Home.xhtml");
        $cercata = "<a href = \"Login.php\"><img id = \"login\" src = \"Pagine/Immagini/login2.png\" alt = \"Effettua l'accesso al tuo profilo\"/></a>";
        $sostituita = "<a href = \"Logout.php\"><img id = \"login\" src = \"Pagine/Immagini/logout.png\" alt = \"Effettua la disconnessione dal tuo profilo\"/></a>";
        $template = str_replace($cercata, $sostituita, $template);
        $cercata = "<li><a href=\"Login.php\"><span xml:lang=\"en\">Login</span></a></li>";
        $sostituita = "<li><a href=\"Logout.php\"><span xml:lang=\"en\">Logout</span></a></li>";
        $template = str_replace($cercata, $sostituita, $template);
        echo $template;
    }