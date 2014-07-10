<?php 
session_start();
$_SESSION['previousPage'] = $_SERVER['REQUEST_URI'];

/****Connect to Database******/
	include 'includes/db.inc.php';

	/****Retrieve Threads under Topic******/
	try{
		$result = $pdo->query('SELECT Threads.ID as tID, Threads.Title as tTitle, SUBSTRING(Threads.Contents,1, 100) as tContent, Threads.Created as tCreated, Users.Name as uName
		FROM Threads
		INNER JOIN Users ON Threads.CreatorID = Users.ID
		INNER JOIN Topics ON Threads.TopicID = Topics.ID 
		WHERE Topics.ID = '.$_GET['Topic'].' 
		ORDER BY Threads.Created');
	}
	catch (PDOException $e){
		$error = 'Error retrieving Threads.';
		include 'includes/error.html.php';
		exit();
	}
	foreach ($result as $row) {
		$threads[] = array('id' => $row['tID'],
			'title' => $row['tTitle'], 
			'content' => $row['tContent'], 
			'date' => $row['tCreated'], 
			'user' => $row['uName']);
	}

	try{
		$result = $pdo->query('SELECT Topics.Name as tName
		FROM Topics
		WHERE Topics.ID = '.$_GET['Topic']);
	}
	catch (PDOException $e){
		$error = 'Error retrieving Topic.';
		include 'includes/error.html.php';
		exit();
	}
	foreach ($result as $row) {
		$topics = array('name' => $row['tName']);
	}
 ?>
<h2><?php htmlout($topics['name']); ?></h2>
 
<?php if(userIsLoggedIn()) include $_SERVER['DOCUMENT_ROOT'].'/includes/button_newThread.inc.php';

foreach ($threads as $thread): ?>
<div class="Seperate thread">
	<header><a href="?Thread=<?php echo $thread['id']; ?>">&deg;<?php htmlout($thread['title']); ?></a></header>
	<section><?php htmlout($thread['content']); echo " ..."; ?></section>
	<footer>
		Created:<?php echo $thread['date']; ?> | By: <?php htmlout($thread['user']); ?>
	</footer>
</div>
<?php endforeach;
if(userIsLoggedIn()) include $_SERVER['DOCUMENT_ROOT'].'/includes/button_newThread.inc.php'; ?>