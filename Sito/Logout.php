<?php

    session_start();

    $_SESSION['Utente'] = 'Guest';

    echo file_get_contents("Pagine/LoginInizio.xhtml");
    echo "<p class = 'text'>Disconnessione avvenuta con successo </p>";
    echo file_get_contents("Pagine/LoginForm.xhtml");
    echo file_get_contents("Pagine/Footer.xhtml");