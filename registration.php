<?php
require_once 'bootstrap.php';

use Assignment\UsernameValidator;
use Assignment\PasswordValidator;
use Assignment\EmailValidator;
use Assignment\URLValidator;
use Assignment\DateValidator;
use Assignment\Registration;
use Assignment\User;

$user = new User();

if($_POST){
  $data = array(
    'username' => new UsernameValidator($_POST['username'], true),
    'password' => new PasswordValidator($_POST['password'], true),
    'email' => new EmailValidator($_POST['email'], true),
    'URL' => new URLValidator($_POST['url']),
    'DOB' => new DateValidator($_POST['dob'], true),
  );

  $reg = new Registration($data);

  if(empty($reg->getErrors())){
    $user->login($data);
    $errors = array();
  }else{
    $errors = $reg->getErrors();
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Registration Form</title>
  <style>
    fieldset {padding:3px}
    input {display:block; margin: 0 auto 10px auto}
    label {display:block; margin-bottom: 2px}
    button {display: block; margin: 5px 0}
    section {width:250px}
    .errors{border-color:#e74c3c;color:#c0392b;}
    .menu{border-color:#27ae60;color:#27ae60;}
  </style>
</head>
<body>
<h1>Assignment Task 2 - Registration Form</h1>
<section>
  <?php
    if($user->isLoggedIn()){
  ?>
    <fieldset class="menu">
      <a href="secure.php">Secure</a>
      <a href="logout.php">Logout</a>
    </fieldset>
  <?php
    }else{
  ?>
  <?php
      if(isset($errors)){
  ?>
  <fieldset class="errors">
  <?php
        foreach($errors as $key => $value){
          echo $key . ': ' . $value . '<br/>';
        }
  ?>
  </fieldset>
  <?php
      }
  ?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
  <fieldset>
    <legend>Enter your registration details</legend>
    <label for="username">Username: </label>
    <input type="text" maxlength="20" required name="username" id="username" value="<?php echo $_POST ? $_POST['username'] : ''; ?>">
    <label for="username">Password: </label>
    <input type="password" required name="password" id="password">
    <label for="email">Email: </label>
    <input type="email" required name="email" id="email" value="<?php echo $_POST ? $_POST['email'] : ''; ?>">
    <label for="url">Webpage URL: </label>
    <input type="url" name="url" id="url" value="<?php echo $_POST ? $_POST['url'] : ''; ?>">
    <label for="dob">Date of birth: </label>
    <input type="date" required name="dob" id="dob" value="<?php echo $_POST ? $_POST['dob'] : ''; ?>">
  </fieldset>
  <button type="submit" name="submit" formnovalidate>Submit Details</button>
</form>
</section>
<?php
    }
?>
</body>
</html>