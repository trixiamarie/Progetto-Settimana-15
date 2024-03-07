<?php
session_start();

if (isset($_SESSION['userLogin']) && isset($_COOKIE["useremail"]) && isset($_COOKIE["userpassword"])) {
  header('Location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="auto">

<head>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/assets/js/color-modes.js"></script>

  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="" />
  <title>Login - PS15</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3" />

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />



  <link rel="stylesheet" href="css/style.css" />
  <!-- Custom styles for this template -->
  <link href="https://getbootstrap.com/docs/5.3/examples/sign-in/sign-in.css" rel="stylesheet" />
</head>

<body class="d-flex align-items-center py-4 bg-body-tertiary">

  <main class="form-signin w-100 m-auto">
    <form action="controller.php" method="post">
      <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

      <div class="form-floating">
        <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="email" />
        <label for="floatingInput">Email address</label>
      </div>
      <div class="form-floating">
        <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password" value="Pa$$w0rd!" />
        <label for="floatingPassword">Password</label>
      </div>

      <div class="form-check text-start my-3">
        <input class="form-check-input" type="checkbox" value="logCookie" id="flexCheckDefault" name="check" />
        <label class="form-check-label" for="flexCheckDefault">
          Remember me
        </label>
      </div>
      <button class="btn btn-primary w-100 py-2" type="submit">
        Sign in
      </button>
      <?php
      if (isset($_SESSION['error'])) {
        echo '<div class="alert alert-danger my-3" role="alert">' . $_SESSION['error'] . '</div>';
      }
      ?>
      <div>
        <p class="text-center m-0">or</p>
      </div>
      <a class="btn btn-primary w-100 py-2" type="button" href="register.php">
        Register
      </a>
    </form>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>