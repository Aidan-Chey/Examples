<?php
if($_POST['action'] == 'Submit'){
	//Validate Content
	if(empty($_POST['content'])){
		$contentError .= "Please enter content.";
	}
	elseif($_POST['content'] == $post['content']){
		$contentError .= "No change was made.";
	}
	elseif(strlen($_POST['content']) > 10000){
		$contentError .= "Please enter a shorter content (max 10000 characters).";
	}

	//If no errors
	if(empty($contentError)){
		try{
			$sql = 'UPDATE Posts SET Contents = :content WHERE ID = :id';
			$s = $pdo->prepare($sql);
			$s->bindValue(':content', $_POST['content']);
			$s->bindValue(':id', $post['id']);
			$s->execute();
		}
		catch (PDOException $e){
			$error = 'Error editing post.';
			include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/error.html.php';
			exit();
		}
		$_SESSION['message'] = " Post edited!";
		header("Location: ".$_SESSION['previousPage']);
		exit();
	}
	elseif($_POST['action'] == 'Confirm Delete'){
		try {
			$pdo->query("DELETE FROM Posts WHERE ID = '".$post['id']."'");
		}
		catch (PDOException $e){
			$error = 'Error deleting thread.';
			include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/error.html.php';
			exit();
		}
		$_SESSION['message'] = " Post deleted!";
		header("Location: ".$_SESSION['previousPage']);
		exit();
	}
	elseif($_POST['action'] == 'Cancel'){
		header("Location: ".$_SESSION['previousPage']);
		exit();
	}
}