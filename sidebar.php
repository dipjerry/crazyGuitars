<div class="w3-col l4 side">
	<div class="w3-card w3-margin">
		<div class="w3-container w3-padding w3-red">
			<h4>Recent Songs</h4>
		</div>
		<ul class="w3-ul w3-hoverable w3-white">
			<?php
			$stmt5 = $db->query('SELECT postTitle, postSlug FROM crazyguitar_posts_seo ORDER BY postID DESC LIMIT 5');
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
		<div class="w3-container w3-padding w3-red">
			<h4>Popular Songs</h4>
		</div>
		<ul class="w3-ul w3-hoverable w3-white">
			<?php
			$stmt6 = $db->query('SELECT postTitle, postSlug FROM crazyguitar_posts_seo ORDER BY views DESC LIMIT 5');
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
	<!-- Labels / tags -->
	<div class="w3-card w3-margin">
		<div class="w3-container w3-padding w3-red">
			<h4>Genere</h4>
		</div>
		<div class="w3-container w3-white">
			<p>
				<?php
				$stmt4 = $db->query('SELECT catTitle, catSlug FROM crazyguitar_cats ORDER BY catID DESC');
				while ($row1 = $stmt4->fetch()) {
				?>
					<span class="w3-tag w3-light-black w3-small w3-margin-bottom hvr-bounce-in"><?php echo '<a itemprop="url" href="c-' . $row1['catSlug'] . '">' . $row1['catTitle'] . '</a>'; ?></span>
				<?php	}
				?>
			</p>
		</div>
	</div>
	<!-- END Introduction Menu -->

</div>


<script src="./js/jquery.sticky-kit.js"></script>
<script>
	$(function() {
		$(".side").stick_in_parent({
			offset_top: 10
		});
	});
</script>