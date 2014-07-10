<?php
if(isset($_POST['register'])){
	/****Validate Email******/
	if(empty($_POST['email'])){
		$emailError .= "Please enter a email.";
	}
	elseif(strlen($_POST['email']) > 100){
		$emailError .= "Please enter a shorter email (max 100 characters).";
	}
	elseif(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
		$emailError .= "Please enter a valide email.";
	}

	/****Validate Name******/
	if(empty($_POST['name'])){
		$nameError .= "Please enter a display name.";
	}
	elseif(strlen($_POST['name']) > 50){
		$nameError .= "Please enter a shorter name (max 50 characters).";
	}
	/****Validate Passwords******/
	if(empty($_POST['password'])){
		$passError .= "Please enter a password.";
	}
	elseif(strlen($_POST['password']) > 100){
		$passError .= "Please enter a shorter password (max 100 characters)";
	}
	elseif($_POST['password'] != $_POST['password2']){
		$passError .= "Your passwords were not the same.";
	}
	/****If no errors******/
	if(empty($emailError) && empty($passError) && empty($nameError)){
		/****Connect to Database******/
		include $_SERVER['DOCUMENT_ROOT'].'/includes/db.inc.php';

		/****Insert Information into DB******/
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
			include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
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
				include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
				exit();
			}
		}
		$messages .= " Account created!";

		/****Log them in******/
		$password = md5($_POST['password'] . 'f0rum');
		$_SESSION['loggedIn'] = TRUE;
		$_SESSION['email'] = $_POST['email'];
		$_SESSION['password'] = $password;
		unset($_POST['password']);
		header("Location: ".$_SESSION['previousPage']."&Messages= Now Logged in!");
		exit();
	}
}
?>
<p>
	This form will add you as User so you can post in this forum.
</p>
<form action="" method="post">
	<p>
		<label for="email">Email Address: </label><br>
		<input type="email" name="email" id="email" maxlength="100" value="<?php if(!empty($_POST['email'])) htmlout($_POST['email']); ?>" required><br>
		<?php if(!empty($emailError)): ?>
			<span class="error"><?php echo $emailError; ?></span>
		<?php endif; ?>
	</p>
	<p>
		<label for="name">Display Name: </label><br>
		<input name="name" id="name" maxlength="50" value="<?php if(!empty($_POST['name'])) htmlout($_POST['name']); ?>" required><br>
		<?php if(!empty($nameError)): ?>
			<span class="error"><?php echo $nameError; ?></span>
		<?php endif; ?>
	</p>
	<p>
		<label for="password">Password: </label><br>
		<input type="password" name="password" id="password" maxlength="120" required><br>
		<label for="password2">Confirm Password: </label><br>
		<input type="password" name="password2" id="password2" maxlength="120" required>
		<?php if(!empty($passError)): ?>
			<span class="error"><?php echo $passError; ?></span>
		<?php endif; ?>
	</p>
	<input type="hidden" name="register">
	<button>Register</button>
</form>