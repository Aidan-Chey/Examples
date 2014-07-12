<?php
$postsPerPage = 8;

/****addons to assist with injection******/
include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/magicQuotes.inc.php';
include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/helpers.inc.php';

/****functions for access and logging in****/
require_once $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/access.inc.php';

/****Top section of master page******/
include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/head.html.php';

/****Conditional page contents******/
if(isset($_GET["newThread"]) && (userIsLoggedIn())){
	include 'pages/newThread.html.php';
}
elseif(isset($_GET["newPost"]) && (userIsLoggedIn())){
	include 'pages/newPost.html.php';
}
elseif(!empty($_GET["Thread"]) && !empty($_GET["Page"])){
	include 'pages/posts.html.php';
}
elseif(!empty($_GET["Thread"])){
	include 'pages/thread.html.php';
}
elseif(!empty($_GET["Topic"])){
	include 'pages/topic.html.php';
}
elseif(isset($_GET["Forums"])){
	include 'pages/forums.html.php';
}
elseif(isset($_GET['Users'])){
	include 'pages/userList.html.php';
}
else{
	include 'pages/activity.html.php';
}

/****Bottom section of master page******/
include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/foot.html.php';