<?php 
session_start();
$_SESSION['previousPage'] = $_SERVER['REQUEST_URI'];

/****Connect to Database******/
	include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/db.inc.php';

/****Retrieve Thread******/
	try{
		$result = $pdo->query('SELECT Threads.ID as tID, Threads.Title as tTitle, Threads.Contents as tContents, Threads.Created as tCreated, Threads.TopicID as tTopicID, Users.Name as uName, Users.Email as uEmail 
		FROM Threads
		INNER JOIN Users ON Threads.CreatorID = Users.ID
		WHERE Threads.ID = '.$_GET['Thread'].'
		LIMIT 1');
	}
	catch (PDOException $e){
		$error = 'Error retrieving Thread.';
		include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/error.html.php';
		exit();
	}
	foreach ($result as $row) {
		$thread = array('id' => $row['tID'],
			'title' => $row['tTitle'], 
			'content' => $row['tContents'], 
			'date' => $row['tCreated'],
			'topic' => $row['tTopicID'],
			'email' => $row['uEmail'],
			'user' => $row['uName']);
	}
/*****Retrieve Topic Name****/
	try{
		$result = $pdo->query('SELECT Name 
		FROM Topics
		WHERE ID = '.$thread['topic'].'
		LIMIT 1');
	}
	catch (PDOException $e){
		$error = 'Error retrieving Topic.';
		include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/error.html.php';
		exit();
	}
	foreach ($result as $row) {
		$topic = $row['Name'];
	}

/****Count Posts under Thread****/
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

/****Retrieve Posts under Thread******/
	try{
		$result = $pdo->query('SELECT Posts.ID as pID, Posts.Contents as pContents, Posts.Created as pCreated, Users.Name as uName, Users.Email as uEmail, Users.Joined as uJoin 
		FROM Posts
		INNER JOIN Users ON Posts.CreatorID = Users.ID
		WHERE Posts.ThreadID = '.$_GET['Thread'].' 
		ORDER BY Posts.Created 
		LIMIT 0, '.$postsPerPage);
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

if(userIsLoggedIn()) include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/button_newPost.inc.php'; ?>
<div>Topic: <a href="?Topic=<?php echo $thread['topic'] ?>"><?php htmlout($topic); ?></a></div>
<div class="Seperate">
	<h2><?php htmlout($thread['title']); ?></h2>
	<section><?php htmlout($thread['content']); ?></section>
	<footer>Created: <?php echo $thread['date']; ?> | By: <?php htmlout($thread['user']); ?>
		<?php if(userHasRole('Admin') || (userIsLoggedIn() && $_SESSION['email'] == $thread['email'])): ?>
	 	<form class="inline" action="/Admin/?Thread" method="post">
	 		<input type="hidden" name="id" value="<?php echo $thread['id']; ?>">
	 		<input type="submit" name="action" value="Edit">
			<label class="button pointer" for="<?php echo $thread['id']; ?>">Delete</label>
			<input id="<?php echo $thread['id']; ?>" type="checkbox" class="hide">
			<input type="submit" name="action" value="Confirm Delete">
	 	</form>
 		<?php endif; ?>
	</footer>
</div>
<?php if(!empty($posts)):
foreach($posts as $post): ?>
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
		 		<input type="submit" name="action" value="Edit">
				<label class="button pointer" for="<?php echo $post['id']; ?>">Delete</label>
				<input id="<?php echo $post['id']; ?>" type="checkbox" class="hide">
				<input type="submit" name="action" value="Confirm Delete">
		 	</form>
		 	<?php endif; ?>
	 	</footer>
	</article>
</div>
<?php endforeach; endif;
if($postCount > $postsPerPage): ?>
	<div class="post_browse">
		<span title="Current Page">1</span>
		<a href="<?php htmlout('?Thread='.$_GET['Thread'].'&Page=2'); ?>" title="Next Page">&#62</a>
		<?php for ($i = 3; $i < ($pageCount - 1); $i += $iterate): ?>
			<a href="?Thread=<?php htmlout($_GET['Thread']); ?>&Page=<?php echo $i; ?>"><?php echo $i; ?></a>
		<?php endfor;
		if($postCount > ($postsPerPage * 2)): ?>
			<a href="?Thread=<?php htmlout($_GET['Thread']); ?>&Page=<?php echo $pageCount; ?>" title='Last Page'>&#62&#62</a>
		<?php endif; ?>
	</div>
<?php endif;
if(userIsLoggedIn()) include $_SERVER['DOCUMENT_ROOT'].'/Forum/includes/button_newPost.inc.php'; ?>
