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
  <li><a href="home.php">Home</a></li>
  <li><a href="movies.php">Movies</a></li>
  <li><a href="contact.html">Contact Us</a></li>
  <?php 
  session_start();
  include 'run.php';
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
	<center><h1>Movies</h1>
	<?php
$movie= $pdo->query("SELECT * FROM movies WHERE title LIKE '%".$_GET['keyword']."%'");
$movieExist= false;
while($getMovies= $movie->fetch()){
	echo("<a href='specificmovie.php?movieId=".$getMovies['movieId'] ."'>" . $getMovies['title'] . "</a><br>");
	$movieExist= true;
}
if($movieExist == false){
	echo("No movies match your search...");
}
	?>
	</center>
</div>
</body>
</html>
