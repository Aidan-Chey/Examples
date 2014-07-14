<p>
	This form will add you as User so you can post in this forum.
</p>
<form action="" method="post">
	<p>
		<label for="email">Email Address: </label><br>
		<input type="email" name="email" id="email" maxlength="100" value="<?php if(!empty($_POST['email'])) htmlout($_POST['email']); ?>" required><br>
		<?php if(!empty($emailError)): ?>
			<span class="error"><?php echo $emailError; ?></span>
		<?php endif; ?>
	</p>
	<p>
		<label for="name">Display Name: </label><br>
		<input name="name" id="name" maxlength="50" value="<?php if(!empty($_POST['name'])) htmlout($_POST['name']); ?>" required><br>
		<?php if(!empty($nameError)): ?>
			<span class="error"><?php echo $nameError; ?></span>
		<?php endif; ?>
	</p>
	<p>
		<label for="password">Password: </label><br>
		<input type="password" name="password" id="password" maxlength="120" required><br>
		<label for="password2">Confirm Password: </label><br>
		<input type="password" name="password2" id="password2" maxlength="120" required>
		<?php if(!empty($passError)): ?>
			<span class="error"><?php echo $passError; ?></span>
		<?php endif; ?>
	</p>
	<input type="hidden" name="register">
	<button>Register</button>
</form>