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
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://cdn.tiny.cloud/1/92ltn95nzfq205vfh547qcolol9ltoexruk64k9xtl8qc9zz/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
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
	<script>
		function override_mce_options($initArray) {
			$opts = '*[*]';
			$initArray['valid_elements'] = $opts;
			$initArray['extended_valid_elements'] = $opts;
			return $initArray;
		}
		add_filter('tiny_mce_before_init', 'override_mce_options');
	</script>
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
			<p><a href="./">crazyguitar Admin Index</a></p>
			<h2>Edit Post</h2>
			<?php
			//if form has been submitted process it
			if (isset($_POST['submit'])) {
				extract($_POST);
				//very basic validation
				if ($postID == '') {
					$error[] = 'This post is missing a valid id!.';
				}
				if ($postTitle == '') {
					$error[] = 'Please enter the title.';
				}
				if ($postDesc == '') {
					$error[] = 'Please enter the description.';
				}
				// if ($postThumb == '') {
				// 	$error[] = 'Please enter the URL of the thumbnail.';
				// }
				if ($postCont == '') {
					$error[] = 'Please enter the content.';
				}
				if ($postKey == '') {
					$error[] = 'Please enter some Keyword.';
				}
				if (!isset($error)) {
					try {
						$postSlug = slug($postTitle);



						if (!empty($_FILES['postThumb']['tmp_name']) || is_uploaded_file($_FILES['postThumb']['tmp_name'])) {
							// Handle no image here...
							$file = $_FILES['postThumb'];
							$fileName = $_FILES['postThumb']['name'];  // extract the name of the uploaded file
							$fileSize = $_FILES['postThumb']['size'];
							$fileError = $_FILES['postThumb']['error'];
							$fileType = $_FILES['postThumb']['type'];
							$fileExt = explode('.', $fileName); 	// split the name of the file in .
							$fileActualExt = strtolower(end($fileExt));
							$fileNameNew = str_replace(' ', '', $postTitle) . "." . $fileActualExt;
							$allowed = array('jpg', 'jpeg');
							if (in_array($fileActualExt, $allowed)) {
								if ($fileError === 0) {
									$fileLocation = $_SERVER['DOCUMENT_ROOT'] . '/crazyGuitars/uploads/' . $fileNameNew;
									move_uploaded_file($_FILES['postThumb']['tmp_name'], $fileLocation);
								}
								echo $fileNameNew;
								$stmt = $db->prepare('UPDATE crazyguitar_posts_seo SET postTitle = :postTitle, postThumb = :postThumb ,youtube_link = :youtube_link ,  postSlug = :postSlug, postDesc = :postDesc, postCont = :postCont , postKey = :postKey WHERE postID = :postID');
								$stmt->execute(array(
									':postTitle' => $postTitle,
									':youtube_link' => $postYTlink,
									':postThumb' => $fileNameNew,
									':postSlug' => $postSlug,
									':postDesc' => $postDesc,
									':postCont' => $postCont,
									':postKey' => $postKey,
									':postID' => $postID
								));
							} else {
								echo "check file";
							};
						} else {
							echo "fail";
							$stmt = $db->prepare('UPDATE crazyguitar_posts_seo SET postTitle = :postTitle, youtube_link = :youtube_link ,  postSlug = :postSlug, postDesc = :postDesc , postCont = :postCont , postKey = :postKey WHERE postID = :postID');
							$stmt->execute(array(
								':postTitle' => $postTitle,
								':youtube_link' => $postYTlink,
								':postSlug' => $postSlug,
								':postDesc' => $postDesc,
								':postCont' => $postCont,
								':postKey' => $postKey,
								':postID' => $postID
							));
						}


						//delete all items with the current postID
						$stmt = $db->prepare('DELETE FROM crazyguitar_post_cats WHERE postID = :postID');
						$stmt->execute(array(':postID' => $postID));
						if (is_array($catID)) {
							foreach ($_POST['catID'] as $catID) {
								$stmt = $db->prepare('INSERT INTO crazyguitar_post_cats (postID,catID)VALUES(:postID,:catID)');
								$stmt->execute(array(
									':postID' => $postID,
									':catID' => $catID
								));
							}
						}
						//redirect to index page
						// header('Location: index.php?action=updated');
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
				$stmt = $db->prepare('SELECT postID, postTitle,postThumb, youtube_link, postDesc, postCont, postKey FROM crazyguitar_posts_seo WHERE postID = :postID');
				$stmt->execute(array(':postID' => $_GET['id']));
				$row = $stmt->fetch();
			} catch (PDOException $e) {
				echo $e->getMessage();
			}
			?>
			<form action='' method='post' enctype='multipart/form-data'>
				<input type='hidden' name='postID' value='<?php echo $row['postID']; ?>'>
				<p><label>Title</label><br />
					<input type='text' name='postTitle' value='<?php echo $row['postTitle']; ?>'>
				</p>
				<p><label>Select a file</label><br />
					<input type='file' name='postThumb' placeholder='Enter image url' value='<?php echo $row['postThumb']; ?>'>
				</p>
				<p><label>Youtube Link</label><br />
					<input type='text' name='postYTlink' placeholder='Enter Youtube Link' value='<?php echo $row['youtube_link']; ?>'>
				</p>
				<p><label>Description</label><br />
					<textarea name='postDesc' cols='60' rows='10'><?php echo $row['postDesc']; ?></textarea>
				</p>
				<p><label>Content</label><br />
					<textarea name='postCont' cols='60' rows='10'><?php echo $row['postCont']; ?></textarea>
				</p>
				<fieldset>
					<legend>genere</legend>
					<?php
					$stmt2 = $db->query('SELECT catID, catTitle FROM crazyguitar_cats ORDER BY catTitle');
					while ($row2 = $stmt2->fetch()) {
						$stmt3 = $db->prepare('SELECT catID FROM crazyguitar_post_cats WHERE catID = :catID AND postID = :postID');
						$stmt3->execute(array(':catID' => $row2['catID'], ':postID' => $row['postID']));
						$row3 = $stmt3->fetch();
						if ($row3) {
							if ($row3['catID'] == $row2['catID']) {
								$checked = 'checked=checked';
							} else {
								$checked = null;
							}
						}
						echo "<input type='checkbox' name='catID[]' value='" . $row2['catID'] . "' $checked> " . $row2['catTitle'] . "<br />";
					}
					?>
				</fieldset>
				<fieldset>
					<legend>artist</legend>
					<?php
					$stmt2 = $db->query('SELECT memberID, name FROM crazyguitar_artist ORDER BY name');
					while ($row2 = $stmt2->fetch()) {
						$stmt3 = $db->prepare('SELECT artistID FROM crazyguitar_post_artist WHERE artistID = :artistID AND postID = :postID');
						$stmt3->execute(array(':artistID' => $row2['memberID'], ':postID' => $row['postID']));
						$row3 = $stmt3->fetch();
						if ($row3) {
							if ($row3['artistID'] == $row2['memberID']) {
								$checked = 'checked=checked';
							} else {
								$checked = null;
							}
						}
						echo "<input type='checkbox' name='catID[]' value='" . $row2['memberID'] . "' $checked> " . $row2['name'] . "<br />";
					}
					?>
				</fieldset>
				<p><label>Keywords (Seperate by ',')</label><br />
					<input type='text' name='postKey' id='postKey' value='<?php echo $row['postKey']; ?>' style="width:100%">
				</p>
				<p class='view_MK'>1</p>
				<p><input type='submit' name='submit' value='Update'></p>
				<script>
					$("#postKey").keyup(function() {
						$(".view_MK").text($("#postKey").val());
					});
				</script>
			</form>
		</div>
	</div>
</body>

</html>