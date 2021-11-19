<?php
try {
$pdo = new PDO('mysql:host=localhost;dbname=moviesite', 'root', 'root');
$pdo->setAttribute (PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec ('SET NAMES "utf8"');
}
catch (PDOException $e){
echo $e->getMessage ();
exit();
}
session_start();
$sql= 'INSERT INTO ratings
		(rating, movieId, userId)
	VALUES
		(:rating, :movieId, :userId)';
		

$stmt= $pdo->prepare($sql);
$stmt->bindParam(':rating', $_POST['rating']);
$stmt->bindParam(':movieId', $_GET['movieId']);
$stmt->bindParam('userId', $_SESSION['userId']);

$stmt->execute();

header('Location: http://localhost/movie%20reviews/specificmovie.php?movieId='.$_GET['movieId']);

?>