<?php
include 'run.php';

	$sql= 'INSERT INTO users
		(username, password)
	VALUES
		(:username, :password)';

	$stmt= $pdo->prepare($sql);

	$stmt->bindParam (':username', $_POST['usernameCreate']);
	
	$userAlreadyExists= $pdo->prepare("SELECT * FROM users WHERE username = ?");
	$userAlreadyExists->execute([$_POST['usernameCreate']]);
	$user= $userAlreadyExists->fetch();
	
	if($user['username'] == $_POST['usernameCreate']){
		echo 'ERROR: Username is already taken.';
		exit();
	}

	$encryptpass= password_hash($_POST['passCreate'], PASSWORD_BCRYPT);

	$stmt->bindParam (':password', $encryptpass);

	$stmt->execute();
	header('Location: http://localhost/movie%20reviews/loginorsignup.php');
		exit();

?>