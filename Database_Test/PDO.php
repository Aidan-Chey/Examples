<?php 

try{
	$pdo = new PDO('mysql:host=localhost;dbname=aidanche_forum', 'aidanche_forum',
	'34djw*@ui4jf*');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$pdo->exec('SET NAMES "utf8"');
}
catch (PDOException $e){
	echo $e->getMessage();
	exit();
}