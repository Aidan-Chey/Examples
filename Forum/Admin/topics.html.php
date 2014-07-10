<?php 
include $_SERVER['DOCUMENT_ROOT'].'/includes/db.inc.php';

session_start();
$_SESSION['previousPage'] = $_SERVER['REQUEST_URI'];

// Retrive topic list
try{
	$result = $pdo->query('SELECT ID, Name, Description, SectionID FROM Topics');
}
catch (PDOException $e){
	$error = 'Error fetching topics from the database!';
	include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
	exit();
}
foreach ($result as $row){
	$topics[] = array('id' => $row['ID'], 'name' => $row['Name'], 'description' => $row['Description'], 'section' => $row['SectionID']);
}

foreach ($topics as $findTopic) {
	if($findTopic['id'] == $_POST['id']){
		$editTopic = array('id' => $findTopic['id'], 'name' => $findTopic['name'], 'description' => $findTopic['description']);
	}
}
// Retrive Section List
try{
	$result = $pdo->query('SELECT ID, Name FROM Sections');
}
catch (PDOException $e){
	$error = 'Error fetching sections from the database!';
	include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
	exit();
}
foreach ($result as $row){
	$sections[] = array('id' => $row['ID'], 'name' => $row['Name']);
}


if(isset($_POST['showEdit'])){$edit="";}

if(isset($_POST['action'])){

	if($_POST['action'] == 'Edit'){
		/****Validate Name******/
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
		/****Validate Section****/
		if(empty($_POST['section'])){
			$sectionError .= "Please select a section";
		}
		elseif(in_array($_POST['section'], $topics)){
			$sectionError .= "Selected section not found";
		}

		/****Validate Description******/
		if(empty($_POST['description'])){
			$descriptionError .= "Please enter a topic description.";
		}
		elseif(strlen($_POST['description']) > 150){
			$descriptionError .= "Please enter a shorter description (max 150 characters).";
		}

		/****If no errors******/
		if(empty($nameError) && empty($sectionError) && empty($descriptionError)){
			/****Update Information in DB******/
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
				include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
				exit();
			}
			header('Location: /Admin?Topics&Messages='.urlencode(' Topic Edited!'));
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
			include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
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
				include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
				exit();
			}
		}
		try{
			$pdo->query('DELETE FROM Threads Where TopicID = '.$_POST['id']);
		}
		catch (PDOException $e){
			$error = 'Error deleting Threads.';
			include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
			exit();
		}
		try{
			$pdo->query('DELETE FROM Topics Where ID = '.$_POST['id']);
		}
		catch (PDOException $e){
			$error = 'Error deleting topic.';
			include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
			exit();
		}
		header('Location: /Admin?Topics&Messages='.urlencode(' Topic Deleted!'));
		exit();
	}

	elseif($_POST['action'] == 'Add'){
		/****Validate Name******/
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
		/****Validate Section****/
		if(empty($_POST['section'])){
			$sectionError .= "Please select a section";
		}
		elseif(in_array($_POST['section'], $topics)){
			$sectionError .= "Selected section not found";
		}

		/****Validate Description******/
		if(empty($_POST['description'])){
			$descriptionError .= "Please enter a topic description.";
		}
		elseif(strlen($_POST['description']) > 200){
			$descriptionError .= "Please enter a shorter description (max 50 characters).";
		}

		/****If no errors******/
		if(empty($nameError) && empty($sectionError) && empty($descriptionError)){
			/****Update Information in DB******/
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
				include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
				exit();
			}
			header('Location: /Admin?Topics&Messages='.urlencode(' Topic Added!'));
		}
	}
}
?>

<h3>Topics</h3>
<div class="Seperate">
	<label for="newTopic">
		<span class="pointer" style="text-decoration: underline;">
		<?php if(isset($edit)){echo 'Edit topic';}else{echo 'Add new topic';} ?></span>
	</label>
	<input class="section_hide" type='checkbox' id="newTopic" 
	<?php if(isset($edit)){echo 'Checked';}elseif($_POST['action'] == 'Add'){echo 'Checked';} ?>>
	<form action="" method="post">
		<p>
			<label for="Name">Name</label><br>
			<input id="Name" name="name" value="<?php if(!empty($_POST['name'])){htmlout($_POST['name']);}elseif(isset($edit)){htmlout($editTopic['name']);} ?>">
			<?php if(!empty($nameError)): ?>
				<span class="error"><?php echo $nameError; ?></span>
			<?php endif; ?>
		</p>
		<p>
			<label for="Section">Section</label><br>
			<select id="Section" name="section">
				<?php foreach ($sections as $section) echo "<option value='".$section['id']."'>".$section['name']."</option>"; ?>
			</select>
			<?php if(!empty($sectionError)): ?>
				<span class="error"><?php echo $sectionError; ?></span>
			<?php endif; ?>
		</p>
		<p>
			<label for="content">Description</label><br>
			<textarea id="content" rows="1" style="height:1em;" name="description"><?php if(!empty($_POST['description'])){htmlout($_POST['description']);}elseif(isset($edit)){htmlout($editTopic['description']);} ?></textarea>
			<?php if(!empty($descriptionError)): ?>
				<span class="error"><?php echo $descriptionError; ?></span>
			<?php endif; ?>
		</p>
		<input type="hidden" name="id" value="<?php echo $_POST['id']; ?>">
		<input type="submit" name="action" value="<?php if(isset($edit)){echo 'Edit';}else{echo 'Add';} ?>">
		<?php if(isset($edit)){echo ' <a class="button" href="/Admin?Topics">Cancel Edit</a>';} ?>
	</form>
</div>
<?php foreach ($topics as $topic): ?>
	<form class="Seperate" action="" method="post">
		<input type="hidden" name="id" value="<?php echo $topic['id']; ?>">
		<?php echo "ID: ".$topic['id']; ?>

		<input type="submit" name="showEdit" value="Edit">

		<label class="button pointer" for="<?php echo $topic['id']; ?>">Delete</label>
		<input id="<?php echo $topic['id']; ?>" type="checkbox" class="hide">
		<input type="submit" name="action" value="Confirm Delete">
		<br>
		<?php foreach($sections as $section){
			if($section['id'] == $topic['section']){
				echo "Section: ".$section['name']."<br>";
			}
		}
		echo "Name: ".$topic['name']."<br>
		Description: ".$topic['description']; ?>
	</form>
<?php endforeach; ?>