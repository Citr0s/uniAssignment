<?php
  require_once 'bootstrap.php';

  use Assignment\Person;
  use Assignment\Student;

  if($_POST){
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $age = $_POST['age'];
    $studentId = $_POST['studentId'];

    $person = new Person($firstName, $lastName);

    if(!empty($studentId)){
      $person = new Student($firstName, $lastName);
      $person->setStudentId($studentId);
    }

    $person->setAge($age);

    var_dump($person);
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
  </style>
</head>
<body>
<h1>Assignment Task 2 - Registration Form</h1>
<section>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
  <fieldset>
    <legend>Enter your registration details</legend>
    <label for="username">Username: </label>
    <input type="text" maxlength="20" required name="username" id="username">
    <label for="username">Password: </label>
    <input type="password" required name="password" id="password">
    <label for="email">Email: </label>
    <input type="email" required name="email" id="email">
    <label for="url">Webpage URL: </label>
    <input type="url" name="url" id="url">
    <label for="dob">Date of birth: </label>
    <input type="date" required name="dob" id="dob">
  </fieldset>
  <button type="submit" name="submit" formnovalidate>Submit Details</button>
</form>
</section>
</body>
</html>