	     <div class="w3-padding w3-black">
			<h4>Similar Posts</h4>
		</div>
 <?php
$query1 = $db->prepare('SELECT groupID FROM blog_post_group WHERE postID = :postID');
$query1->execute(array(
    ':postID' => $row['postID']
));
$qry1 = $query1->fetch();
$query2 = $db->prepare('SELECT groupSlug FROM blog_group WHERE groupID = :groupID');
$query2->execute(array(
    ':groupID' => $qry1['groupID']
));
$qry2 = $query2->fetch();
$stmt8 = $db->prepare('SELECT groupID,groupTitle FROM blog_group WHERE groupSlug = :groupSlug');
$stmt8->execute(array(
    ':groupSlug' => $qry2['groupSlug']
));

$row7 = $stmt8->fetch();
$group_id = $row7['groupID'];
$stmt7 = $db->prepare('SELECT id FROM blog_post_group WHERE groupID = :groupID');
$stmt7->execute(array(
    ':groupID' => $group_id
));
$count = $stmt7->rowCount();
if ($count == 0) {
    echo ("No Suggeston Available");
}
?>
<div class="w3-content" style="max-width:1400px">
    <div class="w3-row">
        <!-- Blog entries -->
        <?php
        $stmt6 = $db->prepare('SELECT blog_posts_seo.postID FROM blog_posts_seo, blog_post_group WHERE blog_posts_seo.postID = blog_post_group.postID AND blog_post_group.groupID = :groupID');
        $stmt6->execute(array(
            ':groupID' => $row7['groupID']
        ));
        $stmt9 = $db->prepare('
							SELECT 
								blog_posts_seo.postID, blog_posts_seo.postTitle, blog_posts_seo.postSlug,blog_posts_seo.views, blog_posts_seo.postDate 
							FROM 
								blog_posts_seo,
								blog_post_group
							WHERE
								 blog_posts_seo.postID = blog_post_group.postID
								 AND blog_post_group.groupID = :groupID
						ORDER BY RAND() LIMIT 6
							
							');
        $stmt9->execute(array(
            ':groupID' => $row7['groupID']
        ));
        ?>
        <div class="w3-row">
                    <?php
                    $i = 1;
        while ($row9 = $stmt9->fetch()) {
    
        ?>                

            <div class=" w3-col m6 s12">
                <div class="w3-card-4 w3-margin w3-white">
                    <div class="w3-row">
                        <div class="w3-col s1 w3-center w3-card-4 w3-pink">
                            <div style="height:fit-content;padding-top: 75%;padding-bottom: 60%;font-size:24px;display:block" class="w3-cursive "><span class="w3-opacity"><?php echo $i; ?></span></div>
                        </div>
                        <div class="w3-col s11">
                            <div class="w3-container"><h3><?php echo '<a href="' . $row9['postSlug'] . '">' . $row9['postTitle'] . '</a>'; ?></h3></div>
                            <!--<div class="w3-row">-->
                            <!--    <div class="w3-col s6">-->
                                        <span class="w3-padding-large w3-right" style="font-size: 16px; color:grey">
                                            <i class="fa fa-eye" aria-hidden="true"></i> 
                                        <?php echo $row9['views'] ?> 
                                        <i class="fa fa-comments"></i>
                                            <?php
                                            $p_id = $row9['postID'];
                                            $stmt3 = $db->prepare('SELECT comment_id	FROM tbl_comment WHERE post_id = :postID');
                                            $stmt3->execute(array(
                                                ':postID' => $p_id
                                            ));
                                            $comment_count = $stmt3->rowCount();
                                            echo $comment_count;
                                            ?>
                                        </span>
                          <!--      </div>-->
                          <!--</div>-->
                        </div>
                    </div>
                </div>
            </div>
        <?php
        $i++;
        }
        ?>
        </div>
    </div>
</div>