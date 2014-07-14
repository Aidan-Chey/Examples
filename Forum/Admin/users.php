<?php 
/*Editing*/
if(isset($_POST['action']) && $_POST['action'] == 'Edit'){
	
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
	elseif($_POST['email'] != $editUser['email']){
		foreach($users as $user){
			if($_POST['email'] == $user['email']){
				$emailError .= "Email already taken.";
			}
		}
	}
	

	//Validate Name
	if(empty($_POST['name'])){
		$nameError .= "Please enter a display name.";
	}
	elseif(strlen($_POST['name']) > 50){
		$nameError .= "Please enter a shorter name (max 50 characters).";
	}
	elseif($_POST['name'] != $editUser['name']){
		foreach($users as $user){
			if($_POST['name'] == $user['name'] && $_POST['name'] != '[Removed]'){
				$nameError .= "Name already taken.";
			}
		}
	}

	//Validate Passwords
	if(!empty($_POST['password']) && strlen($_POST['password']) > 100){
		$passError .= "Please enter a shorter password (max 100 characters)";
	}

	//Validate Role
	if(empty($_POST['role'])){
		$roleError .= "Please enter a role.";
	}
	elseif(!in_array($_POST['role'], $roles)){
		$roleError .= "Please use a role in the dropdown list.";
	}

	//If no errors
	if(empty($emailError) && empty($passError) && empty($nameError) && empty($roleError)){
		//Update Information in DB
		try{
			$sql = 'UPDATE Users 
				SET Email = :email, Name = :name, Role = :role 
				WHERE ID = :id';
			$s = $pdo->prepare($sql);
			$s->bindValue(':email', $_POST['email']);
			$s->bindValue(':role', $_POST['role']);
			$s->bindValue(':name', $_POST['name']);
			$s->bindValue(':id', $_POST['id']);
			$s->execute();
		}
		catch (PDOException $e){
			$error = 'Error editing user.';
			include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/error.html.php';
			exit();
		}
		$_SESSION['messages'] = " User Edited!";
	}
}
/*Deleteing*/
elseif(isset($_POST['action']) && $_POST['action'] == 'Delete'){
	try{
		$pdo->query('UPDATE Users SET Name = "", Password = "", Role = "" WHERE ID = '.$_POST['id']);
	}
	catch (PDOException $e){
		$error = 'Error deleting user.';
		include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/error.html.php';
		exit();
	}
	$_SESSION['messages'] = " User Deleted!";
}