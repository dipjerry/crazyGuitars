<div class="w3-col l4 side">
	<div class="w3-card w3-margin">
		<div class="w3-container w3-padding w3-amber">
			<h4>Recent Posts</h4>
		</div>
		<ul class="w3-ul w3-hoverable w3-white">
			<?php
			$stmt5 = $db->query('SELECT postTitle, postSlug FROM blog_posts_seo ORDER BY postID DESC LIMIT 5');
			while ($row5 = $stmt5->fetch()) { ?>
				<li onclick="location.href='<?php echo $row5['postSlug'] ?>'" itemprop="url" class="w3-padding-16 clickble-li">
					<span class="w3-large">
						<?php
						echo $row5['postTitle'];
						?>
					</span>
				</li>
			<?php }
			?>
		</ul>
	</div>
	<div class="w3-card w3-margin">
		<div class="w3-container w3-padding w3-amber">
			<h4>Popular Posts</h4>
		</div>
		<ul class="w3-ul w3-hoverable w3-white">
			<?php
			$stmt6 = $db->query('SELECT postTitle, postSlug FROM blog_posts_seo ORDER BY views DESC LIMIT 5');
			while ($row6 = $stmt6->fetch()) { ?>
				<li onclick="location.href='<?php echo $row6['postSlug'] ?>'" itemprop="url" class="w3-padding-16 clickble-li">
					<span class="w3-large">
						<?php
						echo $row6['postTitle'];
						?>
					</span>
				</li>
			<?php }
			?>
		</ul>
	</div>
	<!-- advt -->
	<div class=" w3-card w3-margin w3-margin-top">
		<div class="w3-container w3-white">
<!--		<amp-ad width="100vw" height="320"-->
<!--     type="adsense"-->
<!--     data-ad-client="ca-pub-5610815016922898"-->
<!--     data-ad-slot="3429865543"-->
<!--     data-auto-format="rspv"-->
<!--     data-full-width="">-->
<!--  <div overflow=""></div>-->
<!--</amp-ad>-->
		</div>
	</div>
	<!-- Labels / tags -->
	<div class="w3-card w3-margin">
		<div class="w3-container w3-padding w3-amber">
			<h4>Tags</h4>
		</div>
		<div class="w3-container w3-white">
			<p>
				<?php
				$stmt4 = $db->query('SELECT catTitle, catSlug FROM blog_cats ORDER BY catID DESC');
				while ($row1 = $stmt4->fetch()) {
				?>
					<span class="w3-tag w3-light-black w3-small w3-margin-bottom hvr-bounce-in"><?php echo '<a itemprop="url" href="c-' . $row1['catSlug'] . '">' . $row1['catTitle'] . '</a>'; ?></span>
				<?php	}
				?>
			</p>
		</div>
	</div>
	<!-- END Introduction Menu -->
	<div class="w3-card w3-margin w3-margin-top">
		<div class="w3-container w3-white">
<!--		<amp-ad width="100vw" height="320"-->
<!--     type="adsense"-->
<!--     data-ad-client="ca-pub-5610815016922898"-->
<!--     data-ad-slot="3429865543"-->
<!--     data-auto-format="rspv"-->
<!--     data-full-width="">-->
<!--  <div overflow=""></div>-->
<!--</amp-ad>-->
		</div>
	</div>
	<div class="w3-card w3-margin w3-margin-top">

	<?php if ($sidebar == 'viewPost') { ?>

			<?php 
			$stmt6 = $db->prepare('SELECT  username, about ,disply_pic FROM blog_members WHERE memberID = :mID');
			$stmt6->execute(array(':mID' => $post_author));
			$row6 = $stmt6->fetch();
			if ($row6['disply_pic'] != '') {
			?>
				<img itemprop="image" src="<?php echo $row6['disply_pic'] ?>" alt="author" style="width:100%">
			<?php } ?>
			<div class=" w3-container w3-white">
			    <meta name="author" content="<?php echo $row6['username']; ?>">
				<h4 itemprop="author"><b><?php echo $row6['username']; ?></b></h4>
				<p><?php echo $row6['about']; ?> </p>
			</div>
		<?php	} else { ?>
			<img itemprop="image" src="images/coderrat.jpg" class="w3-image" alt="logo">
			<div class="w3-container w3-white">
			    <meta name="author" content="Coder Rat">
				<h4 itemprop="author publisher"><b>
						Coder Rat </b></h4>
				<p>Providing code snippet</p>
			</div>

		<?php	}
		?>

	</div>
	<div class="w3-card w3-margin w3-margin-top">
		<div class="w3-container w3-white">
<!--		<amp-ad width="100vw" height="320"-->
<!--     type="adsense"-->
<!--     data-ad-client="ca-pub-5610815016922898"-->
<!--     data-ad-slot="3429865543"-->
<!--     data-auto-format="rspv"-->
<!--     data-full-width="">-->
<!--  <div overflow=""></div>-->
<!--</amp-ad>-->
		</div>
	</div>
</div>


<script src="./js/jquery.sticky-kit.js"></script>
<script>
	$(function() {
		$(".side").stick_in_parent({
			offset_top: 10
		});
	});
</script>