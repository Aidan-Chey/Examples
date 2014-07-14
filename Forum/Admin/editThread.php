<?php
if($_POST['action'] == 'Submit'){
	//Validate Title
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
			include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/error.html.php';
			exit();
		}
		$row = $results->fetch();
		if ($row[0] > 0){
			$titelError .= "Name already taken.";
		}
	}
	//Validate Content
	if(empty($_POST['content'])){
		$contentError .= "Please enter content.";
	}
	elseif(strlen($_POST['content']) > 10000){
		$contentError .= "Please enter a shorter content (max 10000 characters).";
	}

	//If no errors
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
			include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/error.html.php';
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
		include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/error.html.php';
		exit();
	}
	try {
		$threadDelete = $pdo->query('DELETE FROM Threads WHERE ID ='.$thread['id']);
	}
	catch (PDOException $e){
		$error = 'Error deleting thread.';
		include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/error.html.php';
		exit();
	}
	header("Location: /Forum/Admin/?Thread&Messages=".urlencode(' Thread deleted!'));
	exit();
}
elseif($_POST['action'] == 'Cancel'){
	header("Location: /Forum/Admin/?Thread=".$thread['id']);
	exit();
}