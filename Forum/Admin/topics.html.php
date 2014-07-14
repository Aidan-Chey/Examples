<?php 
include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/db.inc.php';

$_SESSION['previousPage'] = $_SERVER['REQUEST_URI'];

// Retrive topic list
try{
	$result = $pdo->query('SELECT ID, Name, Description, SectionID FROM Topics');
}
catch (PDOException $e){
	$error = 'Error fetching topics from the database!';
	include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/error.html.php';
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
	include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/error.html.php';
	exit();
}
foreach ($result as $row){
	$sections[] = array('id' => $row['ID'], 'name' => $row['Name']);
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
		<?php if(isset($edit)){echo ' <a class="button" href="/Forum/Admin/?Topics">Cancel Edit</a>';} ?>
	</form>
</div>
<?php foreach ($topics as $topic): ?>
	<form class="Seperate" method="post">
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