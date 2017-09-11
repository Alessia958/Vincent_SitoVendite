<?php

    session_start();

    $_SESSION['Utente'] = 'Guest';

    echo file_get_contents("Pagine/Home.xhtml");
