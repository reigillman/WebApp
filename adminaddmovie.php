<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Add Movie</title>
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
	<center><h1>Add Movie</h1>
	Admins can add movies here. They will fill out boxes with information needed to add a movie.
	<br>
	Everything is required aside from people involved (actors, director, writer, and musicians) which can be added later if needed
	<br>
	<br>
<form action="addmovie.php" enctype="multipart/form-data" method="POST">
 <label>Title</label>
        <input type="text" name="title" required>
		<br>
        <label>Description</label>
        <textarea name="description" placeholder="Write something.." style="height:200px; width: 350px" required></textarea>
		<br>
		<label>Genre</label>
		<input type="text" name="genre" placeholder="Genre" required>
		  <br>
		  <br>
		  <label>Upload Poster:</label>
		  <input type="file" name="upload" accept=".png">
		  <br>
		  <br>
		  <label>Movie Length</label>
        <input type="text" name="length" placeholder="Minutes" required>
		<br>
		<label>Release Date</label>
        <input type="text" name="date" placeholder="YYYY-MM-DD" required>
		<br>
		<label>Studio</label>
        <input type="text" name="studio" required>
		<br>
		<br>
		 <label>Actors</label>
        <input type="text" name="actor">
		<br>
		 <label>Director</label>
        <input type="text" name="director">
		<br>
		<label>Writer</label>
        <input type="text" name="writer">
		<br>
		<label>Musicians</label>
        <input type="text" name="musician">
        <br>
		<br>
		<input type="submit" value="Submit">
</center></p>
</form>
</body>
</html>
