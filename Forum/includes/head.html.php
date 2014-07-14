<?php
//Connect to Database
	include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/db.inc.php';

//When Logging in
session_start();
if(isset($_POST['login'])){
	include $_SERVER['DOCUMENT_ROOT'].'/Forum/Authentication/login.php';
}

//When Logging out
if(isset($_POST['logout'])){
	include $_SERVER['DOCUMENT_ROOT'].'/Forum/Authentication/logout.php';
}

if(userIsLoggedIn()){
	try{
		$result = $pdo->query('SELECT Name FROM Users WHERE Email = "'.$_SESSION['email'].'" Limit 1');
	}
	catch (PDOException $e){
		$error = 'Error fetching user name from the database!';
		include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/error.html.php';
		exit();
	}
	foreach ($result as $row){
		$userName = $row['Name'];
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Php Forum</title>
	<meta name="Author" content="Aidan Dunn">
	<meta name="Description" content="Php Forum built for Assessment 2">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="/Forum/css/normalize.css"/>
	<link rel="stylesheet" type="text/css" href="/Forum/css/base.css"/>
</head>
<body onload="init();">
	<h1>Forum</h1>
	<?php if(userIsLoggedIn()): ?>
		<span>Welcome  <?php if(userHasRole('Admin')){echo "<span title='You have Administrator Privileges' class='error'>Admin</span> ";}
			htmlout($userName);?>
		</span>
		<label class="button" for="logout">Logout</label>
		<input type="checkbox" class="logout_hide" id="logout">
		<form method="post">
			<input type="submit" name="logout" value="Confirm logout">
		</form>
	<?php else: ?>
		<span>Not logged in!</span>
		<label class="button" for="login">Login</label>
		<input type="checkbox" class="login_hide" id="login" <?php if(!empty($reTry)) echo "checked"; ?>>
		<div id="login_form">
			<?php if(userIsLoggedIn()): ?>
				<p>You are already logged in!</p>
			<?php else: ?>
				Don't have an account? <a class="button" href="/Forum/Authentication/?Register">Register?</a>
				<form action="" method="post">
					<p>
						<label for="email">Email: </label><br>
						<input autofocus type="email" name="email" id="email" maxlength="100" value="<?php if(!empty($_POST["email"])) htmlout($_POST["email"]); ?>" required>
						<?php if(!empty($emailError)) echo "<br><span class='error'>$emailError</span>"; ?><br>
					</p>
					<p>
						<label for="password">Password: </label><br>
						<input type="password" name="password" id="password" maxlength="120" required>
						<?php if(!empty($passError)) echo "<br><span class='error'>$passError</span>"; ?><br>
					</p>
					<?php if (!empty($loginError)) echo "<span class='error'>$loginError</span><br>"; ?>
					<input type="hidden" name="login">
					<input type="checkbox" name="remember" id="remember" <?php if(isset($_POST['remember'])) echo "checked"; ?>>
					<label for="remember">Remember Login?</label>
					<br>
					<button>Login</button>
					<a class="button" href="/Forum/Authentication/?Forgot">Forgot Password?</a>
					<br>
					<?php echo "Attempts Remaining: ".(5 - $_COOKIE['logCount']); ?>
				</form>
			<?php endif; ?>
		</div>
		<label for="login" id="overlay"></label>
	<?php endif; ?>
	<nav>
		<a href="/Forum/?Activity">Activity</a>
		<a href="/Forum/?Forums">Forums</a>
		<?php if(userIsLoggedIn()) echo "<a href='/Forum/?Users'>User List</a>" ?>
		<span>
			Messages:<span class="error">
				<?php if(!empty($_SESSION['messages'])) htmlout($_SESSION['messages']); ?>
			</span>
		</span>
	</nav>
	<div id="body" >