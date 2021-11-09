<?php
//include config
require_once('../includes/config.php');
//check if already logged in
if ($user->is_logged_in()) {
	header('Location: index.php');
}
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Admin Login</title>
	<link rel="icon" href="../images/icon.png" type="image/icon type">
	<link rel="stylesheet" href="../style/normalize.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/simple-parallax-js@5.5.1/dist/simpleParallax.min.js"></script>
</head>
<body>
	<div id="login">
		<?php
		//process login form if submitted
		if (isset($_POST['submit'])) {
			$username = trim($_POST['username']);
			$password = trim($_POST['password']);
			if ($user->login($username, $password)) {
				//logged in return to index page
				header('Location: index.php');
				exit;
			} else {
				$message = '<p class="error">Wrong username or password</p>';
			}
		} //end if submit
		if (isset($message)) {
			echo $message;
		}
		?>
		<form action="" method="post">
			<p><label>Username</label><input type="text" name="username" value="" /></p>
			<p><label>Password</label><input type="password" name="password" value="" /></p>
			<p><label></label><input type="submit" name="submit" value="Login" /></p>
		</form>
	</div>
</body>
</html>