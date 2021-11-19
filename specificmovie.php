<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Movies</title>
<style type="text/css">
#wrapper{
	max-width: 960px;
	margin-right:auto;
	margin-left:auto;
	}
.poster{
  float: left;
  width: 250px;
  height: 250px;
  margin-left: 250px;
  border-style: double;
  background: gray;
  padding: 20px;
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

<script type="text/javascript" src="jquery-3.6.0.min.js"></script>

<body>
<div id="wrapper"><ul>
<?php
session_start();
  echo("<li><a href='home.php'>Home</a></li>");
  if(isset($_SESSION['userId'])){
  echo("<li><a href='specificuser.php?userId=".$_SESSION['userId']."'>My Profile</a></li>");
  }
  echo("<li><a href='contact.html'>Contact Us</a></li>");
  include "run.php";
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
	<center><h1><?php 
$movieId= $_GET['movieId'];
$myMovie= $pdo->query("SELECT * FROM movies WHERE movieId= '".$movieId. "'");
$people= $pdo->query("SELECT * FROM people WHERE peopleId= '".$movieId. "'");
$getMyMovie= $myMovie->fetch();
$getPeople= $people->fetch();
echo($getMyMovie['title']);
?></h1>
<h4><?php echo($getMyMovie['releaseDate'])?></h4>
	<p>
<div class="poster"><?php echo "<img src= 'posters/".$getMyMovie['poster']."(thumbnail).png' >"?></div>
<br>
<?php
$userRatedMovie= $pdo->query("SELECT * FROM ratings WHERE movieId= '".$_GET['movieId']. "' AND userId='".$_SESSION['userId']."'");
$averageRating= $pdo->query("SELECT AVG(rating) AS average FROM ratings WHERE movieId= '".$_GET['movieId']. "'");
$rating= $userRatedMovie->fetch();
$average= $averageRating->fetch();

if($rating == True){
	echo("<h2>Average Rating: " .$average['average'] . "</h2><br>");
	echo("<h4>Your Rating: " .$rating['rating'] . "</h4><br>");
}
else {

echo("<p>Rate This Movie: </p>
<form action='movieinput.php?movieId=".$movieId."' method='POST'>
<input type='number' name='rating' min='1' max='10'><input type='submit' value='Rate'>
</form>
<br>");
 
}
echo("<p><b><u>Genre: ".$getMyMovie['genre']. "</u></b></p>");
echo($getMyMovie['description']);
?>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
People involved: <?php echo("Actor: " . $getPeople['actor'] . "  Director: " . 
$getPeople['director'] . "  Writer: " . $getPeople['writer'] . "  Musician: " . $getPeople['musician']);?></a></a>
<br>
<br>
<br>
<h3>Comments</h3>
<?php
echo("<form action='addcomment.php?movieId=".$movieId."'  method='POST'>
<textarea name='comment' placeholder='Add a new comment..' style='height:75px; width: 350px'></textarea><input type='submit' value='Add Comment'>
</form>");

$isFriend= $pdo->query("SELECT * FROM users, friends WHERE users.userId= friends.fromUser OR users.userId= friends.toUser");
$userIdentify= $pdo->query("SELECT * FROM users, comments WHERE users.userId= comments.userId AND comments.movieId= '".$movieId. "' ORDER BY commentTime DESC LIMIT 10");
$friend= $isFriend->fetch();
while($user= $userIdentify->fetch()){
	if($friend== True){
		if(($friend['toUser']== $_SESSION['userId'] || $friend['fromUser'] == $_SESSION['userId']) 
	&& ($friend['toUser']== $user['userId'] || $friend['fromUser'] == $user['userId'])){
			if($user['userId'] == $_SESSION['userId']){
				//echo("<h4><u>" . $user['username'] . "   " . $user['commentTime']." [YOU]</u></h4>".$user['content']);
	}
			else if($friend['status']== 'pending'){
				echo("<h4><u>" . $user['username'] . "   " . $user['commentTime']." [PENDING FRIEND REQUEST]</u></h4>".$user['content']);
			}
			else if($friend['status']== 'rejected'){
				echo("<h4><u>" . $user['username'] . "   " . $user['commentTime']." [REJECTED FRIEND REQUEST]</u></h4>".$user['content']);
			}
			else{
				echo("<h4><u>" . $user['username'] . "   " . $user['commentTime']." [FRIEND]</u></h4>".$user['content']);
			}
		}
	}
	if($user['userId'] == $_SESSION['userId']){
		echo("<h4><u>" . $user['username'] . "   " . $user['commentTime']." [YOU]</u></h4>".$user['content']);
	}
	else {
		echo("<h4><u>" . $user['username'] . "   " . $user['commentTime'] . " <form action='addfriend.php?userId=".$user['userId']."&movieId=".$movieId."' method='POST'><input type='submit' value='+Friend'></u></h4></form>" .$user['content']);
	}
}
?>
</div>
</body>
</html>