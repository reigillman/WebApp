<?php
include 'run.php';

$FILE_DIR= 'avatars/';
$myNumber= $pdo->query("SELECT COUNT(*) AS numUsers FROM users WHERE avatar IS NOT NULL");
	$getNumber= $myNumber->fetch();
	$newName= $getNumber['numUsers'] + 1;
if($_FILES['upload']['error']){
		echo "ERROR: Please try to upload the avatar again.";
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

			$thumbHeight= 100;
			$thumbWidth= floor($width * ($thumbHeight/$height));
			$thumbnail= imagecreatetruecolor($thumbWidth, $thumbHeight);
			imagecopyresampled ($thumbnail, $image, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $width, $height);
			imagepng($thumbnail, $FILE_DIR.$newName.'(thumbnail).png');
		}
	}
$stmt=$pdo->prepare("UPDATE users SET avatar='".$newName."' WHERE userId='".$_GET['userId']."'");
$stmt->execute();
var_dump($_GET['userId']);
//header('Location: http://localhost/movie%20reviews/specificuser.php?userId='.$_GET['userId']);

?>