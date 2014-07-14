<?php 
if($_POST['action'] == 'Reset'){
	//Connect to Database
	include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/db.inc.php';

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
	else{
		$_POST['email'] = strtolower($_POST['email']);
		//Compare submitted Email
		try{
			$sql = 'SELECT COUNT(*) FROM Users WHERE Email = :email';
			$s = $pdo->prepare($sql);
			$s->bindValue(':email', $_POST["email"]);
			$s->execute();
		}
		catch (PDOException $e){
			$error = 'Error searching for Email.';
			include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/error.html.php';
			exit();
		}
		$row = $s->fetch();
		if ($row[0] == 0 || $_POST["email"] == "admin@email.com"){
			$emailError .= "Email does not exist.";
		}
	}

	//Validate Passwords
	if(empty($_POST['password'])){
		$passError .= "Please enter a password.";
	}
	elseif(strlen($_POST['password']) > 100){
		$passError .= "Please enter a shorter password (max 100 characters)";
	}

	//If no errors
	if(empty($emailError) && empty($passError)){
		$password = md5($_POST['password'] . 'f0rum');
		try{
			$sql = 'UPDATE Users SET Password = :password WHERE Email = :email';
			$s = $pdo->prepare($sql);
			$s->bindValue(':password', $password);
			$s->bindValue(':email', $_POST["email"]);
			$s->execute();
		}
		catch (PDOException $e){
			$error = 'Error setting user password.';
			include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/error.html.php';
			exit();
		}
		session_start();
		header("Location: ".$_SESSION['previousPage']."&Messages=".urlencode(' Password changed!'));
		exit();
	}
}