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
	<title>Admin - Edit User</title>
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

			<h2>Edit User</h2>


			<?php

			//if form has been submitted process it
			if (isset($_POST['submit'])) {

				//collect form data
				extract($_POST);

				//very basic validation
				if ($username == '') {
					$error[] = 'Please enter the username.';
				}

				if (strlen($password) > 0) {

					if ($password == '') {
						$error[] = 'Please enter the password.';
					}

					if ($passwordConfirm == '') {
						$error[] = 'Please confirm the password.';
					}

					if ($password != $passwordConfirm) {
						$error[] = 'Passwords do not match.';
					}
				}


				if ($email == '') {
					$error[] = 'Please enter the email address.';
				}

				if (!isset($error)) {

					try {

						if (isset($password)) {

							$hashedpassword = $user->password_hash($password, PASSWORD_BCRYPT);

							//update into database
							$stmt = $db->prepare('UPDATE crazyguitar_users SET username = :username, password = :password, email = :email , about = :about, disply_pic = :disply_pic WHERE memberID = :memberID');
							$stmt->execute(array(
								':username' => $username,
								':password' => $hashedpassword,
								':email' => $email,
								':about' => $about,
								':disply_pic' => $disply_pic,
								':memberID' => $memberID
							));
						} else {

							//update database
							$stmt = $db->prepare('UPDATE crazyguitar_users SET username = :username, email = :email, about = :about, disply_pic = :disply_pic WHERE memberID = :memberID');
							$stmt->execute(array(
								':username' => $username,
								':email' => $email,
								':about' => $about,
								':disply_pic' => $disply_pic,
								':memberID' => $memberID
							));
						}


						//redirect to index page
						header('Location: users.php?action=updated');
						exit;
					} catch (PDOException $e) {
						echo $e->getMessage();
					}
				}
			}

			?>


			<?php
			//check for any errors
			if (isset($error)) {
				foreach ($error as $error) {
					echo $error . '<br />';
				}
			}

			try {

				$stmt = $db->prepare('SELECT memberID, username, email, about, disply_pic FROM crazyguitar_users WHERE memberID = :memberID');
				$stmt->execute(array(':memberID' => $_GET['id']));
				$row = $stmt->fetch();
			} catch (PDOException $e) {
				echo $e->getMessage();
			}

			?>

			<form action='' method='post'>
				<input type='hidden' name='memberID' value='<?php echo $row['memberID']; ?>'>

				<p><label>Username</label><br />
					<input type='text' name='username' value='<?php echo $row['username']; ?>'>
				</p>

				<p><label>Password (only to change)</label><br />
					<input type='password' name='password' value=''>
				</p>

				<p><label>Confirm Password</label><br />
					<input type='password' name='passwordConfirm' value=''>
				</p>

				<p><label>Email</label><br />
					<input type='text' name='email' value='<?php echo $row['email']; ?>'>
				</p>

				<p><label>About</label><br />
					<textarea type='text' name='about' cols='60' rows='10'><?php
																			echo $row['about'];
																			?></textarea>
				</p>

				<p><label>Image Url</label><br />
					<input type='varchar' name='disply_pic' value='<?php
																	echo $row['disply_pic'];
																	?>'>
				</p>

				<p><input type='submit' name='submit' value='Update User'></p>

			</form>

		</div>
	</div>

</body>

</html>