<?php //include config
require_once('../includes/config.php');
//if not logged in redirect to login page
if (!$user->is_logged_in()) {
	header('Location: login.php');
}
?>
<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Admin - Add User</title>
	<link rel="icon" href="./images/icon.ico" type="image/icon type">
	<link rel="stylesheet" href="../style/normalize.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/simple-parallax-js@5.5.1/dist/simpleParallax.min.js"></script>
</head>

<body>
	<div class="w3-content  w3-padding-64" style="max-width:max-content">
		<div id="w3-display-container w3-padding-64">
			<?php include('menu.php'); ?>
			<p><a href="users.php">User Admin Index</a></p>
			<h2>Add User</h2>
			<?php
			//if form has been submitted process it
			if (isset($_POST['submit'])) {
				extract($_POST);
				$stmt3 = $db->prepare('SELECT username, email FROM crazyguitar_users where username=:username or email=:email');
				$stmt3->execute(array(
					':username' => $username,
					':email' => $email
				));
				$row = $stmt3->fetch();
				//collect form data
				extract($_POST);
				//very basic validation
				if ($username == '') {
					$error[] = 'Please enter the username.';
				}
				if ($password == '') {
					$error[] = 'Please enter the password.';
				}
				if ($passwordConfirm == '') {
					$error[] = 'Please confirm the password.';
				}
				if ($password != $passwordConfirm) {
					$error[] = 'Passwords do not match.';
				}
				if ($email == '') {
					$error[] = 'Please enter the email address.';
				}
				if (!isset($error)) {
					$hashedpassword = $user->password_hash($_POST['password'], PASSWORD_BCRYPT);
					try {
						//insert into database
						$stmt = $db->prepare('INSERT INTO crazyguitar_users (username,password,email,about, disply_pic) VALUES (:username, :password, :email,:about, :display_pic)');
						$stmt->execute(array(
							':username' => $username,
							':password' => $hashedpassword,
							':email' => $email,
							':about' => $about,
							':display_pic' => $dp
						));
						//redirect to index page
						header('Location: users.php?action=added');
						exit;
					} catch (PDOException $e) {
						echo $e->getMessage();
					}
				}
			}
			//check for any errors
			if (isset($error)) {
				foreach ($error as $error) {
					echo '<p class="error">' . $error . '</p>';
				}
			}
			?>
			<form action='' method='post'>
				<p><label>Username</label><br />
					<input type='text' name='username' value='<?php if (isset($error)) {
																	echo $_POST['username'];
																} ?>'>
				</p>
				<p><label>Password</label><br />
					<input type='password' name='password' value='<?php if (isset($error)) {
																		echo $_POST['password'];
																	} ?>'>
				</p>
				<p><label>Confirm Password</label><br />
					<input type='password' name='passwordConfirm' value='<?php if (isset($error)) {
																				echo $_POST['passwordConfirm'];
																			} ?>'>
				</p>
				<p><label>Email</label><br />
					<input type='text' name='email' value='<?php if (isset($error)) {
																echo $_POST['email'];
															} ?>'>
				</p>
				<p><label>About</label><br />
					<textarea type='text' name='about' cols='60' rows='10' value='<?php if (isset($error)) {
																						echo $_POST['about'];
																					} ?>'></textarea>
				</p>
				<p><label>Image Url</label><br />
					<input type='varchar' name='dp' value='<?php if (isset($error)) {
																echo $_POST['dp'];
															} ?>'>
				</p>
				<p><input type='submit' name='submit' value='Add User'></p>
			</form>
		</div>
	</div>
</body>

</html>