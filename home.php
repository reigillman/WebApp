<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Home</title>
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
	<center><h1>Home</h1></center>
	<br>
	<?php
	if(isset($_SESSION['userId'])){
$isFriend= $pdo->query("SELECT * FROM users, friends WHERE users.userId= friends.fromUser AND friends.toUser='".$_SESSION['userId']."'");
$request= $isFriend->fetch();
if($request== True){
	if(($request['toUser'] == $_SESSION['userId']) && ($request['status'] == 'pending')){
		echo("<form id='friendRequest' method='POST' action='acceptorreject.php?fromUser=".$request['fromUser']."'>
		<center><h3>FRIEND REQUEST FROM:<br>".$request['username']."</h3><input id= 'accept' type='button' name='accept' value='accept' data-user='".$request['fromUser']."'>
		<input id='reject' type='button' name='reject' value='reject' data-user='".$request['fromUser']."'></center></form>
		
		<form id='friendActivity'></form>");
	}
	else if(($request['toUser'] == $_SESSION['userId'] || $request['fromUser'] == $_SESSION['userId'])
		&& $request['status'] == 'accepted'){
			echo("<form id='friendActivity'></form>");
}
}
}

	?>
	<p><div class="box">
	<br><br><br>
	<h3>Search Movie:</h3>
	<form action='moviesearch.php' method='POST'>
	<input type="text" name="search" placeholder="search..."><input type="submit" value="Search">
	</form>
	<br><br>
	<h3>Recent Movies:</h3>
<?php 
$movies= $pdo->query("SELECT * FROM movies ORDER BY movieId DESC LIMIT 10");
while($getMovies= $movies->fetch()){
	echo("<a href='specificmovie.php?movieId=". $getMovies['movieId'] ."'>" . $getMovies['title'] . "</a><br>");
}
?>
  <br><br><br><br>
</div>
</p>
<script type="text/javascript" src="jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="friendrequest.js"></script>
</body>
</html>
