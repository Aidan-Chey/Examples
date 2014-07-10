<?php 
$movies = array("Frozen", "The Wolf of Wall Street", "American Hustle", "12 Years a Slave", "Thor: The Dark World");
$genders = array("Unspecified", "Male", "Female")
?>
<!DOCTYPE html>
<html>
<head>
	<title>Assessment 1 - Web Form</title>
	<meta name="author" content="Aidan Dunn">
	<link rel="stylesheet" type="text/css" href="css/css.css"/>
</head>
<body>
<div class="center">
	<h1>Web Form</h1>
	<?php if(!empty($_SESSION['messages'])){echo "<p class='error'>".$_SESSION['messages']."</p>";} ?>
	<?php 
		if(isset($_POST["submit"])){
			include 'submitted.html';
			exit();
		}
		include 'form.html.php';
	?>
</div>
</body>
</html>