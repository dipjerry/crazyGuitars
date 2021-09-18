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
	<link rel="stylesheet" href="../style/main.css">
</head>

<body>

	<div id="wrapper">

		<?php include('menu.php'); ?>
		<p><a href="group.php">Group Index</a></p>

		<h2>Add Group</h2>

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
					$stmt = $db->prepare('INSERT INTO blog_group(groupTitle,groupSlug) VALUES (:groupTitle, :groupSlug)');
					$stmt->execute(array(
						':groupTitle' => $groupTitle,
						':groupSlug' => $groupSlug
					));

					//redirect to index page
					header('Location: group.php?action=added');
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
															} ?>'></p>

			<p><input type='submit' name='submit' value='Submit'></p>

		</form>

	</div>