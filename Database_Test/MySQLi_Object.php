<?php 
//setup connection
$mysqli = new mysqli("localhost","aidanche_forum","34djw*@ui4jf*","aidanche_forum");

//check connection
if ($mysqli->connect_errno) {
	//fail message
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}
//setup query
$result = $mysqli->query("CREATE TEMPORARY TABLE myCity LIKE City");
  
$result->use_result()) {
print_r($result);
$result->close();

//loop through query
/*foreach ($result as $value) {
	print_r($value);
	echo "<br>";
}*/

//close connection
mysqli_close($con);