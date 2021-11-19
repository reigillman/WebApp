<?php
include 'run.php';

	$sql= 'INSERT INTO users
		(description)
	VALUES
		(:description)';

	$stmt= $pdo->prepare($sql);
	$stmt->bindParam (':description', $_POST['description']);
	
	$stmt->execute();
	header('Location: http://localhost/movie%20reviews/specificuser.php?userId='.$_SESSION['userId']);
	exit();
	
?>