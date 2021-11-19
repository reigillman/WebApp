<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>User</title>
<style type="text/css">
#wrapper{
	max-width: 960px;
	margin-right:auto;
	margin-left:auto;
	}
.profilepic {
  float: left;
  width: 150px;
  height: 150px;
  margin-left: 300px;
  border-style: double;
  background: gray;
  padding: 15px;
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
session_start();
  echo("<li><a href='home.php'>Home</a></li>
  <li><a href='specificuser.php?userId=".$_SESSION['userId']."'>My Profile</a></li>
  <li><a href='contact.html'>Contact Us</a></li>");
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
<?php 
include 'run.php';
$user= $_GET['userId'];
$thisUser= $pdo->query("SELECT * FROM users WHERE userId='".$user."'");
$getUser= $thisUser->fetch();
echo("<center><h1>".$getUser['username']);
if($getUser['adminFlag'] == 'admin'){
	echo("(Admin)</h1></center>");
}
else{
	echo("</h1></center>");
}
?>
<p>
<div class="profilepic"><?php
if(($_SESSION['userId'] == $getUser['userId']) && $getUser['avatar']== null){
echo("<form action='userprofileinput.php?userId=".$_SESSION['userId']."' enctype='multipart/form-data' method='POST'>
	<label>Upload Avatar:</label>
	<input type='file' name='upload' accept='.png'>
	<input type='submit' value='Submit'>
	</form>");
}
else{
	if($getUser['avatar']== null){
		echo("User has not uploaded an avatar yet.");
	}
	else{
	echo ("<img src= 'avatars/".$getUser['avatar']."(thumbnail).png' >");
	}
}
?></div>
<br>
<h4>Friends:</h4>
<?php 
$userFriends= $pdo->query("SELECT * FROM friends WHERE fromUser='".$user."' OR toUser='".$user."'");
while($getFriends= $userFriends->fetch()){
	if((($getFriends['status'] == 'accepted') && $getFriends['fromUser'] == $_SESSION['userId']) && $getFriends['toUser'] != $user){
		$friendName=$pdo->query("SELECT * FROM users WHERE userId='".$getFriends['toUser']."'");
		$name=$friendName->fetch();
		echo("<a href='specificuser.php?userId=".$name['userId']."'>".$name['username']."</a><br>");
	}
	else if((($getFriends['status'] == 'accepted') && $getFriends['toUser'] == $_SESSION['userId']) && $getFriends['fromUser'] != $user){
		$friendName2=$pdo->query("SELECT * FROM users WHERE userId='".$getFriends['fromUser']."'");
		$name2=$friendName2->fetch();
		echo("<a href='specificuser.php?userId=".$name2['userId']."'>".$name2['username']."</a><br>");
	}
}

?>
<br></p>
<?php
if($_SESSION['userId'] == $user){
	if($getUser['description'] == null){
		echo("<center><form action='userdescupdate.php?userId=".$_SESSION['userId']."' method='POST'><label><b>About</b></label><br>
        <textarea name='description' placeholder='Write something..' style='height:100px; width: 400px'></textarea>
		<input type='submit' name='submit' value='Submit'>
		</form></center>
		<br>");
	}
	else{
		echo("<label><b>About:</b></label><br>".$getUser['description']);
		echo("<center><form action='userdescupdate.php?userId=".$_SESSION['userId']."' method='POST'><br>
        <textarea name='description' placeholder='Write something..' style='height:100px; width: 400px'></textarea>
		<input type='submit' name='update' value='Update'>
		</form></center>
		<br>");
	}
}
else{
	echo("<label><b>About:</b></label><br>".$getUser['description']);
}
?>
<br>
<br>
<br>
<br>
<br>
<br>
<center>Recent Ratings:</center>
<?php
$ratings=$pdo->query("SELECT * FROM ratings, movies WHERE ratings.userId='".$getUser['userId']."' AND ratings.movieId= movies.movieId ORDER BY ratingId DESC LIMIT 5");
while($getRatings= $ratings->fetch()){
	echo("<center><b><a href='specificmovie.php?movieId=".$getRatings['movieId']."'>".$getRatings['title']."</a>: </b>".$getRatings['rating']." <br></center>");
}
?>
<br>
</p>
</div>
</body>
</html>