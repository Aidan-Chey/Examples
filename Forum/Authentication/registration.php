<?php 
//Validate Email
if(empty($_POST['email'])){
	$emailError .= "Please enter a email.";
}
elseif(strlen($_POST['email']) > 100){
	$emailError .= "Please enter a shorter email (max 100 characters).";
}
elseif(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
	$emailError .= "Please enter a valide email.";
}

//Validate Name
if(empty($_POST['name'])){
	$nameError .= "Please enter a display name.";
}
elseif(strlen($_POST['name']) > 50){
	$nameError .= "Please enter a shorter name (max 50 characters).";
}
//Validate Passwords
if(empty($_POST['password'])){
	$passError .= "Please enter a password.";
}
elseif(strlen($_POST['password']) > 100){
	$passError .= "Please enter a shorter password (max 100 characters)";
}
elseif($_POST['password'] != $_POST['password2']){
	$passError .= "Your passwords were not the same.";
}
//If no errors
if(empty($emailError) && empty($passError) && empty($nameError)){
	//Connect to Database
	include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/db.inc.php';

	//Insert Information into DB
	try{
		$sql = 'INSERT INTO Users SET Email = :email, Role = :role, Name = :name';
		$s = $pdo->prepare($sql);
		$s->bindValue(':email', $_POST['email']);
		$s->bindValue(':role', "Basic");
		$s->bindValue(':name', $_POST['name']);
		$s->execute();
	}
	catch (PDOException $e){
		$error = 'Error adding submitted user. ';
		include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/error.html.php';
		exit();
	}

	$userId = $pdo->lastInsertId();
	if (!empty($_POST['password'])){
		$password = md5($_POST['password'] . 'f0rum');
		try{
			$sql = 'UPDATE Users SET Password = :password WHERE ID = :id';
			$s = $pdo->prepare($sql);
			$s->bindValue(':password', $password);
			$s->bindValue(':id', $userId);
			$s->execute();
		}
		catch (PDOException $e){
			$error = 'Error setting user password. ';
			include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/error.html.php';
			exit();
		}
	}
	$messages .= " Account created!";

	//Log them in
	$password = md5($_POST['password'] . 'f0rum');
	$_SESSION['loggedIn'] = TRUE;
	$_SESSION['email'] = $_POST['email'];
	$_SESSION['password'] = $password;
	unset($_POST['password']);
	header("Location: ".$_SESSION['previousPage']."&Messages= Now Logged in!");
	exit();
}