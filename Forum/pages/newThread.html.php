<?php 
if(isset($_POST["action"]) && $_POST["action"] == "createThread" && userIsLoggedIn()){
	//Validate Title
	if(empty($_POST['title'])){
		$titleError .= "Please enter a title.";
	}
	elseif(strlen($_POST['title']) > 50){
		$titleError .= "Please enter a shorter title (max 50 characters).";
	}

	//Validate Content
	if(empty($_POST['content'])){
		$contentError .= "Please enter content.";
	}
	elseif(strlen($_POST['content']) > 10000){
		$contentError .= "Please enter a shorter content (max 10,000)";
	}

	//Validate Topic
	if(empty($_POST['topic'])){
		$error .= "No topic was included, go back to the forums page and select the create thread button under the topic you wish to create a thread under.";
	}

	//If no errors
	if(empty($titleError) && empty($contentError) && empty($error)){
		//Connect to Database
		include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/db.inc.php';

		//Select User Information
		try {
			$Result = $pdo->query('SELECT Users.ID as uID
			FROM Users
			WHERE Users.Email = "'.$_SESSION['email'].'"
			LIMIT 1');
		} 
		catch (PDOException $e) {
			$error .= 'Error retrieving user information.';
			include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/error.html.php';
			exit();
		}
		foreach($Result as $row){
			$userInfo = array('id' => $row['uID']);
		}

		//Insert Information into DB
		try{
			$sql = 'INSERT INTO Threads SET Threads.Title = :title, 
			Threads.Contents = :content, 
			Threads.CreatorID = :user, 
			Threads.TopicID = :topic';
			$s = $pdo->prepare($sql);
			$s->bindValue(':title', $_POST['title']);
			$s->bindValue(':content', $_POST['content']);
			$s->bindValue(':topic', $_POST['topic']);
			$s->bindValue(':user', $userInfo['id']);
			$s->execute();
		}
		catch (PDOException $e){
			$error .= 'Error inserting submitted thread.';
			include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/error.html.php';
			exit();
		}
		session_start();
		header("Location: ".$_SESSION['previousPage']."&Messages=".urlencode(' Thread created!'));
		exit();
	}
}

 ?>
<h2>New Thread</h2>
<?php if(userIsLoggedIn()):
	if(!empty($error)): ?>
		<span class="error"><?php echo $error; ?></span>
	<?php endif; ?>
	<form action="" method="post">
		<p>
			<label for="title">Title: <br></label>
			<input name="title" id="title" autofocus value="<?php if(!empty($_POST['title'])) htmlout($_POST['title']); ?>">
			<?php if(!empty($titleError)): ?>
				<span class="error"><?php echo $titleError; ?></span>
			<?php endif; ?>
		</p>
		<p>
			<label for="content">Content: <br></label>
			<textarea name="content" rows="1" style="height:1em;" id="content"><?php if(!empty($_POST['content'])) htmlout($_POST['content']); ?></textarea>
			<?php if(!empty($contentError)): ?>
				<span class="error"><?php echo $contentError; ?></span>
			<?php endif; ?>
		</p>
		<input type="hidden" name="topic" value="<?php htmlout($_GET['Topic']); ?>">
		<input type="hidden" name="action" value="createThread">
		<button>Submit</button>
	</form>
<?php else: ?>
	<p>You need to be logged in to do this!</p>
<?php endif; ?>