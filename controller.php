<?php

session_start();

require_once('db.php');
require_once('UsersDTO.php');
require_once('usermodel.php');

use db\DB_PDO;
use UsersDTO\userDTO;
use UsersDTO\usermodel;

$_SESSION['errore'] = '';

// $config = require_once('config.php');
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

// print_r($_REQUEST);

$userdto = new userDTO($conn);
$userdto->getAll();

if (isset($_POST['username']) && isset($_POST['name']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['password'])) {
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $newuser = new usermodel();
    $newuser->setUsername($_POST['username']);
    $newuser->setName($_POST['name']);
    $newuser->setLastname($_POST['lastname']);
    $newuser->setEmail($_POST['email']);
    $newuser->setPwd($password);
    //1 CREA ADMIN, 2 CREA UTENTI
    $newuser->setFkruolo(2);

    if (strlen($_SESSION['errore']) > 0) {
        echo 'ERRORE';
        print_r($_SESSION['errore']);
    } else {
        $userdto->saveUser($newuser);
        header('Location: index.php ');
    }
} else {
    echo 'ERRORE';
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['user_id']) && isset($_POST['username']) && isset($_POST['name']) && isset($_POST['lastname']) && isset($_POST['email'])) {
        $user = new usermodel();
        $user->setId($_POST['user_id']);
        $user->setUsername($_POST['username']);
        $user->setName($_POST['name']);
        $user->setLastname($_POST['lastname']);
        $user->setEmail($_POST['email']);

        $usersDTO = new userDTO($conn);
        $result = $usersDTO->updateUser($user);

        if ($result) {
            echo "Dati utente aggiornati con successo.";
        } else {
            echo "Si è verificato un errore durante l'aggiornamento dei dati dell'utente.";
        }
    } else {
        echo "Tutti i campi del modulo sono obbligatori.";
    }
}



if (isset($_POST['delete_account'])) {


    $userId = $_COOKIE['userid'];

    $userDTO = new userDTO($conn);
    $result = $userDTO->deleteUser($userId);

    if ($result) {
        header('Location: logout.php');
        exit();
    } else {
        echo "Errore durante l'eliminazione dell'account.";
    }
} else if (isset($_POST['delete_user'])) {
    $userId = $_POST['user_id'];

    $userDTO = new userDTO($conn);
    $result = $userDTO->deleteUser($userId);
}

$email = $_POST['email'];
$pwd = $_POST['password'];

$mysqli = new mysqli('localhost', 'root', '', 'db_progettosettimanale15');

if ($mysqli->connect_error) {
    die('Errore di connessione: ' . $mysqli->connect_error);
}

$query = "SELECT * FROM utenti WHERE email = '$email'";
$res = $mysqli->query($query);

if ($row = $res->fetch_assoc()) {
    if (password_verify($pwd, $row['pwd'])) {
        $_SESSION['userLogin'] = $row;
        session_write_close();
        if (isset($_REQUEST['check'])) {
            setcookie("useremail", $row['email'], time() + 20 * 24 * 60 * 60);
            setcookie("userpassword", $row['pwd'], time() + 20 * 24 * 60 * 60);
            setcookie("userid", $row['id'], time() + 20 * 24 * 60 * 60);

            $hashedData = password_hash($row['fk_ruolo'], PASSWORD_DEFAULT);
            setcookie("userrole", $hashedData, time() + 20 * 24 * 60 * 60);
        }
        header('Location: index.php');
        exit;
    } else {
        $_SESSION['error'] = 'Password errata!!!';
        header('Location: login.php');
    }
} else {
    $_SESSION['error'] = 'Email e Password errati!!!';
    header('Location: login.php');
}


// $regexemail = '/^((?!\.)[\w\-_.]*[^.])(@\w+)(\.\w+(\.\w+)?[^.\W])$/m';
// preg_match_all($regexemail, htmlspecialchars($_REQUEST['email']), $matchesEmail, PREG_SET_ORDER, 0);
// $email = $matchesEmail ? htmlspecialchars($_REQUEST['email']) : exit();

// $regexPass = '/^((?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9]).{6,})\S$/';
// preg_match_all($regexPass, htmlspecialchars($_REQUEST['password']), $matchesPass, PREG_SET_ORDER, 0);
// $pass = $matchesPass ? htmlspecialchars($_REQUEST['password']) : exit();
// $password = password_hash($pass, PASSWORD_DEFAULT);