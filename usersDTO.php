<?php

namespace UsersDTO {

    use PDO;
    use UsersDTO\usermodel;

    class userDTO
    {
        private PDO $conn;

        public function __construct(PDO $conn)
        {
            $this->conn = $conn;
        }

        public function getAll()
        {
            $sql = 'SELECT * FROM db_progettosettimanale15.utenti';
            $res = $this->conn->query($sql, PDO::FETCH_ASSOC);
            return $res ? $res : null;
        }
        public function getUserByID(int $id)
        {
            $sql = 'SELECT * FROM db_progettosettimanale15.utenti WHERE id = :id';
            $stm = $this->conn->prepare($sql);
            $stm->execute(['id' => $id]);
            return $stm->fetchAll();
        }
        public function getUserByEmail(string $email)
        {
            $sql = 'SELECT * FROM db_progettosettimanale15.utenti WHERE email = :email';
            $stm = $this->conn->prepare($sql);
            $stm->execute(['email' => $email]);
            return $stm->fetchAll();
        }
        public function saveUser(usermodel $user)
        {
            $sql = "INSERT INTO db_progettosettimanale15.utenti (username,name, lastname, email, pwd, fk_ruolo) VALUES (:username, :name, :lastname, :email, :pwd, :fk_ruolo)";
            $stm = $this->conn->prepare($sql);
            return $stm->execute(['username' => $user->getUsername(), 'name' => $user->getName(), 'lastname' => $user->getLastname(), 'email' => $user->getEmail(), 'pwd' => $user->getPwd(), 'fk_ruolo' => $user->getFkruolo()]);
        }
        public function updateUser(usermodel $user)
        {
            $sql = "UPDATE db_progettosettimanale15.utenti SET username = :username, name = :name, lastname = :lastname, email = :email WHERE id = :id";
            $stm = $this->conn->prepare($sql);
            return $stm->execute([
                'id' => $user->getId(),
                'username' => $user->getUsername(),
                'name' => $user->getName(),
                'lastname' => $user->getLastname(),
                'email' => $user->getEmail()
            ]);
        }

        public function deleteUser(int $id)
        {
            $sql = "DELETE FROM db_progettosettimanale15.utenti WHERE id = :id";
            $stm = $this->conn->prepare($sql);
            return  $stm->execute(['id' => $id]);
        }
    }
}
