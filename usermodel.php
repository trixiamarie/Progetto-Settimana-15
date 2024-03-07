<?php

//Tipizza
declare(strict_types=1);

namespace UsersDTO {
    class usermodel
    {
        private int $id;
        private string $username;
        private string $name;
        private string $lastname;
        private string $email;
        private string $pwd;
        private int $fk_ruolo;
        public function __construct()
        {
        }

        //Metodi per impostare i dati della classe + controlli

        public function setId(int $id): void
        {
            $this->id = $id;
        }
        public function setUsername(string $username): void
        {
            $this->username = $username;
        }
        public function setName(string $name): void
        {
            $this->name = $name;
        }
        public function setLastname(string $lastname): void
        {
            $this->lastname = $lastname;
        }
        public function setEmail(string $email): void
        {
            if (filter_var($email, FILTER_VALIDATE_EMAIL))
                $this->email = $email;
            else
                $_SESSION['errore'] = $_SESSION['errore'] . '<br>Email non valida';
        }
        public function setPwd(string $pwd): void
        {
            if ($pwd == '' || $pwd == null) {
                $_SESSION['errore'] = $_SESSION['errore'] . '<br>Password vuota';
            }
            if (strlen($pwd) < 8) {
                $_SESSION['errore'] = $_SESSION['errore'] . '<br>Password troppo corta';
            }

            if (!preg_match("/[A-Z]/", $pwd)) {
                $_SESSION['errore'] = $_SESSION['errore'] . "<br>Password dovrebbe avere almeno una lettera maiuscola";
            }
            if (!preg_match("/[a-z]/", $pwd)) {
                $_SESSION['errore'] = $_SESSION['errore'] . "<br>Password dovrebbe avere almeno una lettera minuscola";
            }
            if (!preg_match("/\W/", $pwd)) {
                $_SESSION['errore'] = $_SESSION['errore'] . "<br>Password dovrebbe contenere almeno un carattere speciale";
            }
            if (preg_match("/\s/", $pwd)) {
                $_SESSION['errore'] = $_SESSION['errore'] . "<br>Password non dovrebbe contenere spazi";
            }
            $this->pwd = $pwd;
        }
        public function setFkruolo(int $fk_ruolo): void
        {
            $this->fk_ruolo = $fk_ruolo;
        }

        //Metodi per leggere i dati della classe

        public function getId(): int
        {
            return $this->id;
        }
        public function getUsername(): string
        {
            return $this->username;
        }
        public function getName(): string
        {
            return $this->name;
        }
        public function getLastname(): string
        {
            return $this->lastname;
        }
        public function getEmail(): string
        {
            return $this->email;
        }
        public function getPwd(): string
        {
            return $this->pwd;
        }
        public function getFkruolo(): int
        {
            return $this->fk_ruolo;
        }
    }
}
