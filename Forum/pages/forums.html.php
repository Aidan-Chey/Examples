<?php 
session_start();
$_SESSION['previousPage'] = $_SERVER['REQUEST_URI'];

//Connect to Database
include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/db.inc.php';

//Retrieve List of Sections
try{
	$sectionResult = $pdo->query('SELECT Sections.ID as sID, Sections.Name as sName, Sections.Description as sDescription 
		FROM Sections 
		ORDER BY Sections.ID');
}
catch (PDOException $e){
	$error = 'Error retrieving Sections.';
	include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/error.html.php';
	exit();
}
foreach ($sectionResult as $sectionRow){
	$sections[] = array('name' => $sectionRow['sName'], 'description' => $sectionRow['sDescription']);
}

//Retrieve List of Topics
try{
	$topicResult = $pdo->query('SELECT Topics.ID as tID, Topics.Name as tName, Topics.Description as tDescription, Sections.Name as sName 
		FROM Topics 
		INNER JOIN Sections ON Topics.SectionID = Sections.ID 
		ORDER BY Topics.Name');
}
catch (PDOException $e){
	$error = 'Error retrieving Topics.';
	include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/error.html.php';
	exit();
}
foreach ($topicResult as $topicRow){
	$topics[] = array('id' => $topicRow['tID'], 'name' => $topicRow['tName'], 'description' => $topicRow['tDescription'], 'section' => $topicRow['sName']);
}
?>

<h2>Topics</h2>

<?php foreach ($sections as $section): $sName = $section['name']; ?>
<div class="Seperate">
	<label for="<?php htmlout($sName); ?>">
		<section class="pointer">
			<h3><?php htmlout($sName); ?></h3>
		</section>
	</label>
	<input class="hide" type="checkbox" id="<?php htmlout($sName); ?>">
	<ul>
		<?php foreach($topics as $topic): ?>
			<?php if($topic['section'] == $sName): ?>		
				<li>
					<header><a href="?Topic=<?php echo $topic['id']; ?>"><?php htmlout($topic['name']); ?></a></header>
					<span><?php htmlout($topic['description']); ?></span>
				</li>
			<?php endif; ?>
		<?php endforeach; ?>
	</ul>
</div>
<?php endforeach; ?>