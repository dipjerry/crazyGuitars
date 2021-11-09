<?php
//include config
require_once('../includes/config.php');
//if not logged in redirect to login page
if (!$user->is_logged_in()) {
	header('Location: login.php');
}

//show message from add / edit page
if (isset($_GET['delcat'])) {
	$stmt = $db->prepare('DELETE FROM crazyguitar_cats WHERE catID = :catID');
	$stmt->execute(array(':catID' => $_GET['delcat']));
	header('Location: genere.php?action=deleted');
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
	<!-- <link rel="stylesheet" href="../style/main.css"> -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script language="JavaScript" type="text/javascript">
		function delcat(id, title) {
			if (confirm("Are you sure you want to delete '" + title + "'")) {
				window.location.href = 'genere.php?delcat=' + id;
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
				echo '<h3>Category ' . $_GET['action'] . '.</h3>';
			}
			?>
			<table class="w3-table w3-bordered w3-hoverable w3-card ">
				<tr class="w3-center w3-red">
					<th class="w3-center w3-padding-16">Title</th>
					<th class="w3-center w3-padding-16">Action</th>
				</tr>
				<?php
				try {
					$stmt = $db->query('SELECT catID, catTitle, catSlug FROM crazyguitar_cats ORDER BY catTitle DESC');
					while ($row = $stmt->fetch()) {

						echo '<tr>';
						echo '<td class="w3-center w3-padding-small">' . $row['catTitle'] . '</td>';
				?>
						<td class="w3-center w3-padding-small">
							<a href="edit-genere-<?php echo $row['catID']; ?>">Edit</a> |
							<a href="javascript:delcat('<?php echo $row['catID']; ?>','<?php echo $row['catSlug']; ?>')">Delete</a>
						</td>
				<?php
						echo '</tr>';
					}
				} catch (PDOException $e) {
					echo $e->getMessage();
				}
				?>
			</table>
			<p><a href='add-genere.php'>Add Category</a></p>
		</div>
	</div>
</body>

</html>