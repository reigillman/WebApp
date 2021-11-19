<?php
try {
$pdo = new PDO('mysql:host=127.0.0.1;dbname=moviesite', 'root', 'root');
$pdo->setAttribute (PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec ('SET NAMES "utf8"');
}
catch (PDOException $e){
echo $e->getMessage ();
exit();
}
?>