<?php
//include config
require_once('../includes/config.php');

//if not logged in redirect to login page
if (!$user->is_logged_in()) {
	header('Location: login.php');
}

//show message from add / edit page
if (isset($_GET['delgroup'])) {

	$stmt = $db->prepare('DELETE FROM blog_group WHERE groupID = :groupID');
	$stmt->execute(array(':groupID' => $_GET['delgroup']));

	header('Location: group.php?action=deleted');
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
		function delgroup(id, title) {
			if (confirm("Are you sure you want to delete '" + title + "'")) {
				window.location.href = 'group.php?delgroup=' + id;
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
			echo '<h3>Group ' . $_GET['action'] . '.</h3>';
		}
		?>

		<table>
			<tr>
				<th>Title</th>
				<th>Action</th>
			</tr>
			<?php
			try {

				$stmt = $db->query('SELECT groupID, groupTitle, groupSlug FROM blog_group ORDER BY groupTitle DESC');
				while ($row = $stmt->fetch()) {

					echo '<tr>';
					echo '<td>' . $row['groupTitle'] . '</td>';
			?>

					<td>
						<a href="edit-group-<?php echo $row['groupID']; ?>">Edit</a> |
						<a href="javascript:delgroup('<?php echo $row['groupID']; ?>','<?php echo $row['groupSlug']; ?>')">Delete</a>
					</td>

			<?php
					echo '</tr>';
				}
			} catch (PDOException $e) {
				echo $e->getMessage();
			}
			?>
		</table>

		<p><a href='add-group.php'>Add Group</a></p>

	</div>

</body>

</html>