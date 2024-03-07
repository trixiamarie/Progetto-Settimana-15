<?php
session_start(); 
session_destroy(); 
setcookie("useremail", "", time() - 3600);
setcookie("userpassword", "", time() - 3600); 
setcookie("userid", "", time() - 3600); 
setcookie("userrole", "", time() - 3600); 
header('Location: login.php');
