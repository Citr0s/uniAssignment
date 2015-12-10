<?php
	require_once('bootstrap.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Secure</title>
</head>
<body>
	<p>Hello, <?php echo $_SESSION['user']['username']->getSanitisedValue(); ?>!</p>
	<a href="registration.php">< Back</a>
</body>
</html>