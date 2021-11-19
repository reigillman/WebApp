<?php
include 'run.php';
session_start();
$sql= 'INSERT INTO comments
		(content, movieId, userId)
	VALUES
		(:content, :movieId, :userId)';


$stmt= $pdo->prepare($sql);
$stmt->bindParam(':content', $_POST['comment']);
$stmt->bindParam(':movieId', $_GET['movieId']);
$stmt->bindParam(':userId', $_SESSION['userId']);

$stmt->execute();

header('Location: http://localhost/movie%20reviews/specificmovie.php?movieId='.$_GET['movieId']);
?>