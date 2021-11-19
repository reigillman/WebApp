<?php
include 'run.php';
session_start();
$friendComment=$pdo->query("SELECT * FROM friends WHERE fromUser='".$_SESSION['userId']."' OR toUser='".$_SESSION['userId']."'");
echo("<center><h3>Friend Activity:</h3></center>");
while($friend=$friendComment->fetch()){
	if(($friend['status']=='accepted') && $friend['toUser'] == $_SESSION['userId']){
		$friendName=$pdo->query("SELECT * FROM users, comments, movies WHERE users.userId='".$friend['fromUser']."' AND comments.userId='"
		.$friend['fromUser']."' AND comments.movieId= movies.movieId ORDER BY commentTime DESC LIMIT 3");
		while($activity=$friendName->fetch()){
		echo("<center><b>".$activity['username']." (".$activity['title']."): </b><br>".$activity['content']."<br></center>");
		}
	}
	else if(($friend['status']=='accepted') && $friend['fromUser'] == $_SESSION['userId']){
		$friendName=$pdo->query("SELECT * FROM users, comments, movies WHERE users.userId='".$friend['toUser']."' AND comments.userId='"
		.$friend['toUser']."' AND comments.movieId= movies.movieId ORDER BY commentTime DESC LIMIT 3");
		while($activity=$friendName->fetch()){
		echo("<center><b>".$activity['username']." (".$activity['title']."): </b><br>".$activity['content']."<br></center>");
		}
	}
}
?>