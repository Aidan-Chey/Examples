<?php 
/****addons to assist with injection******/
include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/magicQuotes.inc.php';
include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/helpers.inc.php';

/****functions for access and logging in****/
require_once $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/access.inc.php';

/****Top section of master page******/
include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/head.html.php';

if(isset($_GET["Thread"]) && userIsLoggedIn()){
	include 'editThread.html.php';
}
elseif(isset($_GET["Post"]) && userIsLoggedIn()){
	include 'editPost.html.php';
}
elseif(isset($_GET["Users"]) && userHasRole('Admin')){
	include 'users.html.php';
}
elseif(isset($_GET["Sections"]) && userHasRole('Admin')){
	include 'sections.html.php';
}
elseif(isset($_GET["Topics"]) && userHasRole('Admin')){
	include 'topics.html.php';
}
elseif(userHasRole('Admin')){
	include 'categories.html';
}
else{
	echo "<h3>Access denied, insufficient permissions.</h3>";
}

/****Bottom section of master page******/
include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/foot.html.php';