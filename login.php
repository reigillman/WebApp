<?php
include 'run.php';
	$stmt= $pdo->prepare("SELECT * FROM users WHERE username = ?");
	$stmt->execute([$_POST['username']]);
	$user= $stmt->fetch();
	
	if(password_verify($_POST['password'], $user['password'])){
		session_start();
		session_regenerate_id (true);
		$_SESSION['LOGIN']= true;
		$_SESSION['userId']= $user['userId'];
		if(isset($_SESSION['LOGIN'])){
			if($user['adminFlag'] != NULL){
			$_SESSION['isAdmin']= true;
			header('Location: http://localhost/movie%20reviews/home.php');
		}
		else {
			$_SESSION['isAdmin']= false;
			header('Location: http://localhost/movie%20reviews/home.php');
		}
	}
	}
	else {
		sleep(3);
		echo ("<script>
		alert('ERROR: Incorrect password!');
		window.location.href='http://localhost/movie%20reviews/loginorsignup.php';
		</script>");
	}

?>