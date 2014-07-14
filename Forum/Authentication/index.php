<?php
//addons to assist with injection
include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/helpers.inc.php';

//functions for access and logging in
require_once $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/access.inc.php';

//Conditional page contents
if(isset($_GET["Logout"]) && userIsLoggedIn()){
	include 'logout.php';
}
elseif(isset($_GET["Login"]) && !userIsLoggedIn()){
	include 'login.php';
}
elseif(isset($_GET["Register"]) && isset($_POST['register']) && !userIsLoggedIn()){
	include 'registration.php';
}
elseif(isset($_GET["Forgot"]) && !empty($_POST['action'])){
	include 'forgot.php';
}
//Top section of master page
include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/head.html.php';

if(isset($_GET["Register"]) && !userIsLoggedIn()){
	include 'registration.html.php';
}
elseif(isset($_GET["Forgot"])){
	include 'forgot.html.php';
}
else{
	header("Location: /?Activity");
}

//Bottom section of master page
include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/foot.html.php';