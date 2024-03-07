<?php
require_once('db.php');
use db\DB_PDO;

$config = [
    'driver' => 'mysql',
    'host' => 'localhost',
    'database' => 'db_progettosettimanale15',
    'port' => '3306',
    'user' => 'root',
    'password' => ''
];

$PDOConn = DB_PDO::getInstance($config);
$conn = $PDOConn->getConnection();


$sql_ruoli = 'CREATE TABLE IF NOT EXISTS ruoli ( 
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        ruolo VARCHAR(255) NOT NULL
    )';


$conn->exec($sql_ruoli);


$sql_check_ruoli = 'SELECT COUNT(*) as count FROM ruoli WHERE ruolo IN ("admin", "utente")';
$result = $conn->query($sql_check_ruoli);
$row = $result->fetch(PDO::FETCH_ASSOC);


if ($row['count'] < 2) {
    
    $sql_insert_ruoli = 'INSERT INTO ruoli (ruolo) VALUES ("admin"), ("utente")';
    $conn->exec($sql_insert_ruoli);
}



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


$conn->exec($sql_utenti);

$sql_check_admin = 'SELECT COUNT(*) as count FROM utenti WHERE fk_ruolo = (SELECT id FROM ruoli WHERE ruolo = "admin")';
$result = $conn->query($sql_check_admin);
$rowadmin = $result->fetch(PDO::FETCH_ASSOC);
if ($rowadmin['count'] < 1) {
$password = '4dm1n.'; 

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$sql_insert_admin = "INSERT INTO utenti (username, name, lastname, email, pwd, fk_ruolo) 
                    VALUES ('admin', 'admin', 'admin', 'admin@admin.it', '$hashed_password', (SELECT id FROM ruoli WHERE ruolo = 'admin'))";

$conn->exec($sql_insert_admin);
}


// echo "Tabelle create con successo!";
?>

