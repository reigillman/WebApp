<?php
include 'run.php';
session_start();
$accept= $pdo->prepare("UPDATE friends SET status='accepted' WHERE toUser='".$_SESSION['userId']."' AND fromUser='"
					.$_POST['fromUser']."'");
$reject= $pdo->prepare("UPDATE friends SET status='rejected' WHERE toUser='".$_SESSION['userId']."' AND fromUser='"
					.$_POST['fromUser']."'");
	if(isset($_POST['accept'])){
		$accept->execute();
		echo json_encode(array('result' => 1));
		}
	else if(isset($_POST['reject'])){
		$reject->execute();
		echo json_encode(array('result' => 2));
	}
?>