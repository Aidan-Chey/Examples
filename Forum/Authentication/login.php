<?php 
/****Login Attempts******/
if (isset($_POST['login'])){

	/****Login Count****/
	if(isset($_COOKIE['logCount']) && $_COOKIE['logCount'] > 4){
		header("Location: ".$_SESSION['previousPage']."&Messages=".urlencode('Too many login attempts, try agian another time!'));
		exit();
	}

	/*****Validate Email*****/
	if(empty($_POST['email'])){
		$emailError .= 'Please enter a email';
	}
	elseif(strlen($_POST['email']) > 100){
		$emailError .= 'Please enter a shorter email (max 100 characters)';
	}
	elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
		$emailError .= 'Please enter a valid email';
	}

	/****Validate Password******/
	if(empty($_POST['password'])){
		$passError .= 'Please enter a password';
	}
	if(strlen($_POST['password']) > 100){
		$passError .= 'Please enter a shorter password (max 100 characters)';
	}

	/****Run if no errors******/
	if(empty($emailError) && empty($passError) && empty($loginError)){

		/****Check _POSTed info agianst database******/
		$password = md5($_POST['password'] . 'f0rum');
		if (databaseContainsUser($_POST['email'], $password)){
			if(isset($_POST['remember'])) {
				ini_set('session.cookie_lifetime', 60 * 60 * 24 * 7);
			}
			$_SESSION['loggedIn'] = TRUE;
			$_SESSION['email'] = $_POST['email'];
			$_SESSION['password'] = $password;
			setcookie('logCount', "", time() -3600);
			$messages .= 'Now logged in!';
		}
		/****If not in Database, +1 login count, unset $_session and error******/
		else{
			if(!isset($_COOKIE['logCount'])){
				$_COOKIE['logCount'] = 1;
			}
			else{
				$_COOKIE['logCount'] ++;
			}
			setcookie('logCount', $_COOKIE['logCount'], time() + 3600);
			unset($_SESSION['loggedIn']);
			unset($_SESSION['email']);
			unset($_SESSION['password']);
			$loginError .= 'The specified email address or password was incorrect.';
		}
	}
	$reTry = "yes";
}