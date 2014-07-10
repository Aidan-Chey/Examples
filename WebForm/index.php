<?php
include 'helpers.php';

if(isset($_POST["submit"])){

	$to = $_POST['email'];
	$reply = "webform@examples.aidancheyd.info";
	$name = strip_tags($_POST['Name']);
	$address = strip_tags($_POST['Address']);
	$email = strip_tags($_POST['Email']);
	$phone = strip_tags($_POST['Phone']);

	$birthdate = strip_tags($_POST['Birthdate']);
	list($year, $month, $day) = explode('-', $birthdate);

	$movie = strip_tags($_POST['Movie']);
	$gender = strip_tags($_POST['Gender']);

	$error = "Some fields were incorrect:";

	if(strlen($name) == 0){
		$error .= "<br>- The Name field was required";
	}
	elseif(strlen($name) > 40){
		$error .= "<br>- The Name field was too long (max 40 characters).";
	}

	if(strlen($address) == 0){
		$error .= "<br>- The Address field was required";
	}
	elseif(strlen($address) > 200){
		$error .= "<br>- The Address field was too long (max 200 characters).";
	}

	if(strlen($email) == 0){
		$error .= "<br>- The Email field was required";
	}
	elseif(strlen($email) > 100){
		$error .= "<br>- The Email field was too long (max 100 characters).";
	}

	if(strlen($phone) == 0){
		$error .= "<br>- The Phone field was required";
	}
	elseif(strlen($phone) > 14){
		$error .= "<br>- The Phone field was too long (max 14 characters).";
	}

	if(strlen($birthdate) == 0){
		$error .= "<br>- The Birthdate field was required";
	}
	elseif(!checkdate($month, $day, $year)){
		$error .= "<br>- The Birthdate was invalid: ".$birthdate;
	}

	if(strlen($movie) == 0){
		$error .= "<br>- The Movie field was required";
	}
	if(strlen($gender) == 0){
		$error .= "<br>- The Gender field was required";
	}
	if($error != "Some fields were incorrect:"){
		include "error.html.php";
		exit();
	}

	$header = "From: webform@examples.aidancheyd.info" .
	"X-Mailer:PHP/" . phpversion() . "\r\n" .
	"Return-Path: $reply" . "\r\n" .
	"Reply-To: $reply";
	$subject = "Aidan's Web Form Submission";
	$message = wordwrap("Name: " . $name 
	. "\r\n" . "Address: " . $address 
	. "\r\n" . "Email: " . $email 
	. "\r\n" . "Phone: " . $phone 
	. "\r\n" . "Birthdate: " . $birthdate 
	. "\r\n" . "Favorite Movie: " . $movie 
	. "\r\n" . "Gender: " . $gender, 70);

	/*if(mail($to, $subject, $message, $header, "-f$reply")){
		$_SESSION['messages'] = "Mail sent.";
	}
	else{
		$_SESSION['messages'] = "Mail not sent; mail has been disabled.";
	}*/
	$_SESSION['messages'] = "Mail not sent; mail has been disabled.";
}

include 'site.html.php';