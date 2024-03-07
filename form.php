<?php
session_start();

require_once('db.php');
require_once('UsersDTO.php');
include_once('header.php');

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
$id = isset($_GET['id']) ? $_GET['id'] : null;
$userDTO = new userDTO($conn);
$data = $userDTO->getUserByID($id);

?>

<main class="form-signin w-100 m-auto">
  <div class="container">
    <h1 class="h3 mb-3 fw-normal">Edit Data</h1>
    <?php if ($data) {
      foreach ($data as $key => $row) { ?>
        <form action="controller.php" method="post">
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" placeholder="<?= $row['email'] ?>" value="<?= $row['email'] ?>" name="email" />
          </div>
          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" placeholder="<?= $row['username'] ?>" value="<?= $row['username'] ?>" name="username" />
          </div>
          <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" placeholder="<?= $row['name'] ?>" value="<?= $row['name'] ?>" name="name" />
          </div>
          <div class="form-group">
            <label for="lastname">Lastname</label>
            <input type="text" class="form-control" id="lastname" placeholder="<?= $row['lastname'] ?>" value="<?= $row['lastname'] ?>" name="lastname" />
          </div>
          <input type="hidden" name="user_id" value="<?= $row['id'] ?>">
          <button class="btn btn-primary my-4 py-2" type="submit">
            Save Data
          </button>
        </form>


    <?php }
    } ?>


    <div>


    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>