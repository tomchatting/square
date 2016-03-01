<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<title>Login to <?php echo Square::$site['title']; ?></title>
</head>
<body>
	<h1 class="header"><?php echo Square::$site['title']; ?> <span>login</span></h1>
	<div class="wrapper">
		<?php if($fail == true){?>
		<div class="alert">
			Incorrect username/password.
		</div>
		<?php } ?>
		<form method="post">
			<p>Username:<br><input type="text" name="username" /></p>
			<p>Password:<br><input type="password" name="password" /></p>
			<button name="login" type="submit" value="Login" class="commit">Login</button>
		</form>
	</div>
</body>
</html>
