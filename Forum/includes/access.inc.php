<?php

//Login Check
function userIsLoggedIn(){
	session_start();
	if (isset($_SESSION['loggedIn'])){
		return databaseContainsUser($_SESSION['email'], $_SESSION['password']);
	}
}

function databaseContainsUser($email, $password){
	//Connect to Database
	include  $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/db.inc.php';

	//Compare _SESSIONed Email and Password
	try{
		$sql = "SELECT COUNT(*) FROM Users WHERE Email = :email AND Password = :password";
		$s = $pdo->prepare($sql);
		$s->bindValue(':email', $email);
		$s->bindValue(':password', $password);
		$s->execute();
	}
	catch (PDOException $e){
		$error = 'Error searching for User.';
		include  $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/error.html.php';
		exit();
	}
	$row = $s->fetch();
	if ($row[0] > 0){
		return TRUE;
	}
	else{
		return FALSE;
	}
}
function userHasRole($role){
	//Connect to Database
	include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/db.inc.php';

	if(empty($_SESSION['email'])){$email = null;}
	else{$email = $_SESSION['email'];}

	//Check User has Role
	try{
		$sql = "SELECT COUNT(*) FROM Users INNER JOIN UsersRole ON Role = UsersRole.Name WHERE Email = :email AND UsersRole.Name = :roleId";
		$s = $pdo->prepare($sql);
		$s->bindValue(':email', $email);
		$s->bindValue(':roleId', $role);
		$s->execute();
	}
	catch (PDOException $e){
		$error = 'Error searching for author roles.';
		include  $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/error.html.php';
		exit();
	}
	$row = $s->fetch();
	if ($row[0] > 0){
		return TRUE;
	}
	else{
		return FALSE;
	}
}