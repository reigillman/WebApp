<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Recommended</title>
<style type="text/css">
.box { border: 1px solid black; 
	text-align:center;}
#wrapper{
	max-width: 960px;
	margin-right:auto;
	margin-left:auto;
	}
ul {
  list-style-type:none;
  margin:0;
  padding:0;
  overflow:hidden;
  background-color:gray;
}

li {
  float:left;
}

li a {
  display:block;
  padding:14px 16px;
}
</style>
</head>

<body>
<div id="wrapper"><ul>
<?php
include "run.php";
session_start();
  echo("<li><a href='home.php'>Home</a></li>");
  if(isset($_SESSION['userId'])){
  echo("<li><a href='specificuser.php?userId=".$_SESSION['userId']."'>My Profile</a></li>");
  }
  echo("<li><a href='contact.html'>Contact Us</a></li>");
  if (isset($_SESSION['LOGIN']) && $_SESSION['LOGIN']== true){
  echo "<li><a href='logout.php'>Logout</a></li>";
  }
  else {
  echo "<li><a href='logout.php'>SignUp/Login</a></li>";
  }
  if ((isset($_SESSION['LOGIN']) && $_SESSION['LOGIN']== true) && $_SESSION['isAdmin'] == true){
  echo "<li><a href='adminaddmovie.php'>Add Movie+</a></li>";
  }
  ?>
 </ul></div>
<br>
	<center><h1>Recommended:</h1></center>
	<br>
	<p><div class="box">
	<br><br>
<?php 
if(isset($_SESSION['userId'])){
$userFriends= $pdo->query("SELECT * FROM friends WHERE fromUser='".$_SESSION['userId']."' OR toUser='".$_SESSION['userId']."'");
while($getFriends= $userFriends->fetch()){
	if((($getFriends['status'] == 'accepted') && $getFriends['fromUser'] == $_SESSION['userId']) && $getFriends['toUser'] != $_SESSION['userId']){
		$friendName=$pdo->query("SELECT * FROM users WHERE userId='".$getFriends['toUser']."'");
		$name=$friendName->fetch();
		
		$count=$pdo->query("SELECT movieId, COUNT(movieId) AS totalRatings FROM ratings WHERE rating='10' GROUP BY movieId");
		while($getCount= $count->fetch()){
		$movie=$pdo->query("SELECT * FROM movies WHERE movieId='".$getCount['movieId']."'");
		$getMovie=$movie->fetch();
		$rating=$pdo->query("SELECT * FROM ratings WHERE userId='".$getFriends['toUser']."' AND rating='10'");
		while($getRating=$rating->fetch()){
		if($getCount['movieId']==$getRating['movieId']){
			echo("<center>".$name['username']. " rated <b><a href='specificmovie.php?movieId=". $getMovie['movieId'] ."'>".$getMovie['title']."</a></b> a 10! Total number of max ratings for this movie: <b>"
			.$getCount['totalRatings']."</b></center>");
		}
		}
		}
	}
	else if((($getFriends['status'] == 'accepted') && $getFriends['toUser'] == $_SESSION['userId']) && $getFriends['fromUser'] != $_SESSION['userId']){
				$friendName=$pdo->query("SELECT * FROM users WHERE userId='".$getFriends['fromUser']."'");
		$name=$friendName->fetch();
		
		$count=$pdo->query("SELECT movieId, COUNT(movieId) AS totalRatings FROM ratings WHERE rating='10' GROUP BY movieId");
		while($getCount= $count->fetch()){
		$movie=$pdo->query("SELECT * FROM movies WHERE movieId='".$getCount['movieId']."'");
		$getMovie=$movie->fetch();
		$rating=$pdo->query("SELECT * FROM ratings WHERE userId='".$getFriends['fromUser']."' AND rating='10'");
		while($getRating=$rating->fetch()){
		if($getCount['movieId']==$getRating['movieId']){
			echo("<center>".$name['username']. " rated <b><a href='specificmovie.php?movieId=". $getMovie['movieId'] ."'>".$getMovie['title']."</a></b> a 10! Total number of max ratings for this movie: <b>"
			.$getCount['totalRatings']."</b></center>");
		}
		}
		}
	}
}
}
else{
	echo("<center>You are not logged in!</center>");
}
?>
  <br><br><br><br>
</div>
</p>
</body>
</html>