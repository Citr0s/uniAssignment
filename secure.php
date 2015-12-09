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
	Hello, <?php echo $session->read(session_id())[0]['data']; ?>!
</body>
</html>