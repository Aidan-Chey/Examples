<?php
/****addons to assist with injection******/
include $_SERVER['DOCUMENT_ROOT'].'/includes/magicQuotes.inc.php';
include $_SERVER['DOCUMENT_ROOT'].'/includes/helpers.inc.php';

/****functions for access and logging in****/
require_once $_SERVER['DOCUMENT_ROOT'].'/includes/access.inc.php';

/****Top section of master page******/
include $_SERVER['DOCUMENT_ROOT'].'/includes/head.html.php';

/****Conditional page contents******/
if(isset($_GET["Logout"]) && userIsLoggedIn()){
	echo "Hi 1<br>";
	include 'logout.php';
}
elseif(isset($_GET["Login"]) && !userIsLoggedIn()){
	include 'login.php';
}
elseif(isset($_GET["Register"]) && !userIsLoggedIn()){
	include 'registration.html.php';
}
elseif(isset($_GET["Forgot"])){
	include 'forgot.html.php';
}
else{
	header("Location: /?Activity");
}

/****Bottom section of master page******/
include $_SERVER['DOCUMENT_ROOT'].'/includes/foot.html.php';