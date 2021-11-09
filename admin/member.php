<?php
//include config
require_once('../includes/config.php');

//if not logged in redirect to login page
if (!$user->is_logged_in()) {
	header('Location: login.php');
}
//show message from add / edit page
if (isset($_GET['deluser'])) {

	//if user id is 1 ignore
	if ($_GET['deluser'] != '1') {

		$stmt = $db->prepare('DELETE FROM crazyguitar_members WHERE memberID = :memberID');
		$stmt->execute(array(':memberID' => $_GET['deluser']));

		header('Location: member.php?action=deleted');
		exit;
	}
}

?>
<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Admin - Users</title>
	<link rel="icon" href="./images/icon.ico" type="image/icon type">
	<link rel="stylesheet" href="../style/normalize.css">
	<!-- <link rel="stylesheet" href="../style/main.css"> -->
	<script language="JavaScript" type="text/javascript">
		function deluser(id, title) {
			if (confirm("Are you sure you want to delete '" + title + "'")) {
				window.location.href = 'member.php?deluser=' + id;
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
				echo '<h3>User ' . $_GET['action'] . '.</h3>';
			}
			?>
			<table class="w3-table w3-bordered w3-hoverable w3-card ">
				<tr class="w3-center w3-red">
					<th class="w3-center w3-padding-16">Name</th>
					<th class="w3-center w3-padding-16">Designation</th>
					<th class="w3-center w3-padding-16">Email</th>
					<th class="w3-center w3-padding-16">display Pic</th>
					<th class="w3-center w3-padding-16">Action</th>
				</tr>
				<?php
				try {

					$stmt = $db->query('SELECT memberID, name, email , designation , disply_pic  FROM crazyguitar_members ORDER BY name');
					while ($row = $stmt->fetch()) {

						echo '<tr>';
						echo '<td>' . $row['name'] . '</td>';
						echo '<td>' . $row['designation'] . '</td>';
						echo '<td>' . $row['email'] . '</td>';
						echo '<td>' . $row['disply_pic'] . '</td>';
				?>
						<td>
							<a href="edit-member-<?php echo $row['memberID']; ?>">Edit</a>
							<?php if ($row['memberID'] != 1) { ?>| <a href="javascript:deluser('<?php echo $row['memberID']; ?>','<?php echo $row['name']; ?>')">Delete</a>
						<?php } ?>
						</td>
				<?php
						echo '</tr>';
					}
				} catch (PDOException $e) {
					echo $e->getMessage();
				}
				?>
			</table>
			<p><a class="w3-btn w3-red" href='add-member'>Add Member</a></p>
		</div>
	</div>
</body>

</html>