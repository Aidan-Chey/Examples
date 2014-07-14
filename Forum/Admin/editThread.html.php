<?php 
include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/db.inc.php';

//Retrieve Thread from DB
try {
	$results = $pdo->query('SELECT ID, Title, Contents, CreatorID
		FROM Threads 
		Where ID = '.$_POST['id']);
} catch (PDOException $e){
	$error = 'Error retrieving thread from database.';
	include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/error.html.php';
	exit();
}
foreach ($results as $row) {
	$thread = array('id' => $row['ID'], 'title' => $row['Title'], 'creator' => $row['CreatorID'], 'content' => $row['Contents']); 
}

//Check thread belongs to editor
try {
	$results = $pdo->query('SELECT Email
	FROM Users 
	Where ID = "'.$thread['creator'].'"');
} catch (PDOException $e){
	$error = 'Error retrieving user from database.';
	include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/error.html.php';
	exit();
}
foreach ($results as $row) {
	$user = array('email' => $row['Email']); 
}
if($_SESSION['email'] != $user['email'] && !userHasRole('Admin')){
	$error = 'The thread you have attempted to edit, is not your own.';
	include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/error.html.php';
	exit();
}
?>
<h3>Edit Thread</h3>
<form action="" method="post">
	<p>
		<label for="title">Title: <br></label>
		<input name="title" id="title" autofocus value="<?php if(!empty($_POST['title'])){htmlout($_POST['title']) ;}else{htmlout($thread['title']);} ?>">
		<?php if(!empty($titelError)): ?>
			<span class="error"><?php echo $titelError; ?></span>
		<?php endif; ?>
	</p>
	<p>
		<label for="content">Content: <br></label>
		<textarea name="content" rows="1" style="height:1em;" id="content"><?php if(!empty($_POST['content'])){htmlout($_POST['content']);}else{htmlout($thread['content']);} ?></textarea>
		<?php if(!empty($contentError)): ?>
			<span class="error"><?php echo $contentError; ?></span>
		<?php endif; ?>
	</p>
	<input type="hidden" name="id" value="<?php echo $thread['id']; ?>">
	<input type="submit" name="action" value="Submit">
	<input type="submit" name="action" value="Cancel">
</form>