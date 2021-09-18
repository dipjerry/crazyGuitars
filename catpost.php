<?php require('includes/config.php');
$stmt = $db->prepare('SELECT catID,catTitle FROM blog_cats WHERE catSlug = :catSlug');
$stmt->execute(array(':catSlug' => $_GET['id']));
$row = $stmt->fetch();
$cat_id = $row['catID'];
$stmt0 = $db->prepare('SELECT id	FROM blog_post_cats WHERE catID = :catID');
$stmt0->execute(array(':catID' => $cat_id));
$count = $stmt0->rowCount();
if ($count == 0) {
	header('Location: ./');
	exit;
}
//if post does not exists redirect user.
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Blog - <?php echo $row['catTitle']; ?></title>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="style/urls.css">
	<link rel="stylesheet" href="style/ui.css">
	<link rel="stylesheet" href="style/animation.css">
	<link rel="icon" href="./images/icon.ico" type="image/icon type">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="js/jquery-3.2.1.min.js"></script>
	<script data-ad-client="ca-pub-5610815016922898" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	<style>
		body,
		h1,
		h2,
		h3,
		h4,
		h5,
		a,
		a:active {
			font-family: "Raleway", sans-serif
		}
	</style>
</head>

<body class="w3-light-grey">
	<div class="w3-content" style="max-width:1400px">
		<?php require('nav.php'); ?>
		<br>
		<!-- Grid -->
		<header class="w3-container w3-center w3-padding-32">
			<!-- <h1><b>MY BLOG</b></h1> -->
			<p>
				<h3>Welcome to the blog of <span class="w3-tag">
						<?php echo $row['catTitle'];
						?></h3>
				</span>
			</p>
		</header>

		<div class="w3-row">
			<!-- Blog entries -->
			<div class="w3-col l8 s12">
				<!-- Blog entry -->
				<?php
				try {
					$pages = new Paginator('5', 'p');
					$stmt = $db->prepare('SELECT blog_posts_seo.postID FROM blog_posts_seo, blog_post_cats WHERE blog_posts_seo.postID = blog_post_cats.postID AND blog_post_cats.catID = :catID');
					$stmt->execute(array(':catID' => $row['catID']));
					//pass number of records to
					$pages->set_total($stmt->rowCount());
					$stmt = $db->prepare('
							SELECT 
								blog_posts_seo.postID, blog_posts_seo.postTitle,blog_posts_seo.postThumb, blog_posts_seo.postSlug, blog_posts_seo.postDesc,blog_posts_seo.views, blog_posts_seo.postDate 
							FROM 
								blog_posts_seo,
								blog_post_cats
							WHERE
								 blog_posts_seo.postID = blog_post_cats.postID
								 AND blog_post_cats.catID = :catID
							ORDER BY 
								postID DESC
							' . $pages->get_limit());
					$stmt->execute(array(':catID' => $row['catID']));
					while ($row = $stmt->fetch()) {
				?>
						<div class="w3-card-4 w3-margin w3-white">
							<?php if ($row['postThumb'] != '') { ?>
								<img src="<?php echo $row['postThumb'] ?>" alt="Nature" style="width:100%">
							<?php } ?>
							<div class="w3-container">
								<h3><b><?php echo '<h1><a href="' . $row['postSlug'] . '">' . $row['postTitle'] . '</a></h1>'; ?></b></h3>
								<h5>Title description, <span class="w3-opacity">
										<?php echo '<p>Posted on ' . date('jS M Y H:i:s', strtotime($row['postDate'])) . ' in ';
										$stmt2 = $db->prepare('SELECT catTitle, catSlug	FROM blog_cats, blog_post_cats WHERE blog_cats.catID = blog_post_cats.catID AND blog_post_cats.postID = :postID');
										$stmt2->execute(array(':postID' => $row['postID']));
										$catRow = $stmt2->fetchAll(PDO::FETCH_ASSOC);
										$links = array();
										foreach ($catRow as $cat) {
											$links[] = "<span class='w3-tag w3-light-black w3-small w3-margin-bottom'><a href='c-" . $cat['catSlug'] . "'>" . $cat['catTitle'] . "</a></span>";
										}
										echo implode("<b> ,</b> ", $links);
										echo '</p>'; ?>
									</span>
								</h5>
							</div>
							<?php
							?>
							<div class="w3-container">
								<?php echo '<p>' . $row['postDesc'] . '</p>'; ?>
							<div class="w3-row">
                  <div class="w3-col s7">
                    <b>
                      <p><button onclick="location.href='<?php echo $row['postSlug'] ?>'" class="w3-button w3-padding-large w3-white w3-border">Read More</a></button></p>
                    </b>
                  </div>
                  <div class="w3-col s5">
                      <p>
                    <span class="w3-padding-large w3-right" style="font-size: 16px; color:grey"><i class="fa fa-eye" aria-hidden="true"></i> <?php echo $row['views'] ?> <i class="fa fa-comments"></i>
                        <?php
                          $p_id = $row['postID'];
                          $stmt3 = $db->prepare('SELECT comment_id	FROM tbl_comment WHERE post_id = :postID');
                          $stmt3->execute(array(':postID' => $p_id));
                          $comment_count = $stmt3->rowCount();

                          echo $comment_count;
                          ?>
                        </span></p>
                  </div>
                </div>
							</div>
						</div>
						<div class="w3-card-4 w3-margin w3-white">
							<div class="w3-container">
								advt
							</div>
						</div>
				<?php
					}
					echo $pages->page_links();
				} catch (PDOException $e) {
					echo $e->getMessage();
				}
				?>
			</div>
			<?php $sidebar = 'author';
			require('sidebar.php'); ?>
		</div><br>
	</div>
	<div class="w3-container w3-dark-grey w3-padding-32 w3-margin-top w3-center">
		advt	
	</div>
	<?php
	require('footer.php'); ?>
</body>

</html>