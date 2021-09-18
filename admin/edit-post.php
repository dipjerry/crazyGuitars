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
	<script src="https://cdn.tiny.cloud/1/92ltn95nzfq205vfh547qcolol9ltoexruk64k9xtl8qc9zz/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
		tinymce.init({
			selector: "textarea",
			plugins: [
				"advlist autolink lists link image charmap print preview anchor",
				"searchreplace visualblocks  fullscreen fullpage",
				"insertdatetime media table contextmenu paste",
				"code codesample visualchars"
			],
			toolbar: "fullpage | insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | codesample | visualchars | bullist numlist outdent indent | link image | code",
		extended_valid_elements: "script[src|async|defer|type|charset]",
			extended_valid_elements : "img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name]",
			extended_valid_elements : "@[itemtype|itemscope|itemprop|id|class|style|title|dir<ltr?rtl|lang|xml::lang|onclick|ondblclick|onmousedown|onmouseup|onmouseover|onmousemove|onmouseout|onkeypress|onkeydown|onkeyup]",
		entities : '160,nbsp,162,cent,8364,euro,163,pound',
		fix_list_elements : true,
		verify_html : false,
			image_caption: true,
		image_advtab: true,
			 image_class_list: [
    {title: 'None', value: ''},
    {title: 'Responsive-mob', value: 'w3-image col m6 s12'},
    {title: 'Responsive', value: 'w3-image'}
  ],
  link_class_list: [
    {title: 'None', value: ''},
    {title: 'black', value: 'w3-button w3-black'},
    {title: 'red', value: 'w3-button w3-red'},
    {title: 'green', value: 'w3-button w3-green'},
    {title: 'blue', value: 'w3-button w3-blue'}
  ],
  formats: {
        bold : {inline : 'b' },  
        italic : {inline : 'i' },
        underline : {inline : 'u'}
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
	<script src="../js/jquery-3.2.1.min.js"></script>
</head>

<body>

	<div id="wrapper">

		<?php include('menu.php'); ?>
		<p><a href="./">Blog Admin Index</a></p>

		<h2>Edit Post</h2>


		<?php

		//if form has been submitted process it
		if (isset($_POST['submit'])) {

			//collect form data
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

					//insert into database
					$stmt = $db->prepare('UPDATE blog_posts_seo SET postTitle = :postTitle, postSlug = :postSlug, postDesc = :postDesc,postThumb = :postThumb , postCont = :postCont , postKey = :postKey WHERE postID = :postID');
					$stmt->execute(array(
						':postTitle' => $postTitle,
						':postSlug' => $postSlug,
						':postDesc' => $postDesc,
						':postThumb' => $postThumb,
						':postCont' => $postCont,
						':postKey' => $postKey,
						':postID' => $postID
					));

					//delete all items with the current postID
					$stmt = $db->prepare('DELETE FROM blog_post_cats WHERE postID = :postID');
					$stmt->execute(array(':postID' => $postID));

					if (is_array($catID)) {
						foreach ($_POST['catID'] as $catID) {
							$stmt = $db->prepare('INSERT INTO blog_post_cats (postID,catID)VALUES(:postID,:catID)');
							$stmt->execute(array(
								':postID' => $postID,
								':catID' => $catID
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

		try {

			$stmt = $db->prepare('SELECT postID, postTitle, postDesc, postCont, postKey FROM blog_posts_seo WHERE postID = :postID');
			$stmt->execute(array(':postID' => $_GET['id']));
			$row = $stmt->fetch();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		?>

		<form action='' method='post'>
			<input type='hidden' name='postID' value='<?php echo $row['postID']; ?>'>

			<p><label>Title</label><br />
				<input type='text' name='postTitle' value='<?php echo $row['postTitle']; ?>'></p>
			<p><label>Thumbnail</label><br />
				<input type='text' name='postThumb' placeholder='Enter image url' value='<?php if (isset($error)) {
																								echo $_POST['postThumb'];
																							} ?>'></p>

			<p><label>Description</label><br />
				<textarea name='postDesc' cols='60' rows='10'><?php echo $row['postDesc']; ?></textarea></p>

			<p><label>Content</label><br />
				<textarea name='postCont' cols='60' rows='10'><?php echo $row['postCont']; ?></textarea></p>

			<fieldset>
				<legend>Categories</legend>

				<?php

				$stmt2 = $db->query('SELECT catID, catTitle FROM blog_cats ORDER BY catTitle');
				while ($row2 = $stmt2->fetch()) {

					$stmt3 = $db->prepare('SELECT catID FROM blog_post_cats WHERE catID = :catID AND postID = :postID');
					$stmt3->execute(array(':catID' => $row2['catID'], ':postID' => $row['postID']));
					$row3 = $stmt3->fetch();

					if ($row3['catID'] == $row2['catID']) {
						$checked = 'checked=checked';
					} else {
						$checked = null;
					}

					echo "<input type='checkbox' name='catID[]' value='" . $row2['catID'] . "' $checked> " . $row2['catTitle'] . "<br />";
				}

				?>

			</fieldset>
			<p><label>Keywords (Seperate by ',')</label><br />
				<input type='text' name='postKey' id='postKey' value='<?php echo $row['postKey']; ?>' style="width:100%"></p>
			<p class='view_MK'>1</p>
			<p><input type='submit' name='submit' value='Update'></p>

			<script>
				$("#postKey").keyup(function() {
					$(".view_MK").text($("#postKey").val());
				});
			</script>



		</form>

	</div>

</body>

</html>