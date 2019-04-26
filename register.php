<?php

session_start();

if( isset($_SESSION['user_id']) ){
	header("Location: index.php");
}

require 'database.php';

$message = '';

if(!empty($_POST['account']) && !empty($_POST['password'])):
	// Check the account of user
	$records = $conn->prepare('SELECT account FROM users WHERE account = :account');
	$records->bindParam(':account', $_POST['account']);
	$records->execute();
	$results = $records->fetch(PDO::FETCH_ASSOC);

	$message = '';
	if(count($results) > 1 ){
		//duplicate user
		$message = 'Sorry, this mail can\'t use';
	} else {
		echo 'new user';
		// Enter the new user in the database
		$sql = "INSERT INTO users (account, password) VALUES (:account, :password)";
		$stmt = $conn->prepare($sql);

		$stmt->bindParam(':account', $_POST['account']);
		$pw = password_hash($_POST['password'], PASSWORD_BCRYPT);
		$stmt->bindParam(':password', $pw);
	
		if( $stmt->execute() ):
			$message = 'Successfully created new user';
			header("Location: index.php");
		else:
			$message = 'Sorry there must have been an issue creating your account';
		endif;
	}
	

endif;

?>

<!DOCTYPE html>
<html>
<head>
	<title>Register Below</title>
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

	<h1>Register</h1>
	<span>or <a href="login.php">login here</a></span>

	<form action="register.php" method="POST">
		
		<input type="text" placeholder="Enter your account" name="account">
		<input type="password" placeholder="and password" name="password">
		<input type="password" placeholder="confirm password" name="confirm_password">
		<input type="submit">

	</form>

</body>
</html>