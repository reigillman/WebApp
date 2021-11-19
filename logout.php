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
session_start();
session_unset();
session_destroy();
header('Location: http://localhost/movie%20reviews/loginorsignup.php');
exit();
?>