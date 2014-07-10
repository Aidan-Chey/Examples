<!DOCTYPE html>
<html>
<head>
	<title>Error</title>
	<meta name="author" content="Aidan Dunn">
	<link rel="stylesheet" type="text/css" href="css/css.css"/>
</head>
<body>
	<h3>Looks like you bypassed the form's validation...</h3>
	<hr>
	<p><?php echo $error; ?></p>
	<hr>
	<form action="">
		<input type="button" value="BACK" onclick="history.back(-1)" />
	</form>
</body>
</html>