<?php include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/db.inc.php';

$_SESSION['previousPage'] = $_SERVER['REQUEST_URI'];

//Retrive user list
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

//Retrieve Role list
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
		<input type="submit" name="action" value="Edit"> <a class="button" href="/Forum/Admin/?Users">Cancel Edit</a>
	</form>
</div>
<?php foreach ($users as $user): ?>
	<?php if(!empty($user['name'])):?>
		<form class="Seperate" method="post">
			<input type="hidden" name="id" value="<?php echo $user['id']; ?>">
			<?php echo "ID: ".$user['id']; ?>
			<input type="submit" name="showEdit" value="Edit">
			<label class="button pointer" for="<?php echo $user['id']; ?>">Delete</label>
			<input id="<?php echo $user['id']; ?>" type="checkbox" class="hide">
			<button name="action" value="Delete">Confirm Delete</button>
			<br>
			Name: <?php htmlout($user['name']) ?> | Email: <?php htmlout($user['email']) ?> | Role: <?php echo $user['role'] ?>
		</form>
	<?php endif; ?>
<?php endforeach; ?>