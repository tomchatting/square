<div class="container">
<h1 class="header"><?php echo Square::$site['title']; ?> <span>login</span></h1>
	<?php if($fail){?>
	<div class="message">
		Incorrect username/password.
	</div>
	<?php } ?>
	<?php if(isset($_GET['lo'])){?>
		<div class="message">
			Logged out successfully.
		</div>
		<?php } ?>
	<form method="post">
		<p>Username:<br><input type="text" name="username" /></p>
		<p>Password:<br><input type="password" name="password" /></p>
		<button name="login" type="submit" value="Login" class="commit">Login</button>
	</form>

	<footer><small>sc v <?php echo Square::$version; ?></small></footer>
</div>
