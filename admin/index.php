<?php
//include config
require_once('../includes/config.php');
// require_once('../includes/functions.php');
//if not logged in redirect to login page
if (!$user->is_logged_in()) {
	header('Location: login.php');
}
//show message from add / edit page
if (isset($_GET['delpost'])) {
	$stmt = $db->prepare('DELETE FROM crazyguitar_posts_seo WHERE postID = :postID');
	$stmt->execute(array(':postID' => $_GET['delpost']));
	//delete post genere. 
	$stmt = $db->prepare('DELETE FROM crazyguitar_post_cats WHERE postID = :postID');
	$stmt->execute(array(':postID' => $_GET['delpost']));
	header('Location: index.php?action=deleted');
	exit;
}
?>
<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Admin</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="../images/icon.ico" type="image/icon type">
	<link rel="stylesheet" href="../style/normalize.css">
	<!-- <link rel="stylesheet" href="../style/main.css"> -->
	<script language="JavaScript" type="text/javascript">
		function delpost(id, title) {
			if (confirm("Are you sure you want to delete '" + title + "'")) {
				window.location.href = 'index.php?delpost=' + id;
			}
		}
	</script>
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/simple-parallax-js@5.5.1/dist/simpleParallax.min.js"></script>
</head>

<body>

	<div class="w3-content  w3-center w3-padding-64" style="max-width:max-content">
		<div id="w3-display-container w3-center w3-padding-64">
			<?php include('menu.php'); ?>
			<?php
			//show message from add / edit page
			if (isset($_GET['action'])) {
				echo '<h3>Post ' . $_GET['action'] . '.</h3>';
			}
			?>
			<table class="w3-table w3-bordered w3-hoverable w3-card ">
				<tr class="w3-center w3-red">
					<th class="w3-center w3-padding-16">Title</th>
					<th class="w3-center w3-padding-16">Date</th>
					<th class="w3-center w3-padding-16">Action</th>
				</tr>
				<?php
				try {
					$author = trim($_SESSION['username']);
					$stmt0 = $db->prepare('SELECT  memberID FROM crazyguitar_users WHERE username = :author');
					$stmt0->execute(array(':author' => $author));
					$row0 = $stmt0->fetch();
					$auth_id = $row0['memberID'];
					$stmt = $db->prepare('SELECT postID, postTitle, postDate FROM crazyguitar_posts_seo WHERE author=:author  ORDER BY postID DESC');
					$stmt->execute(array(
						':author' => $auth_id
					));
					while ($row = $stmt->fetch()) {
						echo '<tr>';
						echo '<td class="w3-center w3-padding-small">' . $row['postTitle'] . '</td>';
						echo '<td class="w3-center w3-padding-small">' . date('jS M Y', strtotime($row['postDate'])) . '</td>';
				?>
						<td class="w3-center w3-padding-small">
							<a href="edit-song-<?php echo $row['postID']; ?>">Edit</a> |
							<a href="javascript:delpost('<?php echo $row['postID']; ?>','<?php echo $row['postTitle']; ?>')">Delete</a>|
							<a href="comments.php?id=<?php echo $row['postID']; ?>">View Comments</a> |
							<a href="select-album.php?id=<?php echo $row['postID']; ?>">Add Group</a>
						</td>
				<?php
						echo '</tr>';
					}
				} catch (PDOException $e) {
					echo $e->getMessage();
				}
				?>
			</table>
			<p><a class="w3-btn w3-red" href='add-song'>Add Song</a></p>
		</div>
	</div>
</body>

</html>