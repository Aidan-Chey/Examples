<?php 
//setup connect
$mysqli = mysqli_connect("localhost","aidanche_forum","34djw*@ui4jf*","aidanche_forum");

//check connection
if (mysqli_connect_errno()) {
	//fail message
	echo "Connect failed: %s\n", mysqli_connect_error();
	exit();
}
//setup query
$result = mysqli_query($mysqli, "SELECT * FROM UsersRole");

//loop through query
while($row = mysqli_fetch_array($result)) {
	print_r($row);
	echo "<br>";
}

//close connection
mysqli_close($mysqli);