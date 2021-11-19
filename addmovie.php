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

$sql= 'INSERT INTO movies
		(title, description, genre, length, releaseDate, studio, poster)
	VALUES
		(:title, :description, :genre, :length, :releaseDate, :studio, :poster)';

$sql2= 'INSERT INTO people
		(actor, director, writer, musician)
	VALUES
		(:actor, :director, :writer, :musician)';
	
	$stmt= $pdo->prepare($sql);
	$stmt2= $pdo->prepare($sql2);
	
	$stmt->bindParam(':title', $_POST['title']);
	$stmt->bindParam(':description', $_POST['description']);
	$stmt->bindParam(':genre', $_POST['genre']);
	$stmt->bindParam(':length', $_POST['length']);
	$stmt->bindParam(':releaseDate', $_POST['date']);
	$stmt->bindParam(':studio', $_POST['studio']);
	
	$stmt2->bindParam(':actor', $_POST['actor']);
	$stmt2->bindParam(':director', $_POST['director']);
	$stmt2->bindParam(':writer', $_POST['writer']);
	$stmt2->bindParam(':musician', $_POST['musician']);
	
	$doesMovieExist= $pdo->query("SELECT * FROM movies WHERE title='".$_POST['title']."' AND '".$_POST['date']."'");
	$movieExist= $doesMovieExist->fetch();

	if($movieExist['title'] == $_POST['title'] && $movieExist['releaseDate'] == $_POST['date']){
			echo("ERROR: Movie already exists!");
			exit();
		}
	
	$FILE_DIR= 'posters/';
	
	$myNumber= $pdo->query("SELECT COUNT(*) AS numMovies FROM movies WHERE poster IS NOT NULL");
	$getNumber= $myNumber->fetch();
	$newName= $getNumber['numMovies'] + 1;
	
	if($_FILES['upload']['error']){
		echo "ERROR: Please try to upload the poster again.";
		exit();
	}
	else {
		if($_FILES['upload']['error'] == UPLOAD_ERR_OK){
			$finfo= new finfo(FILEINFO_MIME_TYPE);
			$ftype= $finfo->file($_FILES['upload']['tmp_name']);
			move_uploaded_file($_FILES['upload']['tmp_name'], $FILE_DIR.$newName.'.png');
			
			$image= imagecreatefrompng($FILE_DIR.$newName.'.png');
			$width= imagesx($image);
			$height= imagesy($image);

			$thumbHeight= 250;
			$thumbWidth= floor($width * ($thumbHeight/$height));
			$thumbnail= imagecreatetruecolor($thumbWidth, $thumbHeight);
			imagecopyresampled ($thumbnail, $image, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $width, $height);
			imagepng($thumbnail, $FILE_DIR.$newName.'(thumbnail).png');
		}
	}

	$stmt->bindParam(':poster', $newName);
	
	$stmt->execute();
	$stmt2->execute();
	header('Location: http://localhost/movie%20reviews/movies.php');
	exit();

?>