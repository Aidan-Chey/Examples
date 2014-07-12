<?php include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/db.inc.php';

session_start();
$_SESSION['previousPage'] = $_SERVER['REQUEST_URI'];

/****Retrive user list****/
try{
	$result = $pdo->query('SELECT ID, Name, Email, Role FROM Users');
}
catch (PDOException $e){
	$error = 'Error fetching users from the database!';
	include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/error.html.php';
	exit();
}
foreach ($result as $row){
	$users[] = array('id' => $row['ID'], 'name' => $row['Name'], 'email' => $row['Email'], 'role' => $row['Role']);
}

/****Retrieve Role list****/
try {
	$result = $pdo->query('SELECT Name FROM UsersRole');
} 
catch (Exception $e) {
	$error = 'Error fetching roles from the database!';
	include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/error.html.php';
	exit();
}
foreach ($result as $row) {
	$roles[] = $row['Name'];
}

foreach ($users as $findUser) {
	if($findUser['id'] == $_POST['id']){
		$editUser = array('id' => $findUser['id'], 'name' => $findUser['name'], 'email' => $findUser['email'], 'role' => $findUser['role']);
	}
}
if(isset($_POST['action'])){
/*Editing*/
	if($_POST['action'] == 'Edit'){
		
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
		elseif($_POST['email'] != $editUser['email']){
			foreach($users as $user){
				if($_POST['email'] == $user['email']){
					$emailError .= "Email already taken.";
				}
			}
		}
		

		/****Validate Name******/
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

		/****Validate Passwords******/
		if(!empty($_POST['password']) && strlen($_POST['password']) > 100){
			$passError .= "Please enter a shorter password (max 100 characters)";
		}

		/****Validate Role****/
		if(empty($_POST['role'])){
			$roleError .= "Please enter a role.";
		}
		elseif(!in_array($_POST['role'], $roles)){
			$roleError .= "Please use a role in the dropdown list.";
		}

		/****If no errors******/
		if(empty($emailError) && empty($passError) && empty($nameError) && empty($roleError)){
			/****Update Information in DB******/
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
			header('Location: /Admin?Users&Messages='.urlencode(' User Edited!'));
		}
	}
/*Deleteing*/
	elseif($_POST['action'] == 'Confirm Delete'){
		try{
			$pdo->query('UPDATE Users SET Name = "[Removed]", Password = "", Role = "" WHERE ID = '.$_POST['id']);
		}
		catch (PDOException $e){
			$error = 'Error deleting user.';
			include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/error.html.php';
			exit();
		}
		header('Location: /Admin?Users&Messages='.urlencode(' User Deleted!'));		
	}
}
?>

<h3>Manage Users</h3>
<input class="section_hide" type='checkbox' id="newUser" <?php if(isset($_POST['showEdit'])){echo 'Checked';} ?>>
<div class="Seperate">
	<form action="" method="post">
		Edit user
		<p>
			<label for="Email">Email: </label><br>
			<input id="Email" type="email" name="email" value="<?php htmlout($editUser['email']); ?>">
			<?php if(!empty($emailError)): ?>
				<span class="error"><?php echo $emailError; ?></span>
			<?php endif; ?>
		</p>
		<p>
			<label for="DisplayName">Display Name: </label><br>
			<input id="DisplayName" name="name" value="<?php htmlout($editUser['name']); ?>">
			<?php if(!empty($nameError)): ?>
				<span class="error"><?php echo $nameError; ?></span>
			<?php endif; ?>
		</p>
		<p>
			<label for="Role">Role: </label><br>
			<select id="Role" name="role" >
				<?php foreach ($roles as $role): ?>
					<option <?php if($role == $editUser['role']){echo 'selected';} ?>><?php echo $role; ?></option>
				<?php endforeach ?>
			</select>
			<?php if(!empty($roleError)): ?>
				<span class="error"><?php echo $roleError; ?></span>
			<?php endif; ?>
		</p>
		<input type="hidden" name="id" value="<?php echo $_POST['id']; ?>">
		<input type="submit" name="action" value="Edit"> <a class="button" href="?Admin&Users">Cancel Edit</a>
	</form>
</div>
<?php foreach ($users as $user): ?>
	<?php if(!empty($user['name'])):?>
		<form class="Seperate" action="" method="post">
			<input type="hidden" name="id" value="<?php echo $user['id']; ?>">
			<?php echo "ID: ".$user['id']; ?>
			<input type="submit" name="showEdit" value="Edit">
			<label class="button pointer" for="<?php echo $user['id']; ?>">Delete</label>
			<input id="<?php echo $user['id']; ?>" type="checkbox" class="hide">
			<input type="submit" name="action" value="Confirm Delete">
			<br>
			Name: <?php htmlout($user['name']) ?> | Email: <?php htmlout($user['email']) ?> | Role: <?php echo $user['role'] ?>
		</form>
	<?php endif; ?>
<?php endforeach; ?>