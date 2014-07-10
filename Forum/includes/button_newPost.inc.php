<form method="get">
	<input type="hidden" name="newPost">
	<input type="hidden" name="Thread" value="<?php htmlout($_GET['Thread']); ?>">
	<input type="hidden" name="Page" value="<?php htmlout($_GET['Page']); ?>">
	<button>Create Post</button>
</form>