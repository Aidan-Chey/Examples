<?php 
include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/db.inc.php';

//Retrieve Post from DB*
try {
	$results = $pdo->query('SELECT ID, Contents, ThreadID, CreatorID
		FROM Posts 
		Where ID = "'.$_POST['id'].'"');
} catch (PDOException $e){
	$error = 'Error retrieving post from database.';
	include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/error.html.php';
	exit();
}
foreach ($results as $row) {
	$post = array('id' => $row['ID'], 'content' => $row['Contents'], 'tId' => $row['ThreadID'], 'creator' => $row['CreatorID']); 
}

//Check post belongs to editor
try {
	$results = $pdo->query('SELECT Email
	FROM Users 
	Where ID = "'.$post['creator'].'"');
} catch (PDOException $e){
	$error = 'Error retrieving user from database.';
	include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/error.html.php';
	exit();
}
foreach ($results as $row) {
	$user = array('email' => $row['Email']); 
}
if($_SESSION['email'] != $user['email'] && !userHasRole('Admin')){
	$error = 'The post you have attempted to edit, is not your own.';
	include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/error.html.php';
	exit();
}
?>
<h3>Edit Post</h3>
<form action="" method="post">
	<p>
		<label for="content">Content: <br></label>
		<textarea name="content" rows="1" style="height:1em;" id="content" autofocus><?php if(!empty($_POST['content'])){htmlout($_POST['content']) ;}else{htmlout($post['content']);} ?></textarea>
		<?php if(!empty($contentError)): ?>
			<span class="error"><?php echo $contentError; ?></span>
		<?php endif; ?>
	</p>
	<input type="hidden" name="thread" value="<?php echo $post['tId']; ?>">
	<input type="hidden" name="id" value="<?php echo $post['id']; ?>">
	<input type="hidden" name="page" value="<?php htmlout($_POST['page']); ?>">
	<input type="submit" name="action" value="Submit">
	<input type="submit" name="action" value="Cancel">
</form>