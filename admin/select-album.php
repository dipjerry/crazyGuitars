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
	<title>Admin - Edit Post</title>
	<link rel="icon" href="../images/icon.ico" type="image/icon type">
	<link rel="stylesheet" href="../style/normalize.css">
	<!-- <link rel="stylesheet" href="../style/main.css"> -->
	<script src="../js/jquery-3.2.1.min.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/simple-parallax-js@5.5.1/dist/simpleParallax.min.js"></script>
</head>

<body>
	<div class="w3-content" style="max-width:2000px">
		<div id="w3-display-container w3-content w3-cente w3-red w3-padding-64" style="max-width:1200px">

			<?php include('menu.php'); ?>
			<p><a href="./">crazyguitar Admin Index</a></p>
			<?php
			try {

				$stmt4 = $db->prepare('SELECT postID, postTitle FROM crazyguitar_posts_seo WHERE postID = :postID');
				$stmt4->execute(array(':postID' => $_GET['id']));
				$row4 = $stmt4->fetch();
			} catch (PDOException $e) {
				echo $e->getMessage();
			}
			?>
			<h2>Select Group for <?php echo $row4['postTitle']; ?></h2>
			<?php
			//if form has been submitted process it
			if (isset($_POST['submit'])) {
				//collect form data
				extract($_POST);
				//very basic validation
				if ($postID == '') {
					$error[] = 'This post is missing a valid id!.';
				}
				if (!isset($error)) {
					try {
						//delete all items with the current postID
						$stmt = $db->prepare('DELETE FROM crazyguitar_post_group WHERE postID = :postID');
						$stmt->execute(array(':postID' => $postID));
						if (is_array($groupID)) {
							foreach ($_POST['groupID'] as $groupID) {
								$stmt = $db->prepare('INSERT INTO crazyguitar_post_group (postID,groupID)VALUES(:postID,:groupID)');
								$stmt->execute(array(
									':postID' => $postID,
									':groupID' => $groupID
								));
							}
						}
						//redirect to index page
						header('Location: index.php?action=updated');
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
			?>

			<form action='' method='post'>
				<input type='hidden' name='postID' value='<?php echo $row4['postID']; ?>'>
				<fieldset>

					<legend>Groups</legend>
					<?php
					$stmt2 = $db->query('SELECT groupID, groupTitle FROM crazyguitar_group ORDER BY groupTitle');
					while ($row2 = $stmt2->fetch()) {
						$stmt3 = $db->prepare('SELECT groupID FROM crazyguitar_post_group WHERE groupID = :groupID AND postID = :postID');
						$stmt3->execute(array(':groupID' => $row2['groupID'], ':postID' => $row4['postID']));
						$row3 = $stmt3->fetch();

						if ($row3['groupID'] == $row2['groupID']) {
							$checked = 'checked=checked';
						} else {
							$checked = null;
						}
						echo "<input type='radio' name='groupID[]' value='" . $row2['groupID'] . "' $checked> " . $row2['groupTitle'] . "<br />";
					}

					?>
				</fieldset>

				<p><input type='submit' name='submit' value='Update'></p>
			</form>
		</div>
	</div>
</body>

</html>