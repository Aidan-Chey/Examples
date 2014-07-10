<?php 
session_start();
$_SESSION['previousPage'] = $_SERVER['REQUEST_URI'];

/****Connect to Database******/
include $_SERVER['DOCUMENT_ROOT'].'/includes/db.inc.php';

/****Retrieve most recent Threads******/
try{
	$result = $pdo->query('SELECT Threads.ID as tID, Threads.Title as tTitle, Threads.Contents as tContents, Threads.Created as tCreated, Users.Name as uName
		FROM Threads
		INNER JOIN Users ON Threads.CreatorID = Users.ID
		ORDER BY Threads.Created
		LIMIT 5');
}
catch (PDOException $e){
	$error = 'Error retrieving Threads.';
	include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
	exit();
}
foreach ($result as $row) {
	$threads[] = array('id' => $row['tID'],
		'title' => $row['tTitle'], 
		'contents' => $row['tContents'], 
		'date' => $row['tCreated'], 
		'user' => $row['uName']);
}
?>

<h2>Recent Activity</h2>

<?php foreach($threads as $thread): 
	if(!empty($thread['title'])): ?>
		<div class="Seperate">
			<header><a href="?Thread=<?php echo $thread['id'] ?>"><?php htmlout($thread['title']); ?></a></header>
			<section><?php htmlout($thread['contents']); ?></section>
			<footer>
				Created: <?php echo $thread['date']; ?> | By: <?php htmlout($thread['user']); ?>
			</footer>
		</div>
<?php endif;
endforeach; ?>