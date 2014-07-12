<?php
/****addons to assist with injection******/
include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/magicQuotes.inc.php';
include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/helpers.inc.php';

/****functions for access and logging in****/
require_once $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/access.inc.php';

/****Conditional page contents******/
if(isset($_GET["Logout"]) && userIsLoggedIn()){
	include 'logout.php';
}
elseif(isset($_GET["Login"]) && !userIsLoggedIn()){
	include 'login.php';
}
elseif(isset($_GET["Register"]) && !userIsLoggedIn()){
	/****Top section of master page******/
	include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/head.html.php';
	include 'registration.html.php';
}
elseif(isset($_GET["Forgot"])){
	/****Top section of master page******/
	include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/head.html.php';
	include 'forgot.html.php';
}
else{
	header("Location: /?Activity");
}

/****Bottom section of master page******/
include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/foot.html.php';