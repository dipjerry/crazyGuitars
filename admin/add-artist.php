<?php //include config
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
	<title>Admin - Add User</title>
	<link rel="icon" href="./images/icon.ico" type="image/icon type">
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
			<?php
			include('menu.php');
			?>
			<p><a href="members.php">User Member Index</a></p>
			<h2>Add Member</h2>
			<?php
			if (isset($_POST['submit'])) {
				//Upload Image
				extract($_POST);
				$file = $_FILES['display_pic'];
				$fileName = $_FILES['display_pic']['name'];  // extract the name of the uploaded file
				$fileSize = $_FILES['display_pic']['size'];
				$fileError = $_FILES['display_pic']['error'];
				$fileType = $_FILES['display_pic']['type'];
				$fileExt = explode('.', $fileName); 	// split the name of the file in .
				$fileActualExt = strtolower(end($fileExt));
				$fileNameNew = str_replace(' ', '', $_POST['name']) . "." . $fileActualExt;
				$allowed = array('jpg', 'jpeg');
				// $bookId = rand(1000, 9999);
				if (in_array($fileActualExt, $allowed)) {
					if ($fileError === 0) {
						$fileLocation = $_SERVER['DOCUMENT_ROOT'] . '/crazyGuitars/uploads/' . $fileNameNew;
						move_uploaded_file($_FILES['display_pic']['tmp_name'], $fileLocation);
						$stmt = $db->prepare('INSERT INTO crazyguitar_artist (name,designation,email,about, disply_pic) VALUES (:name, :designation,:email,:about, :display_pic)');
						$stmt->execute(array(
							':name' => $name,
							':designation' => $designation,
							':email' => $email,
							':about' => $about,
							':display_pic' => $fileNameNew
						));
						header('Location: users.php?action=added');
					} else {
						echo "Error uploading your file";
					}
				} else {
					echo "You Cannor upload files of this type";
				}
			?>
			<?php
			}
			?>
			<form action='' method='post' enctype='multipart/form-data'>
				<p><label>Name</label><br />
					<input type='text' name='name' value='<?php if (isset($error)) {
																echo $_POST['name'];
															} ?>'>
				</p>
				<p><label>Designation</label><br />
					<input type='text' name='designation' value='<?php if (isset($error)) {
																		echo $_POST['designation'];
																	} ?>'>
				</p>
				<p><label>Email</label><br />
					<input type='text' name='email' value='<?php if (isset($error)) {
																echo $_POST['email'];
															} ?>'>
				</p>
				<p><label>About</label><br />
					<textarea type='text' name='about' cols='60' rows='10' value='<?php if (isset($error)) {
																						echo $_POST['about'];
																					} ?>'></textarea>
				</p>
				<p><label>Image</label><br />
					<label>Select Book : </label>
					<!-- <input type="hidden" name="MAX_FILE_SIZE" value="30000" /> -->
					<input type="file" name='display_pic' required><br><br>
				</p>
				<p><input type='submit' name='submit' value='Add User'></p>
			</form>
		</div>
	</div>
</body>

</html>