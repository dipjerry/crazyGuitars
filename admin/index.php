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

	$stmt = $db->prepare('DELETE FROM blog_posts_seo WHERE postID = :postID');
	$stmt->execute(array(':postID' => $_GET['delpost']));

	//delete post categories. 
	$stmt = $db->prepare('DELETE FROM blog_post_cats WHERE postID = :postID');
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
	<link rel="icon" href="../images/icon.ico" type="image/icon type">
	<link rel="stylesheet" href="../style/normalize.css">
	<link rel="stylesheet" href="../style/main.css">
	<script language="JavaScript" type="text/javascript">
		function delpost(id, title) {
			if (confirm("Are you sure you want to delete '" + title + "'")) {
				window.location.href = 'index.php?delpost=' + id;
			}
		}
	</script>

</head>

<body>

	<div id="wrapper">

		<?php include('menu.php'); ?>

		<?php
		//show message from add / edit page

		if (isset($_GET['action'])) {
			echo '<h3>Post ' . $_GET['action'] . '.</h3>';
		}
		?>

		<table>
			<tr>
				<th>Title</th>
				<th>Date</th>
				<th>Action</th>
			</tr>
			<?php
			try {
				$author = trim($_SESSION['username']);
				$stmt0 = $db->prepare('SELECT  memberID FROM blog_members WHERE username = :author');
				$stmt0->execute(array(':author' => $author));
				$row0 = $stmt0->fetch();
				$auth_id = $row0['memberID'];
				$stmt = $db->prepare('SELECT postID, postTitle, postDate FROM blog_posts_seo WHERE author=:author  ORDER BY postID DESC');
				$stmt->execute(array(
					':author' => $auth_id
				));
				while ($row = $stmt->fetch()) {

					echo '<tr>';
					echo '<td>' . $row['postTitle'] . '</td>';
					echo '<td>' . date('jS M Y', strtotime($row['postDate'])) . '</td>';
			?>

					<td>
						<a href="edit-post-<?php echo $row['postID']; ?>">Edit</a> |
						<a href="javascript:delpost('<?php echo $row['postID']; ?>','<?php echo $row['postTitle']; ?>')">Delete</a>|
						<a href="comments.php?id=<?php echo $row['postID']; ?>">View Comments</a> |
						<a href="select-group.php?id=<?php echo $row['postID']; ?>">Add Group</a>
					</td>

			<?php
					echo '</tr>';
				}
			} catch (PDOException $e) {
				echo $e->getMessage();
			}
			?>
		</table>

		<p><a href='add-post'>Add Post</a></p>

	</div>

</body>

</html>