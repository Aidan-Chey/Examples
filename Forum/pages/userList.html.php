<?php 
session_start();
$_SESSION['previousPage'] = $_SERVER['REQUEST_URI']; ?>

<h3>User List</h3>
<div class="page_wrap flex_wrap Seperate">
<?php 
//Retrive user list
try{
	$result = $pdo->query('SELECT Name FROM Users');
}
catch (PDOException $e){
	$error = 'Error fetching users from the database!';
	include '/Forum/includes/error.html.php';
	exit();
}
foreach ($result as $row){
	$users[] = $row['Name'];
} 

for($i=0; $i < count($users); $i++){
	if($users[$i] != "[Removed]"){
		echo "<div>".$users[$i]."</div>";
	}
} ?>
</div>