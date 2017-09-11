<?php

    class Registrazione{

        private $username = "";
        private $nome = "";
        private $cognome = "";
        private $email = "";
        private $password = "";
        private $citta = "";
        private $civico = "";
        private $via = "";
        private $cap = "";
        private $errore = "";

        function __construct($s,$n,$c,$e,$p,$cit,$civ,$v,$cap){
            $erroreUser = $this->setUsername($s);
            $erroreNome = $this->setNome($n);
            $erroreCognome = $this->setCognome($c);
            $erroreMail = $this->setEmail($e);
            $errorePass = $this->setPassword($p);
            $erroreCitta = $this->setCitta($cit);
            $erroreCivico = $this->setCivico($civ);
            $erroreVia = $this->setVia($v);
            $erroreCap = $this->setCap($cap);

            $this->errore = $erroreUser . $erroreNome . $erroreCognome . $erroreMail .
                $errorePass . $erroreCitta . $erroreCivico . $erroreVia . $erroreCap;

            $this->errore = $this->errore ? "<ul id='errori'>" . $this->errore . "</ul>" : "";
        }

        public function __toString(){
            return $this->errore;
        }

        private function setUsername($user){
            $errore = "";

            if(preg_match("/^([À-ÿ_\w]){4,16}$/", $user)){
                $user = pulisciInput($user);
                $user = pulisciTesto($user);
                $this->username = $user;
            }
            else {
                $errore = "<li class = 'errore'><span xml:lang='en'>Username</span> non inserito correttamente</li>";
            }

            return $errore;
        }

        private function setNome($nome){
            $errore = "";

            if(preg_match("/^([À-ÿ_\w\s]){1,30}$/", $nome)){
                $nome = pulisciInput($nome);
                $nome = pulisciTesto($nome);
                $this->nome = $nome;
            }
            else {
                $errore = "<li class = 'errore'>Nome non inserito correttamente</li>";
            }

            return $errore;

        }

        private function setCognome($cog){
            $errore = "";

            if(preg_match("/^([À-ÿ_\w\s]){1,30}$/", $cog)) {
                $cog = pulisciInput($cog);
                $cog = pulisciTesto($cog);
                $this->cognome = $cog;
            }
            else {
                $errore = "<li class = 'errore'>Cognome non inserito correttamente</li>";
            }

            return $errore;

        }

        private function setEmail($mail){
            $errore = "";

            if(preg_match("/^([À-ÿ_\w+.]+)@([\w+.]+)\.([\w+.]+){1,255}$/", $mail)) {
                $mail = pulisciInput($mail);
                $mail = pulisciTesto($mail);
                $this->email = $mail;
            }
            else {
                $errore = "<li class = 'errore'><span xml:lang='en'>Email</span> non inserita correttamente</li>";
            }

            return $errore;

        }

        private function setPassword($pass){
            $errore = "";

            if(preg_match("/^([À-ÿ_\w]){4,12}$/", $pass)){
                $pass = pulisciInput($pass);
                $pass = pulisciTesto($pass);
                $this->password = hash("sha1", $pass);
            }
            else {
                $errore = "<li class = 'errore'><span xml:lang='en'>Password</span>  non inserita correttamente</li>";
            }

            return $errore;

        }

        private function setCitta($cit){
            $errore = "";

            if(preg_match("/^([À-ÿ_\w\s]){1,50}$/", $cit)){
                $cit = pulisciInput($cit);
                $cit = pulisciTesto($cit);
                $this->citta = $cit;
            }
            else {
                $errore = "<li class = 'errore'>Città non inserita correttamente</li>";
            }

            return $errore;

        }

        private function setVia($via){
            $errore = "";

            if(preg_match("/^([À-ÿ_\w\s]){1,50}$/", $via)){
                $via = pulisciInput($via);
                $via = pulisciTesto($via);
                $this->via = $via;
            }
            else {
                $errore = "<li class = 'errore'>Via non inserita correttamente</li>";
            }

            return $errore;

        }

        private function setCivico($civ){
            $errore = "";

            if(preg_match("/^([\/_\w]){1,10}$/", $civ)){
                $civ = pulisciInput($civ);
                $civ = pulisciTesto($civ);
                $this->civico = $civ;
            }
            else {
                $errore = "<li class = 'errore'>Civico non inserito correttamente</li>";
            }

            return $errore;

        }

        private function setCap($cap){
            $errore = "";

            if(preg_match("/^([\d]){1,8}$/", $cap)){
                $cap = pulisciInput($cap);
                $this->cap = $cap;
            }
            else {
                $errore = "<li class = 'errore'>Cap non inserito correttamente</li>";
            }

            return $errore;

        }

        function getUsername(){
            return $this->username;
        }

        function getEmail(){
            return $this->email;
        }

        function getNome(){
            return $this->nome;
        }

        function getCognome(){
            return $this->cognome;
        }

        function getPassword(){
            return $this->password;
        }

        function getCitta(){
            return $this->citta;
        }

        function getCivico(){
            return $this->civico;
        }

        function getVia(){
            return $this->via;
        }

        function getCap(){
            return $this->cap;
        }

    }