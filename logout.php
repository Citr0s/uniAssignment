<?php
  require_once 'bootstrap.php';

  use Assignment\User;

  $user = new User();
  $deleted = $user->logout();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Logout</title>
</head>
<body>
  <?php
    if($deleted){
  ?>
      <p>Successfuly Logged Out!</p>
  <?php
    }
  ?>
  <a href="registration.php">< Back</a>
</body>
</html>