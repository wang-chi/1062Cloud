<?php

session_start();

if( isset($_SESSION['user_id']) ){
	header("home.php");
}

require 'database.php';

if(!empty($_POST['account']) && !empty($_POST['password'])):
	$records = $conn->prepare('SELECT id,account,password FROM users WHERE account = :account');
	$records->bindParam(':account', $_POST['account']);
	$records->execute();
	$results = $records->fetch(PDO::FETCH_ASSOC);

	$message = '';
	$pw = password_verify($_POST['password'], $results['password']);
	if(count($results) > 0 && $pw ){
		
		$_SESSION['user_id'] = $results['id'];
		header("Location:home.php");

	} else {
		$message = 'Sorry, those credentials do not match';
	}

endif;

?>

<!DOCTYPE html>
<html>
<head>
	<title>Login Below</title>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link href='http://fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet' type='text/css'>
</head>
<body>

	<div class="header">
		<a href="/">Your App Name</a>
	</div>

	<?php if(!empty($message)): ?>
		<p><?= $message ?></p>
	<?php endif; ?>

	<h1>Login</h1>
	<span>or <a href="register.php">register here</a></span>

	<form action="login.php" method="POST">
		
		<input type="text" placeholder="Enter your account" name="account">
		<input type="password" placeholder="and password" name="password">

		<input type="submit">

	</form>

</body>
</html>