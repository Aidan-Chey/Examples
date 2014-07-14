<?php
if($_POST['action'] == 'Edit'){
	//Validate Name
	if(empty($_POST['name'])){
		$nameError .= "Please enter a section name.";
	}
	elseif(strlen($_POST['name']) > 50){
		$nameError .= "Please enter a shorter name (max 50 characters).";
	}
	elseif($_POST['name'] != $editSection['name']){
		foreach($sections as $section){
			if($_POST['name'] == $section['name']){
				$nameError .= "Name already taken.";
			}
		}
	}
	//Validate Description
	if(empty($_POST['description'])){
		$descriptionError .= "Please enter a section description.";
	}
	elseif(strlen($_POST['description']) > 150){
		$descriptionError .= "Please enter a shorter description (max 150 characters).";
	}

	//If no errors
	if(empty($nameError) && empty($descriptionError)){
		//Update Information in DB
		try{
			$sql = 'UPDATE Sections 
				SET Name = :name, 
				Description = :description 
				WHERE ID = '.$_POST['id'];
			$s = $pdo->prepare($sql);
			$s->bindValue(':name', $_POST['name']);
			$s->bindValue(':description', $_POST['description']);
			$s->execute();
		}
		catch (PDOException $e){
			$error = 'Error editing section.';
			include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/error.html.php';
			exit();
		}
		$_SESSION['messages'] = " Section Edited!";
		header('Location: /Forum/Admin/?Sections');
		exit();
	}
	else{
		$edit="";
	}
}

elseif($_POST['action'] == 'Confirm Delete'){
	try{
		$result = $pdo->query('SELECT ID FROM Topics Where SectionID = '.$_POST['id']);
	}
	catch (PDOException $e){
		$error = 'Error retrieving Topic IDs.';
		include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/error.html.php';
		exit();
	}
	foreach ($result as $row) {
		$topic_ID[] = $row['ID'];
	}
	foreach($topic_ID as $key => $topicID){
		try{
			$result = $pdo->query('SELECT ID FROM Threads Where TopicID = '.$topicID);
		}
		catch (PDOException $e){
			$error = 'Error retrieving Thread IDs.';
			include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/error.html.php';
			exit();
		}
		foreach ($result as $row) {
			$thread_ID[] = $row['ID'];
		}
	}
	if(!empty($thread_ID)){
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
	}
	if(!empty($topic_ID)){
		foreach ($topic_ID as $key => $topicID) {
			try{
				$pdo->query('DELETE FROM Threads Where TopicID = '.$topicID);
			}
			catch (PDOException $e){
				$error = 'Error deleting Threads.';
				include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/error.html.php';
				exit();
			}
		}
	}
	try{
		$pdo->query('DELETE FROM Topics Where SectionID = '.$_POST['id']);
	}
	catch (PDOException $e){
		$error = 'Error deleting Topics.';
		include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/error.html.php';
		exit();
	}
	try{
		$pdo->query('DELETE FROM Sections Where ID = '.$_POST['id']);
	}
	catch (PDOException $e){
		$error = 'Error deleting Section.';
		include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/error.html.php';
		exit();
	}
	$_SESSION['messages'] = " Section Deleted!";
	header('Location: /Forum/Admin?Sections');
	exit();
}
elseif($_POST['action'] == 'Add'){
	//Validate Name
	if(empty($_POST['name'])){
		$nameError .= "Please enter a section name.";
	}
	elseif(strlen($_POST['name']) > 50){
		$nameError .= "Please enter a shorter name (max 50 characters).";
	}
	elseif($_POST['name'] != $editSection['name']){
		foreach($sections as $section){
			if($_POST['name'] == $section['name']){
				$nameError .= "Name already taken.";
			}
		}
	}
	//Validate Description
	if(empty($_POST['description'])){
		$descriptionError .= "Please enter a section description.";
	}
	elseif(strlen($_POST['description']) > 200){
		$descriptionError .= "Please enter a shorter description (max 50 characters).";
	}

	//If no errors
	if(empty($nameError) && empty($descriptionError)){
		//Update Information in DB
		try{
			$sql = 'INSERT INTO Sections 
				SET Name = :name, 
				Description = :description';
			$s = $pdo->prepare($sql);
			$s->bindValue(':name', $_POST['name']);
			$s->bindValue(':description', $_POST['description']);
			$s->execute();
		}
		catch (PDOException $e){
			$error = 'Error editing section.';
			include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/error.html.php';
			exit();
		}
		$_SESSION['messages'] = " Section Added!";
		header('Location: /Forum/Admin/?Sections');
		exit();
	}
}