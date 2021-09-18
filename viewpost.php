<?php 
require('includes/config.php');
require_once('classes/breadCrumb.php');
$stmt = $db->prepare('SELECT postID, postTitle,postDesc,postThumb, postCont, postKey,  postDate, postSlug, author, views FROM blog_posts_seo WHERE postSlug = :postSlug');
$stmt->execute(array(':postSlug' => $_GET['id']));
$row = $stmt->fetch();
//if post does not exists redirect user.
if ($row['postID'] == '') {
	header('Location: ./');
	exit;
}
$actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CoderRat - <?php echo $row['postTitle']; ?></title>
	<meta name="description" content="<?php echo trim(strip_tags($row['postDesc']));?>">
	<meta property="og:title" content="<?php echo $row['postTitle']; ?>" />
	<meta property="og:type" content="website" />
	<link rel="stylesheet" href="style/normalize.css">
	<meta name="keywords" content="<?php echo $row['postKey']; ?>">
	<meta  property="og:description" content="<?php echo trim(strip_tags($row['postDesc']));?>">
	<meta  property="og:title" content="CoderRat - <?php echo $row['postTitle']; ?>">
	<meta property="og:url" content="<?php echo $actual_link; ?>">
    <meta property="og:site_name" content="Coder Rat">
    <meta  property="og:image" content="<?php echo $row['postThumb'] ?>">
    <meta property="og:image:alt" content="Coder rat">
	<meta property="og:updated_time" content="<?php echo date($row['postDate']); ?>" />
    <link rel="canonical" href="<?php echo $actual_link; ?>" />
	<link rel="icon" href="./images/icon.ico" type="image/icon type">
	<link href="images/apple-touch-icon.png" rel="apple-touch-icon" />
	<link rel="stylesheet" href="style/comments.css">
	<link rel="stylesheet" href="style/urls.css">
	<link rel="stylesheet" href="style/prism.css">
	<link rel="stylesheet" href="style/animation.css" media="print" onload="this.media='all'; this.onload=null;">
	<link rel="stylesheet" href="style/ui.css">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="js/prism.js"></script>
	<script src="https://cdn.tiny.cloud/1/92ltn95nzfq205vfh547qcolol9ltoexruk64k9xtl8qc9zz/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

	<script>
    tinymce.init({
        selector: "textarea",
        plugins: ["codesample, emoticons"],
        menubar: false,
        statusbar: false,
        toolbar: "bold italic underline| alignleft aligncenter alignright alignjustify | bullist numlist | code codesample | emoticons",
         formats: {
        bold : {inline : 'b' },  
        italic : {inline : 'i' },
        underline : {inline : 'u'}
    }
    });
</script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-YTCEEYGM9F"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-YTCEEYGM9F');
</script>
</head>

<body itemscope itemtype="http://schema.org/Article">
    <meta itemprop="datePublished" content="<?php echo date($row['postDate']); ?>">
					<meta itemprop="inLanguage" content="English">
					<meta itemprop="publisher" content="CoderRat">
					<meta itemprop="description" content="<?php echo trim(strip_tags($row['postDesc']));?>">
	
	<?php require('nav.php'); ?>

<?php $counter =  (++$row['views']);
	$stmtC = $db->prepare('UPDATE blog_posts_seo SET  views = :counter WHERE postSlug = :postSlug');
	$stmtC->execute(array(
		':counter' => $counter,
		':postSlug' =>  $_GET['id']
	));
	?>
	<div class="w3-row" style="margin-top:3%;">
		<!-- Blog entries -->
		<div class="w3-col l8 s12">
			<div class="w3-card-4 w3-margin w3-white">
			    <p itemscope itemtype="https://schema.org/BreadcrumbList" class="breadCrumb-p"><?=breadcrumbs() ?><meta itemprop="name" content="<?php echo $row['postTitle']; ?>" /></p>
				<?php if ($row['postThumb'] != '') { ?>
					<img itemprop="image" src="<?php echo $row['postThumb'] ?>" alt="<?php echo $row['postThumb'] ?>" style="width:100%">
				<?php } ?>
				<div class="w3-container">
					
					<?php
					echo '<div>';
					?>
					<h1 itemprop="headline"><?php echo  $row['postTitle']; ?> </h1>
					<?php echo '<p>Posted on ' . date('jS M Y H:i:s', strtotime($row['postDate'])) . ' in ';
					$stmt2 = $db->prepare('SELECT catTitle, catSlug	FROM blog_cats, blog_post_cats WHERE blog_cats.catID = blog_post_cats.catID AND blog_post_cats.postID = :postID');
					$stmt2->execute(array(':postID' => $row['postID']));
					$catRow = $stmt2->fetchAll(PDO::FETCH_ASSOC);
					$links = array();
					foreach ($catRow as $cat) {
						$links[] = "<span class='w3-tag w3-light-black w3-small w3-margin-bottom hvr-bounce-in'><a href='c-" . $cat['catSlug'] . "'>" . $cat['catTitle'] . "</a></span>";
					}
					echo implode("<b> , </b>", $links);
					echo '</p>';
					echo '<p>' . $row['postCont'] . '</p>';
					echo '</div>';
					$post_author = $row['author'];
				
					?>
				</div>
			</div>
			<div class="w3-card-4 w3-margin w3-amber">
				<div class="w3-container w3-center share_buttons">
					<?php
					$baseUrl = "https://coderrat.xyz/";
					$slug = $row['postSlug'];
					$hash = $new_str = str_replace(' ', '', $row['postKey']);
					?>
					<ul>
						<p><strong>Share on <i class="fa fa-share-alt" aria-hidden="true"></i>
							</strong></p>
						<span>
							<a target="_blank" href="http://www.facebook.com/sharer.php?u=<?php echo $baseUrl . $slug; ?>">
								<i class="fa fa-facebook-f fa_custom-f hvr-wobble-vertical" style="font-size:24px"></i>
							</a>
						</span>
						<span>
							<a target="_blank" href="http://twitter.com/share?text=Visit the link &url=<?php echo $baseUrl . $slug; ?>&hashtags=<?php echo $hash  ?> ">
								<i class="fa fa-twitter fa_custom-t hvr-wobble-vertical " style="font-size:24px"></i>
							</a>
						</span>
						<span>
							<a target="_blank" href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $baseUrl . $slug; ?>">
								<i class="fa fa-linkedin fa_custom-l hvr-wobble-vertical" aria-hidden="true" style="font-size:24px"></i>
							</a>
						</span>
						<span>
								<input id="share_link" value="<?php echo $baseUrl . $slug ?>" hidden disabled>
							<i onclick='copyToClipboard()' class="fa fa-files-o fa_custom-e hvr-wobble-vertical copy_button" aria-hidden="true" style="font-size:24px"></i>

						</span>
					</ul>
				</div>
				<script>
					function copyToClipboard() 
					{
						var link = document.getElementById("share_link");
						link.select();
						link.setSelectionRange(0, 99999);
						document.execCommand("copy");
						link.remove();
					}
				</script>
				<div class="w3-container ">
					<?php require('comment.php'); ?>
				</div>
			</div>
		</div>
		<?php $sidebar = 'viewPost';
		require('sidebar.php'); ?>
	</div>
	</div>
	 <div class="w3-container w3-amber w3-margin-top">
<?php require('./suggestion.php'); ?>
  </div>
	<?php
	require('footer.php'); ?>
</body>
</html>