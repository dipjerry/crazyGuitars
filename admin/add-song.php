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
	<title>Admin - Add Post</title>
	<link rel="icon" href="../images/icon.ico" type="image/icon type">
	<link rel="stylesheet" href="../style/normalize.css">

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://cdn.tiny.cloud/1/92ltn95nzfq205vfh547qcolol9ltoexruk64k9xtl8qc9zz/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
	<!-- <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> -->
	<link rel="stylesheet" href="../style/w3.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> -->
	<script src="../js/jquery-3.2.1.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/simple-parallax-js@5.5.1/dist/simpleParallax.min.js"></script>
	<script>
		tinymce.init({
			selector: "textarea",
			plugins: [
				"advlist autolink lists link image charmap print preview anchor",
				"searchreplace visualblocks  fullscreen fullpage",
				"insertdatetime media table contextmenu paste",
			],
			toolbar: "fullpage | insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | codesample | bullist numlist outdent indent | link image | code",
			extended_valid_elements: "script[src|async|defer|type|charset]",
			extended_valid_elements: "img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name]",
			extended_valid_elements: "@[itemtype|itemscope|itemprop|id|class|style|title|dir<ltr?rtl|lang|xml::lang|onclick|ondblclick|onmousedown|onmouseup|onmouseover|onmousemove|onmouseout|onkeypress|onkeydown|onkeyup]",
			verify_html: false,
			image_caption: true,
			image_advtab: true,
			image_class_list: [{
					title: 'None',
					value: ''
				},
				{
					title: 'Responsive-mob',
					value: 'w3-image col m6 s12'
				},
				{
					title: 'Responsive',
					value: 'w3-image'
				}
			],
			formats: {
				bold: {
					inline: 'b'
				},
				italic: {
					inline: 'i'
				},
				underline: {
					inline: 'u'
				}
			},
			min_height: 500
		});
	</script>
</head>

