<?php 
if($_GET['Page'] == 1){
	header("Location: ?Thread=".$_GET['Thread']);
	exit();
}
session_start();
$_SESSION['previousPage'] = $_SERVER['REQUEST_URI'];

//Connect to Database
	include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/db.inc.php';

//Count Posts under Thread
	try{
		$result = $pdo->query('SELECT COUNT(*)
		FROM Posts
		WHERE Posts.ThreadID = '.$_GET['Thread']);
	}
	catch (PDOException $e){
		$error = 'Error retrieving post count.';
		include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/error.html.php';
		exit();
	}
	foreach ($result as $row){
		$postCount = $row[0];
	}
	$pageCount = ceil($postCount / $postsPerPage);

//Retrieve Posts under Thread
	$limitStart = ($_GET['Page'] - 1) * $postsPerPage;
	try{
		$result = $pdo->query('SELECT Posts.ID as pID, Posts.Contents as pContents, Posts.Created as pCreated, Users.Name as uName, Users.Email as uEmail, Users.Joined as uJoin 
		FROM Posts
		INNER JOIN Users ON Posts.CreatorID = Users.ID
		WHERE Posts.ThreadID = '.$_GET['Thread'].' 
		ORDER BY Posts.Created 
		LIMIT '.$limitStart.', '.$postsPerPage);
	}
	catch (PDOException $e){
		$error = 'Error retrieving posts.';
		include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/error.html.php';
		exit();
	}
	foreach ($result as $row) {
		$posts[] = array('id' => $row['pID'],
			'content' => $row['pContents'], 
			'date' => $row['pCreated'], 
			'user' => $row['uName'],
			'email' => $row['uEmail'],
			'join' => $row['uJoin']);
	}
	$iterate = ceil($pageCount / 3);

if(userIsLoggedIn()) include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/button_newPost.inc.php';

foreach($posts as $post):
if(empty($post['id'])){header("Location: ?Thread=".$_GET['Thread']."&Page=".($_GET['Page']-1));}  ?>
<div class="Seperate page_wrap">
	<aside class=" userInfo">
		<?php htmlout($post['user']); 
		echo "<br><footer>Joined: ".$post['join']."</footer>"; ?>
	</aside>
	<article class="flex">
		<section><?php htmlout($post['content']); ?></section>
		<footer>Created: <?php echo $post['date']; ?>
			<?php if(userHasRole('Admin') || (userIsLoggedIn() && $_SESSION['email'] == $post['email'])): ?>
		 	<form class="inline" action="/Admin/?Post" method="post">
		 		<input type="hidden" name="id" value="<?php echo $post['id']; ?>">
		 		<input type="hidden" name="page" value="<?php htmlout($_GET['Page']); ?>">
		 		<input type="submit" name="action" value="Edit">
				<label class="button pointer" for="<?php echo $post['id']; ?>">Delete</label>
				<input id="<?php echo $post['id']; ?>" type="checkbox" class="hide">
				<input type="submit" name="action" value="Confirm Delete">
		 	</form>
		 	<?php endif; ?>
	 	</footer>
	</article>
</div>
<?php endforeach; ?>
<div class="post_browse">
	<?php if($_GET['Page'] > 2): ?> 
		<a href="?Thread=<?php htmlout($_GET['Thread']); ?>" title='First Page'>&#60&#60</a>
	<?php endif;
	for ($i = 3; $i < ($_GET['Page'] - 2) && $i > 1; $i += $iterate): ?>
		<a href="?Thread=<?php htmlout($_GET['Thread']); echo "&Page=".$i; ?>"><?php echo $i; ?></a>
	<?php endfor; ?>
	<a href="?Thread=<?php htmlout($_GET['Thread']); echo "&Page=".($_GET['Page']-1); ?>" title="Previous Page">&#60</a>
	<span title="Current Page"><?php htmlout($_GET['Page']); ?></span>
	<?php if($pageCount > $_GET['Page']): ?>
		<a href="?Thread=<?php htmlout($_GET['Thread']."&Page=".($_GET['Page'] + 1)); ?>" title='Next Page'>&#62</a>
	<?php endif; 
	for ($i = ($_GET['Page'] + 2); $i < ($pageCount - 1); $i += $iterate): ?>
		<a href="?Thread=<?php htmlout($_GET['Thread']); echo "&Page=".$i; ?>"><?php echo $i; ?></a>
	<?php endfor;
	if($pageCount > ($_GET['Page'] + 1)): ?>
		<a href="?Thread=<?php htmlout($_GET['Thread']); echo "&Page=".$pageCount; ?>" title='Last Page'>&#62&#62</a>
	<?php endif; ?>
</div>
<?php if(userIsLoggedIn()) include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/button_newPost.inc.php'; ?>