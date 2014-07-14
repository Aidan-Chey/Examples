<?php 
// Retrive section list
include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/db.inc.php';

try{
	$result = $pdo->query('SELECT ID, Name, Description FROM Sections');
}
catch (PDOException $e){
	$error = 'Error fetching sections from the database!';
	include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/error.html.php';
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
		<?php if(isset($edit)){echo ' <a class="button" href="/Forum/Admin/?Sections">Cancel Edit</a>';} ?>
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