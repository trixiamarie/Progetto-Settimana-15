<?php
session_start();

require_once('db.php');
require_once('UsersDTO.php');

use UsersDTO\userDTO;
use db\DB_PDO;


$config = [
  'driver' => 'mysql',
  'host' => 'localhost',
  'database' => 'db_progettosettimanale15',
  'port' => '3306',
  'user' => 'root',
  'password' => ''
];

if (!isset($_SESSION['userLogin']) && isset($_COOKIE["useremail"]) && isset($_COOKIE["userpassword"])) {
  header('Location: controller.php' . $_COOKIE["useremail"] . '&password=' . $_COOKIE["userpassword"]);
} else if (!isset($_SESSION['userLogin'])) {
  header('Location: login.php');
}

$PDOConn = DB_PDO::getInstance($config);
$conn = $PDOConn->getConnection();

// print_r(($_COOKIE["userrole"]));
$hashedCookieValue = $_COOKIE["userrole"];

if (password_verify("1", $hashedCookieValue)) {
  $users = new userDTO($conn);
  $data = $users->getAll();
} else {
  $users = new userDTO($conn);
  $data = $users->getUserByID(($_COOKIE["userid"]));
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Update Data</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Prog.Set.15</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.html">Home</a>
          </li>
        </ul>
        <span class="navbar-text">
          <a class="nav-link active" aria-current="page" href="logout.php">Logout</a>
        </span>
      </div>
    </div>
  </nav>
  <div class="container">
    <?php if (password_verify("1", $hashedCookieValue)) { ?>
      <h1 class="text-center">User List</h1>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Lastname</th>
            <th scope="col">Email</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($data) {
            // Iterazione attraverso ciascuna riga di dati
            foreach ($data as $key => $row) { ?>
              <tr>
                <th scope='row'><?= $key + 1 ?></th>
                <td><?= $row['name'] ?></td>
                <td><?= $row['lastname'] ?></td>
                <td><?= $row['email'] ?></td>
                <td>
                  <form method="post" action="controller.php">
                  <input type="hidden" name="user_id" value="<?= $row['id'] ?>">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Edit</button>
                    <button type="submit" name="delete_user" class="btn btn-danger">Delete Account</button>
                  </form>
                </td>
              </tr>
          <?php }
          } else {
            echo "Nessun dato trovato nella tabella.";
          }
          ?>
        </tbody>
      </table>
    <?php } else { ?>
      <h1 class="text-center">My Profile</h1>

      <?php if ($data) {
        // Iterazione attraverso ciascuna riga di dati
        foreach ($data as $key => $row) { ?>

          <div class="card m-auto my-4" style="width: 18rem;">
            <div class="card-header fw-bold">
              <?= $row['name'] . " " . $row['lastname'] ?>
            </div>
            <ul class="list-group list-group-flush">
              <li class="list-group-item">Name: <?= $row['name'] ?></li>
              <li class="list-group-item">Last Name: <?= $row['lastname'] ?></li>
              <li class="list-group-item">Email: <?= $row['email'] ?></li>
              <li class="list-group-item">
                <form method="post" action="controller.php">
                  <button type="button" class="btn btn-primary">Edit</button>
                  <button type="submit" name="delete_account" class="btn btn-danger">Delete Account</button>
                </form>
              </li>
            </ul>
          </div>
      <?php }
      } else {
        echo "Nessun dato trovato nella tabella.";
      }
      ?>

    <?php } ?>

  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>