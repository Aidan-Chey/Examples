<?php 
// Retrive section list
include $_SERVER['DOCUMENT_ROOT'].'/includes/db.inc.php';

try{
	$result = $pdo->query('SELECT ID, Name, Description FROM Sections');
}
catch (PDOException $e){
	$error = 'Error fetching sections from the database!';
	include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
	exit();
}
foreach ($result as $row){
	$sections[] = array('id' => $row['ID'], 'name' => $row['Name'], 'description' => $row['Description']);
}

foreach ($sections as $findSection) {
	if($findSection['id'] == $_POST['id']){
		$editSection = array('id' => $findSection['id'], 'name' => $findSection['name'], 'description' => $findSection['description']);
	}
}

if(isset($_POST['showEdit'])){$edit="";}

if(isset($_POST['action'])){

	if($_POST['action'] == 'Edit'){
		/****Validate Name******/
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
		/****Validate Description******/
		if(empty($_POST['description'])){
			$descriptionError .= "Please enter a section description.";
		}
		elseif(strlen($_POST['description']) > 150){
			$descriptionError .= "Please enter a shorter description (max 150 characters).";
		}

		/****If no errors******/
		if(empty($nameError) && empty($descriptionError)){
			/****Update Information in DB******/
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
				include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
				exit();
			}
			header('Location: /Admin?Sections&Messages='.urlencode(' Section Edited!'));
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
			include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
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
				include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
				exit();
			}
			foreach ($result as $row) {
				$thread_ID[] = $row['ID'];
			}
		}
		foreach ($thread_ID as $key => $threadID) {
			try{
				$pdo->query('DELETE FROM Posts Where ThreadID = '.$threadID);
			}
			catch (PDOException $e){
				$error = 'Error deleting Posts.';
				include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
				exit();
			}
		}
		foreach ($topic_ID as $key => $topicID) {
			try{
				$pdo->query('DELETE FROM Threads Where TopicID = '.$topicID);
			}
			catch (PDOException $e){
				$error = 'Error deleting Threads.';
				include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
				exit();
			}
		}
		try{
			$pdo->query('DELETE FROM Topics Where SectionID = '.$_POST['id']);
		}
		catch (PDOException $e){
			$error = 'Error deleting Topics.';
			include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
			exit();
		}
		try{
			$pdo->query('DELETE FROM Sections Where ID = '.$_POST['id']);
		}
		catch (PDOException $e){
			$error = 'Error deleting Section.';
			include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
			exit();
		}
		header('Location: /Admin?Sections&Messages='.urlencode(' Section Deleted!'));
		exit();
	}

	elseif($_POST['action'] == 'Add'){
		/****Validate Name******/
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
		/****Validate Description******/
		if(empty($_POST['description'])){
			$descriptionError .= "Please enter a section description.";
		}
		elseif(strlen($_POST['description']) > 200){
			$descriptionError .= "Please enter a shorter description (max 50 characters).";
		}

		/****If no errors******/
		if(empty($nameError) && empty($descriptionError)){
			/****Update Information in DB******/
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
				include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
				exit();
			}
			header('Location: /Admin?Sections&Messages='.urlencode(' Section Added!'));
			exit();
		}
	}
}
?>

<h3>Sections</h3>
<div class="Seperate">
	<label for="newSection">
		<span class="pointer" style="text-decoration: underline;"><?php if(isset($edit)){echo 'Edit section';}else{echo 'Add new section';} ?></span>
	</label>
	<input class="section_hide" type='checkbox' id="newSection" 
	<?php if(isset($edit)){echo 'Checked';}elseif($_POST['action'] == 'Add'){echo 'Checked';} ?>>
	<form action="" method="post">
		<p>
			<label for="Name">Name</label><br>
			<input id="Name" name="name" value="<?php if(!empty($_POST['name'])){htmlout($_POST['name']);}
				elseif(isset($edit)){htmlout($editSection['name']);} ?>">
			<?php if(!empty($nameError)): ?>
				<span class="error"><?php echo $nameError; ?></span>
			<?php endif; ?>
		</p>
		<p>
			<label for="content">Description</label><br>
			<textarea id="content" rows="1" style="height:1em;" name="description"><?php if(!empty($_POST['description'])){htmlout($_POST['description']);}elseif(isset($edit)){htmlout($editSection['description']);} ?></textarea>
			<?php if(!empty($descriptionError)): ?>
				<span class="error"><?php echo $descriptionError; ?></span>
			<?php endif; ?>
		</p>
		<input type="hidden" name="id" value="<?php echo $_POST['id']; ?>">
		<input type="submit" name="action" value="<?php if(isset($edit)){echo 'Edit';}else{echo 'Add';} ?>">
		<?php if(isset($edit)){echo ' <a class="button" href="/Admin/?Sections">Cancel Edit</a>';} ?>
	</form>
</div>
<?php foreach ($sections as $section): ?>
	<form class="Seperate" action="" method="post">
		<input type="hidden" name="id" value="<?php echo $section['id']; ?>">
		<?php echo "ID: ".$section['id']; ?>

		<input type="submit" name="showEdit" value="Edit">

		<label class="button pointer" for="<?php echo $section['id']; ?>">Delete</label>
		<input id="<?php echo $section['id']; ?>" type="checkbox" class="hide">
		<input type="submit" name="action" value="Confirm Delete">
		<br>
		<?php htmlout("Name: ".$section['name']) ?><br>
		<?php htmlout("Description: ".$section['description']) ?>
	</form>
<?php endforeach; ?>