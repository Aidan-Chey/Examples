<?php 
	try{
		$pdo = new PDO('mysql:host=sql310.freewebhost.co.nz;dbname=freew_13553164_94686', 'freew_13553164',
		'nt6sr15w');
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$pdo->exec('SET NAMES "utf8"');
	}
	catch (PDOException $e){
		$error = 'Unable to connect to the database server.';
		include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
		exit();
	}