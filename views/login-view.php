<!-- View -->

<div class="row login">
	<h1>Login</h1>

	<?php
	// If logout query string exists in URL, output a logged out message.

	if (isset($_SESSION["loggedout"])) {
		echo "<div class='loggedout'>{$_SESSION["loggedout"]}</div>";
		session_destroy();
	}
	?>

	<form action="<?php echo $_SERVER['PHP_SELF']; ?>?action=login" method="post">
		<div class="form-control">
			<label for="email">Email address:</label>
			<input type="text" id="email" name="email" value="<?php echo $email ?>">
		</div>
		<?php
			// Errors...
			if(!empty($errors)&& isset($errors["login_email"])) {
				echo '<div class="row errors">';
				echo errors($errors, "login_email");
				echo '</div>';
			}
		?>
		<div class="form-control">
			<label for="password">Password:</label>
			<input type="password" id="password" name="password">
		</div>
		<?php
			// Errors...
			if(!empty($errors) && isset($errors["login_password"])) {
				echo '<div class="row errors">';
				echo errors($errors, "login_password");
				echo '</div>';
			}
		?>
		<div class="form-control">
			<input type="submit" name="submit" class="btn" value="Login">
		</div>
	</form>
	<?php
		// Errors...
		if(!empty($errors) && isset($errors["login"])) {
			echo '<div class="row errors">';
			echo errors($errors, "login");
			echo '</div>';
		}
	?>
	
	<!-- <div id="dev">
		<p>For dev purposes...</p>
		<p>k.l.hutton@assign3.ac.uk password</p>
		<p>y.miandad@assign3.ac.uk letmein</p>
		<p>s.laxman@assign3.ac.uk password2</p>
	</div> -->
</div>