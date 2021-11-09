<?php //include config
require_once('../includes/config.php');
// require_once('../includes/functions.php');
//if not logged in redirect to login page
if (!$user->is_logged_in()) {
	header('Location: login.php');
}
?>
<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Admin - Add Group</title>
	<link rel="icon" href="../images/icon.ico" type="image/icon type">
	<link rel="stylesheet" href="../style/normalize.css">

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/simple-parallax-js@5.5.1/dist/simpleParallax.min.js"></script>
</head>

<body>

	<div class="w3-content w3-padding-64" style="max-width:max-content">
		<div id="w3-display-container w3-padding-64">

			<?php include('menu.php'); ?>
			<p><a href="album.php">Group Index</a></p>

			<h2>Add Album</h2>

			<?php

			//if form has been submitted process it
			if (isset($_POST['submit'])) {

				//collect form data
				extract($_POST);

				//very basic validation
				if ($groupTitle == '') {
					$error[] = 'Please enter the Group.';
				}

				if (!isset($error)) {

					try {

						$groupSlug = slug($groupTitle);

						//insert into database
						$stmt = $db->prepare('INSERT INTO crazyguitar_group(groupTitle,groupSlug) VALUES (:groupTitle, :groupSlug)');
						$stmt->execute(array(
							':groupTitle' => $groupTitle,
							':groupSlug' => $groupSlug
						));

						//redirect to index page
						header('Location: album.php?action=added');
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

				<p><label>Title</label><br />
					<input type='text' name='groupTitle' value='<?php if (isset($error)) {
																	echo $_POST['groupTitle'];
																} ?>'>
				</p>

				<p><input type='submit' name='submit' value='Submit'></p>

			</form>

		</div>
	</div>
</body>

</html>