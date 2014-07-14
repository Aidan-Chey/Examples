<h3>Password Reset</h3>
<form action="" method="post">
	<p>
		<label for="email">Email: </label><br>
		<input type="email" name="email" id="email" maxlength="100" value="<?php if(!empty($_POST["email"])) htmlout($_POST["email"]); ?>" required>
		<?php if(!empty($emailError)) echo "<br><span class='error'>$emailError</span>"; ?><br>
	</p>
	<p>
		<label for="password">Password: </label><br>
		<input type="password" name="password" id="password" maxlength="100" required>
		<?php if(!empty($passError)) echo "<br><span class='error'>$passError</span>"; ?><br>
	</p>
	<input type="hidden" name="action" value="Reset"><br>
	<button>Reset Password</button>
</form>