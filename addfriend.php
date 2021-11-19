<?php
include 'run.php';
session_start();
$sql= "INSERT INTO friends
		(toUser, fromUser, status )
	VALUES
		(:toUser, :fromUser, :status)";


$stmt= $pdo->prepare($sql);

$status= 'pending';

$stmt->bindParam(':toUser', $_GET['userId']);
$stmt->bindParam(':fromUser', $_SESSION['userId']);
$stmt->bindParam(':status', $status);

$stmt->execute();

header('Location: http://localhost/movie%20reviews/specificmovie.php?movieId='.$_GET['movieId']);
?>