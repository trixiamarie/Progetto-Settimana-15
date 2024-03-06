<?php
require_once('db.php');
$config = [
    'driver' => 'mysql',
    'host' => 'localhost',
    'database' => 'db_progettosettimanale15',
    'port' => '3306',
    'user' => 'root',
    'password' => ''
];
use db\DB_PDO;


$PDOConn = DB_Pdo::getInstance($config);
$conn = $PDOConn->getConnection();
var_dump($conn);

    // Query per creare la tabella "ruoli"
    $sql_ruoli = 'CREATE TABLE IF NOT EXISTS ruoli ( 
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        ruolo VARCHAR(255) NOT NULL
    )';

    // Esegui la query per creare la tabella "ruoli"
    $conn->exec($sql_ruoli);

    // Query per creare la tabella "utenti"
    $sql_utenti = 'CREATE TABLE IF NOT EXISTS utenti ( 
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        username VARCHAR(255) NOT NULL UNIQUE, 
        name VARCHAR(255) NOT NULL, 
        lastname VARCHAR(255) NOT NULL, 
        email VARCHAR(255) NOT NULL UNIQUE, 
        pwd VARCHAR(255) NOT NULL,
        fk_ruolo INT NOT NULL,
        FOREIGN KEY (fk_ruolo) REFERENCES ruoli (id) ON DELETE CASCADE ON UPDATE CASCADE
    )';

    // Esegui la query per creare la tabella "utenti"
    $conn->exec($sql_utenti);

    echo "Tabelle create con successo!";

