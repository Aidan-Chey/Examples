<?php
if($_POST['action'] == 'Edit'){
	//Validate Name
	if(empty($_POST['name'])){
		$nameError .= "Please enter a topic name.";
	}
	elseif(strlen($_POST['name']) > 50){
		$nameError .= "Please enter a shorter name (max 50 characters).";
	}
	elseif($_POST['name'] != $editTopic['name']){
		foreach($topics as $topic){
			if($_POST['name'] == $topic['name']){
				$nameError .= "Name already taken.";
			}
		}
	}
	//Validate Section
	if(empty($_POST['section'])){
		$sectionError .= "Please select a section";
	}
	elseif(in_array($_POST['section'], $topics)){
		$sectionError .= "Selected section not found";
	}

	//Validate Description
	if(empty($_POST['description'])){
		$descriptionError .= "Please enter a topic description.";
	}
	elseif(strlen($_POST['description']) > 150){
		$descriptionError .= "Please enter a shorter description (max 150 characters).";
	}

	//If no errors
	if(empty($nameError) && empty($sectionError) && empty($descriptionError)){
		//Update Information in DB
		try{
			$sql = 'UPDATE Topics 
				SET Name = :name, Description = :description, SectionID = :section 
				WHERE ID = '.$_POST['id'];
			$s = $pdo->prepare($sql);
			$s->bindValue(':name', $_POST['name']);
			$s->bindValue(':section', $_POST['section']);
			$s->bindValue(':description', $_POST['description']);
			$s->execute();
		}
		catch (PDOException $e){
			$error = 'Error editing topic.';
			include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/error.html.php';
			exit();
		}
		$_SESSION['messages'] = " Topic Edited!";
		header('Location: /Forum/Admin/?Topics');
		exit();
	}
	else{
		$edit="";
	}
}

elseif($_POST['action'] == 'Confirm Delete'){
	try{
		$result = $pdo->query('SELECT ID FROM Threads Where TopicID = '.$_POST['id']);
	}
	catch (PDOException $e){
		$error = 'Error retrieving Thread IDs.';
		include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/error.html.php';
		exit();
	}
	foreach ($result as $row) {
		$thread_ID[] = $row['ID'];
	}
	foreach ($thread_ID as $key => $threadID) {
		try{
			$pdo->query('DELETE FROM Posts Where ThreadID = '.$threadID);
		}
		catch (PDOException $e){
			$error = 'Error deleting Posts.';
			include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/error.html.php';
			exit();
		}
	}
	try{
		$pdo->query('DELETE FROM Threads Where TopicID = '.$_POST['id']);
	}
	catch (PDOException $e){
		$error = 'Error deleting Threads.';
		include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/error.html.php';
		exit();
	}
	try{
		$pdo->query('DELETE FROM Topics Where ID = '.$_POST['id']);
	}
	catch (PDOException $e){
		$error = 'Error deleting topic.';
		include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/error.html.php';
		exit();
	}
	$_SESSION['messages'] = " Topic Deleted!";
	header('Location: /Forum/Admin/?Topics');
	exit();
}

elseif($_POST['action'] == 'Add'){
	//Validate Name
	if(empty($_POST['name'])){
		$nameError .= "Please enter a topic name.";
	}
	elseif(strlen($_POST['name']) > 50){
		$nameError .= "Please enter a shorter name (max 50 characters).";
	}
	elseif($_POST['name'] != $editTopic['name']){
		foreach($topics as $topic){
			if($_POST['name'] == $topic['name']){
				$nameError .= "Name already taken.";
			}
		}
	}
	//Validate Section
	if(empty($_POST['section'])){
		$sectionError .= "Please select a section";
	}
	elseif(in_array($_POST['section'], $topics)){
		$sectionError .= "Selected section not found";
	}

	//Validate Description
	if(empty($_POST['description'])){
		$descriptionError .= "Please enter a topic description.";
	}
	elseif(strlen($_POST['description']) > 200){
		$descriptionError .= "Please enter a shorter description (max 50 characters).";
	}

	//If no errors
	if(empty($nameError) && empty($sectionError) && empty($descriptionError)){
		//Update Information in DB
		try{
			$sql = 'INSERT INTO Topics 
				SET Name = :name, Description = :description, SectionID = :section';
			$s = $pdo->prepare($sql);
			$s->bindValue(':name', $_POST['name']);
			$s->bindValue(':section', $_POST['section']);
			$s->bindValue(':description', $_POST['description']);
			$s->execute();
		}
		catch (PDOException $e){
			$error = 'Error adding topic.';
			include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/error.html.php';
			exit();
		}
		$_SESSION['messages'] = " Topic Added!";
		header('Location: /Forum/Admin/?Topics');
	}
}	