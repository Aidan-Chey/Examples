<?php 
include $_SERVER['DOCUMENT_ROOT'].'/includes/db.inc.php';

/****Retrieve Thread from DB*****/
try {
	$results = $pdo->query('SELECT ID, Title, Contents, CreatorID
		FROM Threads 
		Where ID = '.$_POST['id']);
} catch (PDOException $e){
	$error = 'Error retrieving thread from database.';
	include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
	exit();
}
foreach ($results as $row) {
	$thread = array('id' => $row['ID'], 'title' => $row['Title'], 'creator' => $row['CreatorID'], 'content' => $row['Contents']); 
}

/****Check thread belongs to editor****/
try {
	$results = $pdo->query('SELECT Email
	FROM Users 
	Where ID = "'.$thread['creator'].'"');
} catch (PDOException $e){
	$error = 'Error retrieving user from database.';
	include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
	exit();
}
foreach ($results as $row) {
	$user = array('email' => $row['Email']); 
}
if($_SESSION['email'] != $user['email'] && !userHasRole('Admin')){
	$error = 'The thread you have attempted to edit, is not your own.';
	include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
	exit();
}


if(isset($_POST['action'])){
	
	if($_POST['action'] == 'Submit'){
		/****Validate Title******/
		if(empty($_POST['title'])){
			$titelError .= "Please enter a title.";
		}
		elseif(strlen($_POST['title']) > 50){
			$titelError .= "Please enter a shorter name (max 50 characters).";
		}
		elseif($_POST['title'] != $thread['title']){
			try {
				$results = $pdo->query('SELECT count(*) FROM Threads Where Title = "'.$_POST["title"].'"');
			} catch (PDOException $e){
				$error = 'Error retrieving thread title from database.';
				include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
				exit();
			}
			$row = $results->fetch();
			if ($row[0] > 0){
				$titelError .= "Name already taken.";
			}
		}
		/****Validate Content******/
		if(empty($_POST['content'])){
			$contentError .= "Please enter content.";
		}
		elseif(strlen($_POST['content']) > 10000){
			$contentError .= "Please enter a shorter content (max 10000 characters).";
		}

		/****If no errors******/
		if(empty($titelError) && empty($contentError)){
			try{
				$sql = 'UPDATE Threads 
					SET Title = :title, Contents = :content 
					WHERE ID = '.$thread['id'];
				$s = $pdo->prepare($sql);
				$s->bindValue(':title', $_POST['title']);
				$s->bindValue(':content', $_POST['content']);
				$s->execute();
			}
			catch (PDOException $e){
				$error = 'Error editing thread.';
				include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
				exit();
			}
			session_start();
			header("Location: ".$_SESSION['previousPage']."&Messages=".urlencode(' Thread edited!'));
			exit();
		}
	}
	elseif($_POST['action'] == 'Confirm Delete'){
		try{
			$postDelete = $pdo->query('DELETE FROM Posts WHERE ThreadID ='.$thread['id']);
		}
		catch (PDOException $e){
			$error = 'Error deleting posts asociated with thread from database.';
			include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
			exit();
		}
		try {
			$threadDelete = $pdo->query('DELETE FROM Threads WHERE ID ='.$thread['id']);
		}
		catch (PDOException $e){
			$error = 'Error deleting thread.';
			include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
			exit();
		}
		header("Location: /?Forums&Messages=".urlencode(' Thread deleted!'));
		exit();
	}
	elseif($_POST['action'] == 'Cancel'){
		header("Location: /?Thread=".$thread['id']);
		exit();
	}
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