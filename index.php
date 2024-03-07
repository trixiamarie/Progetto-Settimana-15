<?php
session_start();

include_once('config.php');
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
<div class="container">
  <?php if (password_verify("1", $hashedCookieValue)) { ?>
    <h1 class="text-center">User List</h1>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">username</th>
          <th scope="col">Name</th>
          <th scope="col">Lastname</th>
          <th scope="col">Email</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($data) {
          foreach ($data as $key => $row) { ?>
            <tr>
              <th scope='row'><?= $key + 1 ?></th>
              <th scope="col"><?= $row['username'] ?></th>
              <td><?= $row['name'] ?></td>
              <td><?= $row['lastname'] ?></td>
              <td><?= $row['email'] ?></td>
              <td>

                <a href="form.php?action=edit&id=<?= $row['id'] ?>"><button type="submit" class="btn btn-primary" name="edit">Edit</button></a>
                <form method="post" action="controller.php" onsubmit="return confirm('Once deleted, this user will not be recoverable. Do you wish to continue?');">
                  <input type="hidden" name="user_id" value="<?= $row['id'] ?>">
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
      foreach ($data as $key => $row) { ?>

        <div class="card m-auto my-4" style="width: 18rem;">
          <div class="card-header fw-bold">
            <?= $row['name'] . " " . $row['lastname'] ?>
          </div>
          <ul class="list-group list-group-flush">
            <li class="list-group-item">Username: <?= $row['username'] ?></li>
            <li class="list-group-item">Name: <?= $row['name'] ?></li>
            <li class="list-group-item">Last Name: <?= $row['lastname'] ?></li>
            <li class="list-group-item">Email: <?= $row['email'] ?></li>
            <li class="list-group-item">


              <a href="form.php?action=edit&id=<?= $row['id'] ?>"><button type="submit" class="btn btn-primary" name="edit">Edit</button></a>
              <form method="post" action="controller.php" onsubmit="return confirm('Once deleted, your account will not be recoverable. Do you wish to continue?');">
                <input type="hidden" name="user_id" value="<?= $row['id'] ?>">
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