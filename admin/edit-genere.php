<?php
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
	<title>Admin - Edit Category</title>
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

	<div class="w3-content  w3-padding-64" style="max-width:max-content">
		<div id="w3-display-container w3-padding-64">

			<?php include('menu.php'); ?>
			<p><a href="genere.php">genere Index</a></p>

			<h2>Edit Category</h2>


			<?php

			//if form has been submitted process it
			if (isset($_POST['submit'])) {

				//collect form data
				extract($_POST);

				//very basic validation
				if ($catID == '') {
					$error[] = 'This post is missing a valid id!.';
				}

				if ($catTitle == '') {
					$error[] = 'Please enter the title.';
				}

				if (!isset($error)) {

					try {

						$catSlug = slug($catTitle);

						//insert into database
						$stmt = $db->prepare('UPDATE crazyguitar_cats SET catTitle = :catTitle, catSlug = :catSlug WHERE catID = :catID');
						$stmt->execute(array(
							':catTitle' => $catTitle,
							':catSlug' => $catSlug,
							':catID' => $catID
						));

						//redirect to index page
						header('Location: genere.php?action=updated');
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

				$stmt = $db->prepare('SELECT catID, catTitle FROM crazyguitar_cats WHERE catID = :catID');
				$stmt->execute(array(':catID' => $_GET['id']));
				$row = $stmt->fetch();
			} catch (PDOException $e) {
				echo $e->getMessage();
			}

			?>

			<form action='' method='post'>
				<input type='hidden' name='catID' value='<?php echo $row['catID']; ?>'>

				<p><label>Title</label><br />
					<input type='text' name='catTitle' value='<?php echo $row['catTitle']; ?>'>
				</p>

				<p><input type='submit' name='submit' value='Update'></p>

			</form>

		</div>
	</div>

</body>

</html>