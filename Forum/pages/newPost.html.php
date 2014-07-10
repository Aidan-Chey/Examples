<?php 
if(!empty($_POST["action"]) && $_POST["action"] == "createPost" && userIsLoggedIn()){
/****Validate Content******/
	if(empty($_POST['content'])){
		$contentError .= "Please enter content.";
	}
	elseif(strlen($_POST['content']) > 10000){
		$contentError .= "Please enter a shorter content (max 10,000)";
	}

	/****Validate Thread******/
	if(empty($_POST['thread'])){
		$error .= "No thread was included, go back to the thread page and select the create post button.";
	}

	/****If no errors******/
	if(empty($contentError) && empty($error)){
		/****Connect to Database******/
		include $_SERVER['DOCUMENT_ROOT'].'/includes/db.inc.php';

		/****Select User Information******/
		try {
			$Result = $pdo->query('SELECT Users.ID as uID
			FROM Users
			WHERE Users.Email = "'.$_SESSION['email'].'"
			LIMIT 1');
		} 
		catch (PDOException $e) {
			$error .= 'Error retrieving user information.';
			include $_SERVER['DOCUMENT_ROOT'].'includes/error.html.php';
			exit();
		}
		foreach($Result as $row){
			$userInfo = array('id' => $row['uID']);
		}

		/****Insert Information into DB******/
		try{
			$sql = 'INSERT INTO Posts 
			SET Posts.Contents = :content, 
			Posts.CreatorID = :user, 
			Posts.ThreadID = :thread';
			$s = $pdo->prepare($sql);
			$s->bindValue(':content', $_POST['content']);
			$s->bindValue(':thread', $_POST['thread']);
			$s->bindValue(':user', $userInfo['id']);
			$s->execute();
		}
		catch (PDOException $e){
			$error .= 'Error inserting submitted post.';
			include $_SERVER['DOCUMENT_ROOT'].'includes/error.html/php';
			exit();
		}
		session_start();
		header("Location: ".$_SESSION['previousPage']."&Messages=".urlencode(' Post created!'));
		exit();
	}
}
 ?>
<h2>New Post</h2>
<?php if(userIsLoggedIn()):
	if(!empty($error)): ?>
		<span class="error"><?php echo $error; ?></span>
	<?php endif; ?>
	<form action="" method="post">
		<p>
			<label for="content">Content: <br></label>
			<textarea name="content" rows="1" style="height:1em;" id="content"><?php if(!empty($_POST['content'])) htmlout($_POST['content']); ?></textarea>
			<?php if(!empty($contentError)): ?>
				<span class="error"><?php echo $contentError; ?></span>
			<?php endif; ?>
		</p>
		<input type="hidden" name="thread" value="<?php htmlout($_GET['Thread']); ?>">
		<input type="hidden" name="action" value="createPost">
		<button>Submit</button>
	</form>
<?php else: ?>
	<p>You need to be logged in to do this!</p>
<?php endif; ?>