<body>
	<div class="w3-content  w3-padding-64" style="max-width:max-content">
		<div id="w3-display-container w3-padding-64">
			<?php include('menu.php'); ?>
			<p><a href="./">crazyguitar Admin Index</a></p>
			<h2>Add Post</h2>
			<?php
			//if form has been submitted process it
			if (isset($_POST['submit'])) {
				//collect form data

				extract($_POST);
				$file = $_FILES['postThumb'];
				$fileName = $_FILES['postThumb']['name'];  // extract the name of the uploaded file
				$fileSize = $_FILES['postThumb']['size'];
				$fileError = $_FILES['postThumb']['error'];
				$fileType = $_FILES['postThumb']['type'];
				$fileExt = explode('.', $fileName); 	// split the name of the file in .
				$fileActualExt = strtolower(end($fileExt));
				$fileNameNew = str_replace(' ', '', $postTitle) . "." . $fileActualExt;
				$allowed = array('jpg', 'jpeg');
				//very basic validation
				if ($postTitle == '') {
					$error[] = 'Please enter the Sone Name.';
				}
				if ($postYTlink == '') {
					$error[] = 'Please enter the Youtube Link.';
				}
				if ($postCont == '') {
					$error[] = 'Please enter the content.';
				}
				if ($postKey == '') {
					$error[] = 'Please enter the content.';
				}
				if (!isset($error)) {


					if (in_array($fileActualExt, $allowed)) {
						if ($fileError === 0) {
							$fileLocation = $_SERVER['DOCUMENT_ROOT'] . '/crazyGuitars/uploads/' . $fileNameNew;
							move_uploaded_file($_FILES['postThumb']['tmp_name'], $fileLocation);

							$stmt0 = $db->prepare('SELECT  memberID FROM crazyguitar_users WHERE username = :author');
							$stmt0->execute(array(':author' => $_SESSION['username']));
							$row0 = $stmt0->fetch();
							$postSlug = slug($postTitle);
							//insert into database
							$stmt = $db->prepare('INSERT INTO crazyguitar_posts_seo (postTitle,postSlug,postThumb,postDesc,postCont,postKey,releaseDate, author,views, postDate) VALUES (:postTitle, :postSlug,:postThumb, :postYTlink, :postCont,:postKey,:releasedate	,:author,:views, :postDate)');
							$stmt->execute(array(
								':postTitle' => $postTitle,
								':postSlug' => $postSlug,
								':postThumb' => $fileNameNew,
								':postYTlink' => $postYTlink,
								':postCont' => $postCont,
								':postKey' => $postKey,
								':releasedate' => $releasedate,
								':author' => $row0['memberID'],
								':views' => '0',
								':postDate' => date('Y-m-d H:i:s'),
							));
							$postID = $db->lastInsertId();
							//add genere
							if (is_array($catID)) {
								foreach ($_POST['catID'] as $catID) {
									$stmt = $db->prepare('INSERT INTO crazyguitar_post_cats (postID,catID)VALUES(:postID,:catID)');
									$stmt->execute(array(
										':postID' => $postID,
										':catID' => $catID
									));
								}
							}
							// add album
							if (is_array($memberID)) {
								foreach ($_POST['memberID'] as $memberID) {
									$stmt = $db->prepare('INSERT INTO crazyguitar_post_artist (postID,artistID)VALUES(:postID,:catID)');
									$stmt->execute(array(
										':postID' => $postID,
										':catID' => $memberID
									));
								}
							}
							header('Location: index.php?action=added');
							exit;
						} else {
							echo "Error uploading your file";
						}
					} else {
						echo "You Cannor upload files of this type";
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
			<form action='' method='post' enctype='multipart/form-data'>
				<p><label>Song Name</label><br />
					<input type='text' name='postTitle' placeholder='crazyguitar title' value='<?php if (isset($error)) {
																									echo $_POST['postTitle'];
																								} ?>'>
				</p>
				<p>
					<label>Thumbnail</label>

				<p><label>Select a file</label><br />
					<input type='file' name='postThumb' placeholder='Enter image url' value='<?php if (isset($error)) {
																									echo $_POST['postThumb'];
																								} ?>'>
				</p>
				<p><label>Youtube Link</label><br />
					<input type='text' name='postYTlink' placeholder='Enter Youtube Link' value='<?php if (isset($error)) {
																										echo $_POST['postYTlink'];
																									} ?>'>

				</p>

				<p><label>Release Date</label><br />
					<input type='date' name='releasedate'>
				</p>
				<p><label>Content</label><br />
					<textarea name='postCont' cols='60' rows='10' placeholder='crazyguitar Content'><?php if (isset($error)) {
																										echo $_POST['postCont'];
																									} ?></textarea>
				</p>
				<fieldset>
					<legend>genere</legend>
					<?php
					$stmt2 = $db->query('SELECT catID, catTitle FROM crazyguitar_cats ORDER BY catTitle');
					while ($row2 = $stmt2->fetch()) {
						echo "<input type='checkbox' name='catID[]' value='" . $row2['catID'] . "' > " . $row2['catTitle'] . "<br />";
					}
					?>
				</fieldset>
				<fieldset>
					<legend>artist</legend>
					<?php
					$stmt2 = $db->query('SELECT memberID, name FROM crazyguitar_artist ORDER BY name');
					while ($row2 = $stmt2->fetch()) {
						echo "<input type='checkbox' name='memberID[]' value='" . $row2['memberID'] . "' > " . $row2['name'] . "<br />";
					}
					?>
				</fieldset>
				<p><label>Keywords (Seperate each keywords by ',')</label><br />
					<input type='text' name='postKey' id='postKey' value='<?php if (isset($error)) {
																				echo $_POST['postKey'];
																			} ?>' style="width:100%">
				</p>
				<p class="view_MK"></p>
				<script>
					$("#postKey").keyup(function() {
						$(".view_MK").text($("#postKey").val());
					});
				</script>
				<p><input type='submit' name='submit' value='Submit' class="w3-btn w3-red"></p>
			</form>
		</div>
	</div>
</body>

</html>