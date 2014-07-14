<?php 
//Logout Attempts
if (isset($_POST['logout'])){
	unset($_SESSION['loggedIn']);
	unset($_SESSION['email']);
	unset($_SESSION['password']);
	$messages .= ' Now logged out!';
}
 ?>


