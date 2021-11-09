<?php require('includes/config.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Crazy Guitars - Code Snippet & Practical Notes </title>
  <meta charset="UTF-8">
  <meta name="description" itemprop="description" content="Free coding and technology related crazyguitar and tutorials. Practicals notes with Programs , Algorithm and output">
  <meta property="og:description" content="Free coding and technology related crazyguitar and tutorials. Practicals notes with Programs , Algorithm and output">
  <meta property="og:locale" content="en_US">
  <meta property="og:type" content="website">
  <meta property="og:title" content="Crazy Guitars - Code Snippet & Practical Notes">
  <meta property="og:url" content="https://www.coderrat.xyz">
  <meta property="og:site_name" content="Crazy Guitars">
  <link rel="canonical" href="https://www.coderrat.xyz" />
  <meta name="keywords" content="HTML, CSS, JavaScript, jquery, hacking, code snippet, practical c programming, c programming notes, c++ notes,data structure, algorithm,
ASTU CSE practical notes, php snippets, homework, copy, assignment, web-development, c++, c, python , free, snippet, crazyguitar, cyber security, free resource, quiz,  ajax, css, frontend, 
backend, photoshop, bootstrap, w3css, college, polytechnic, presentation, engineering, practicals, question, answers, programming">
  <meta name="google-site-verification" content="iE_ZofhKWj0_KZiJBSoZ50w5s-tQonKQ-k5b4whK1Zs" />
  <meta name="facebook-domain-verification" content="scn7e2rpiqyy4b6h3yfdxcygzeteou" />
  <meta itemprop="inLanguage" content="English">
  <meta itemprop="publisher" content="Crazy Guitars">
  <meta name="image" content="https://www.coderrat.xyz/images/coderrat.jpg">
  <meta property="og:image" content="https://www.coderrat.xyz/images/coderrat.jpg">
  <meta property="og:image:alt" content="Coder rat">
  <meta name="author" content="CoderRat">
  <link rel="icon" href="./images/icon.ico" type="image/icon type">
  <link href="images/apple-touch-icon.png" rel="apple-touch-icon" />
  <link rel="stylesheet" href="style/animation.css" media="print" onload="this.media='all'; this.onload=null;">
  <link rel="stylesheet" href="style/urls.css">
  <link rel="stylesheet" href="style/ui.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
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
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-YTCEEYGM9F"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'G-YTCEEYGM9F');
  </script>
</head>

<body itemscope itemtype="http://schema.org/Article" class="w3-light-grey">
  <div class="w3-content" style="max-width:1400px">
    <?php require('nav.php'); ?>
    <header class="w3-container w3-center w3-padding-32">
      <h1 itemprop="headline"><b>Crazy Guitars</b></h1>
      <p>Welcome to the crazyguitar of <span class="w3-tag">unknown</span></p>
    </header>
    <!-- Grid -->
    <div class="w3-row">
      <!-- crazyguitar entries -->
      <div class="w3-col l8 s12">
        <!-- crazyguitar entry -->
        <?php
        try {

          $pages = new Paginator('5', 'p');

          $stmt = $db->query('SELECT postID FROM crazyguitar_posts_seo');

          //pass number of records to
          $pages->set_total($stmt->rowCount());

          $stmt = $db->query('SELECT postID, postTitle, postSlug, postThumb, postDesc,views, postDate FROM crazyguitar_posts_seo ORDER BY postID DESC ' . $pages->get_limit());
          while ($row = $stmt->fetch()) {
        ?>

            <div itemscope itemtype="http://schema.org/Article" itemscope itemtype="http://schema.org/CreativeWork" class="w3-card-4 w3-margin w3-white">
              <?php if ($row['postThumb'] != '') { ?>
                <img itemprop="image" src="<?php echo $row['postThumb'] ?>" alt="Nature" style="width:100%">
              <?php } ?>
              <div class="w3-container">
                <b><a href="<?php $row['postSlug'] ?>">
                    <h2 itemprop="name headline"><?php echo $row['postTitle'] ?></h2>
                  </a></b>
                <h5><span class="w3-opacity">
                    <?php
                    echo '<p>Posted on ' . date('jS M Y H:i:s', strtotime($row['postDate'])) . ' in ';
                    echo '<meta itemprop="datePublished" content="' . date("Y-m-d", strtotime($row['postDate'])) . '">';
                    $stmt2 = $db->prepare('SELECT catTitle, catSlug	FROM crazyguitar_cats, crazyguitar_post_cats WHERE crazyguitar_cats.catID = crazyguitar_post_cats.catID AND crazyguitar_post_cats.postID = :postID');
                    $stmt2->execute(array(':postID' => $row['postID']));

                    $catRow = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                    $links = array();
                    foreach ($catRow as $cat) {
                      $links[] = "<span class='w3-tag w3-light-black w3-small w3-margin-bottom' itemprop='url'><a href='c-" . $cat['catSlug'] . "'>" . $cat['catTitle'] . "</a></span>";
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
                      <p><button itemprop="url" onclick="location.href='<?php echo $row['postSlug'] ?>'" class="w3-button w3-padding-large w3-white w3-border">Read More</a></button></p>
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
                      </span></span>
                    </p>
                  </div>
                </div>
              </div>
            </div>
            <div class="w3-card-4 w3-margin w3-white">

              <div class="w3-container">

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
  </div>
  <?php
  require('footer.php'); ?>
  <script src="//instant.page/5.1.0" type="module" integrity="sha384-by67kQnR+pyfy8yWP4kPO12fHKRLHZPfEsiSXR8u2IKcTdxD805MGUXBzVPnkLHw"></script>
</body>

</html>