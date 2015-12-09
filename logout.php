<?php
  require_once 'bootstrap.php';

  use Assignment\DatabaseSession;
  use Assignment\Database;

  $dbCon = new Database();
  $session = new DatabaseSession($dbCon);

  $deleted = $session->destroy(session_id());
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