<?php

    require_once "Function.php";
    class Prodotto{

        private $nome = "";
        private $descrizione = "";
        private $prezzo = "";
        private $taglia = "";
        private $tipo = "";
        private $foto = "";
        private $errore = "";

        function __construct($n, $descr, $p, $tag, $t, $f){
            $erroreNome = $this->setNome($n);
            $erroreDescr = $this->setDescrizione($descr);
            $errorePrezzo = $this->setPrezzo($p);
            $this->taglia = $tag;
            $this->tipo = $t;

            $this->errore = $erroreNome . $erroreDescr . $errorePrezzo;

            if($this->errore === ""){
                $erroreFoto = $this->setFoto($f);
                $this->errore = $erroreFoto;
            }

            $this->errore = $this->errore ? "<ul id='errori'>" . $this->errore . "</ul>" : "";
        }

        public function __toString(){
            return $this->errore;
        }

        function setNome($nome){
            $errore = "";
            if(preg_match("/^([[À-ÿ_\w\s]){1,30}$/", $nome)) {
                $nome = pulisciTesto($nome);
                $this->nome = $nome;
            }
            else {
                $errore = "<li class = 'errore'>Nome non inserito correttamente</li>";
            }

            return $errore;
        }

        function setDescrizione($descr){
            $errore = "";

            if(preg_match("/^([[À-ÿ_\w\s]){1,200}$/", $descr)) {
                $descr = pulisciTesto($descr);
                $this->descrizione = $descr;
            }
            else {
                $errore = "<li class = 'errore'>Descrizione non inserita correttamente</li>";
            }

            return $errore;
        }

        function setPrezzo($p){
            $errore = "";

            if(preg_match("/^[0-9]{1,9}(\.[0-9]{1,2})?$/", $p) && $p > 0){
                $p = pulisciInput($p);
                $this->prezzo = $p;
            }
            else {
                $errore = "<li class = 'errore'>Prezzo non inserito correttamente</li>";
            }

            return $errore;
        }

        function setFoto($f){
            $target_dir = "";
            $errore = "";

            if($this->tipo == 'Zaino'){
                $target_dir = "Pagine/Immagini/zaini/";
            }
            else if($this->tipo == 'Borsa'){
                $target_dir = "Pagine/Immagini/borse/";
            }
            else if($this->tipo == 'Portafoglio'){
                $target_dir = "Pagine/Immagini/portafogli/";
            }

            $fileName = basename($f["picture"]["name"]);
            $fileName = preg_replace('/\s+/', '', $fileName);
            $picture = $target_dir . $fileName;
            $check = getimagesize($f["picture"]["tmp_name"]);

            if($check == false){
                $errore = "<li class = 'errore'>Il <span xml:lang='en'>file</span> non è una foto</li>";
                return $errore;
            }

            if (file_exists($picture)){
                $errore = "<li class = 'errore'>Il <span xml:lang='en'>file</span> è già presente</li>";
                return $errore;
            }

            if ($f["picture"]["size"] > 500000) {
                $errore = "<li class = 'errore'>Il <span xml:lang='en'>file</span> è troppo grande</li>";
                return $errore;
            }

            if($errore == ""){
                move_uploaded_file($f["picture"]["tmp_name"], $picture);
                $this->foto = $picture;
            }

            return $errore;
        }

        function getNome(){
            return $this->nome;
        }

        function getDescrizione(){
            return $this->descrizione;
        }

        function getPrezzo(){
            return $this->prezzo;
        }

        function getTaglia(){
            return $this->taglia;
        }

        function getTipo(){
            return $this->tipo;
        }

        function getFoto(){
            return $this->foto;
        }
    }