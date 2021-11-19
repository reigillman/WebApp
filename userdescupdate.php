<?php
include 'run.php';
session_start();
	$update=$pdo->prepare("UPDATE users SET description=:description WHERE userId=:userId");
	$update->bindParam(':description', $_POST['description']);
	$update->bindParam(':userId', $_SESSION['userId']);
	$update->execute();
	header('Location: http://localhost/movie%20reviews/specificuser.php?userId='.$_SESSION['userId']);
	exit();
	
?>