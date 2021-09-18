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
	<link rel="stylesheet" href="../style/main.css">
	<script src="../js/jquery-3.2.1.min.js"></script>
</head>
<body>
	<div id="wrapper">
		<?php include('menu.php'); ?>
		<p><a href="./">Blog Admin Index</a></p>
		<?php
			try {

			$stmt4 = $db->prepare('SELECT postID, postTitle FROM blog_posts_seo WHERE postID = :postID');
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
					$stmt = $db->prepare('DELETE FROM blog_post_group WHERE postID = :postID');
					$stmt->execute(array(':postID' => $postID));
					if (is_array($groupID)) {
						foreach ($_POST['groupID'] as $groupID) {
							$stmt = $db->prepare('INSERT INTO blog_post_group (postID,groupID)VALUES(:postID,:groupID)');
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
				$stmt2 = $db->query('SELECT groupID, groupTitle FROM blog_group ORDER BY groupTitle');
				while ($row2 = $stmt2->fetch()) {
					$stmt3 = $db->prepare('SELECT groupID FROM blog_post_group WHERE groupID = :groupID AND postID = :postID');
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
</body>
</html>