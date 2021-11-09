<?php require('includes/config.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-parallax-js@5.5.1/dist/simpleParallax.min.js"></script>
    <link rel="stylesheet" media="screen" href="https://fontlibrary.org//face/horta" type="text/css" />

    <link rel="stylesheet" media="screen" href="./style/landing.css" type="text/css" />
    <link rel="stylesheet" media="screen" href="./style/gradients.css" type="text/css" />
    <!-- <link rel="stylesheet" media="screen" href="./style/smoke.css" type="text/css" /> -->
    <link rel="stylesheet" media="screen" href="./style/cardStyle.css" type="text/css" />
    <title>Crazy Guitars</title>
</head>

<body class="mars_concuest" itemscope itemtype="http://schema.org/Article">
    <!-- Navbar -->
    <?php require('nav.php'); ?>
    <div class="w3-content" style="max-width:2000px">

        <!-- Automatic Slideshow Images -->
        <div class="w3-display-container w3-center coverArtParent">
            <div class="subClass2">
                <img src="./images/background.jpg" class="thumbnail coverArt1" style="width:100% ;">
                <img src="./images/coverArt2 - Copy.png" class="coverArt2">
                <div class="coverText  w3-text-white">
                    <p class="assamese_text">কি আছিল কাহিনীটো… এখন ৰঙা গীটাৰত বজা </p>
                    <div class="crazyGuitar_text">
                        <div class="crazy_text_container">
                            <span class="crazy_text">Crazy</span>
                        </div>
                        <div class="guitar_text_container">
                            <span class="guitar_text">Guitar</span>
                        </div>
                    </div>
                    <p class="english_text"><b>Let the story flow through the guitar strings</b></p>
                </div>

            </div>
        </div>

        <!-- The Band Section -->
        <div class="w3-container w3-content w3-center w3-padding-64" style="max-width:800px" id="band">
            <h2 class="w3-wide w3-text-red">Crazy Guitars</h2>
            <p class="w3-opacity w3-text-black"><i>We love music</i></p>
            <p class="w3-justify w3-text-black descText">'Crazy Guitars' was formed sometime in early 2021 by four of us, musically inclined people, Bulbul Das, Jayanta Gogoi, Rana Buragohain and Chandana Pathak. We would like to share with all, our experimentations with different genres and styles and singers who will voice the stories we want to tell. We keep our music organic, real and pure. Join us in our journey and celebrate with us the magical world of good music.
                Peace and Love.</p>
            <div class="w3-container w3-content">
                <h2 class="w3-wide w3-center">OUR TEAM MEMBERS</h2>
                <!-- <p class="w3-opacity w3-center"><i>Our new release!</i></p><br> -->
                <div class="w3-row-padding w3-padding-32" style="margin:0 -16px">
                    <!-- Member list -->
                    <?php
                    try {
                        $stmt = $db->query('SELECT memberID , name , designation , email , disply_pic FROM crazyguitar_members ORDER BY memberID DESC ');
                        while ($row = $stmt->fetch()) {
                    ?>
                            <div class="w3-third w3-padding">
                                <div class="our-member w3-card" role="button" id="view_details">

                                    <div class="picture">

                                        <?php if ($row['disply_pic'] != '') { ?>
                                            <img src="./uploads/<?php echo ($row["disply_pic"]) ?>" class="img-fluid" alt="Random Name">
                                        <?php } else { ?>
                                            <img src="https://loremflickr.com/320/320/guitar" class="img-fluid" alt="Random Name">
                                        <?php } ?>
                                    </div>

                                    <div class=" member-content">
                                        <h3 class="name">
                                            <?php echo ($row["name"]) ?>
                                        </h3>
                                        <h3 class="name">
                                            <?php echo ($row["designation"]) ?>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            </button>
                    <?php
                        }
                    } catch (PDOException $e) {
                        echo $e->getMessage();
                    }
                    ?>
                    <!-- member list end -->
                </div>
            </div>

        </div>
        <!-- The Tour Section -->
        <div class="w3-black" id="song">
            <div class="w3-container w3-content w3-padding-40" style="max-width:800px">
                <h2 class="w3-wide w3-center">LATEST ALBUM</h2>
                <p class="w3-opacity w3-center"><i>Our new release!</i></p><br>
                <div class="w3-row-padding w3-padding-32" style="margin:0 -16px">
                    <!-- new release album -->
                    <?php
                    try {
                        $stmt = $db->query('SELECT postID , postSlug ,  postTitle , postThumb , releaseDate FROM crazyguitar_posts_seo ORDER BY postID DESC LIMIT 3');
                        while ($row = $stmt->fetch()) {
                    ?>
                            <div class="w3-third w3-card w3-margin-bottom">
                                <?php if ($row['postThumb'] != '') { ?>
                                    <img src="./uploads/<?php echo ($row["postThumb"]) ?>" class="img-fluid" alt="Random Name">
                                <?php } else { ?>
                                    <img src="https://loremflickr.com/320/240/guitars" alt="New York" style="width:100%" class="w3-hover-opacity">
                                <?php } ?>
                                <div class="w3-container w3-white">
                                    <p><b><?php echo ($row["postTitle"]) ?></b></p>
                                    <p class="w3-opacity">Release date -<?php echo ($row["releaseDate"]) ?></p>
                                    <!-- <p>Praesent tincidunt sed tellus ut rutrum sed vitae justo.</p> -->

                                    <a class="w3-button w3-black w3-margin-bottom" href="<?php echo ($row['postSlug']) ?>">View More</a>
                                </div>
                            </div>
                    <?php
                        }
                    } catch (PDOException $e) {
                        echo $e->getMessage();
                    }
                    ?>



                </div>
            </div>
        </div>

        <!-- The Contact Section -->
        <div class="w3-container w3-content w3-padding-64" style="max-width:800px" id="contact">
            <h2 class="w3-wide w3-center">CONTACT</h2>
            <p class="w3-opacity w3-center"><i>Fan? Drop a note!</i></p>
            <div class="w3-row w3-padding-32">
                <div class="w3-col m6 w3-large w3-margin-bottom">
                    <i class="fa fa-map-marker" style="width:30px"></i>Location<br>
                    <i class="fa fa-phone" style="width:30px"></i> Phone: ------<br>
                    <i class="fa fa-envelope" style="width:30px"> </i> Email: email<br>
                </div>
                <div class="w3-col m6">
                    <form action="/action_page.php" target="_blank">
                        <div class="w3-row-padding" style="margin:0 -16px 8px -16px">
                            <div class="w3-half">
                                <input class="w3-input w3-border" type="text" placeholder="Name" required name="Name">
                            </div>
                            <div class="w3-half">
                                <input class="w3-input w3-border" type="text" placeholder="Email" required name="Email">
                            </div>
                        </div>
                        <input class="w3-input w3-border" type="text" placeholder="Message" required name="Message">
                        <button class="w3-button w3-black w3-section w3-right" type="submit">SEND</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Page Content -->
    </div>
    <footer class="w3-container w3-padding-64 w3-center w3-opacity w3-light-grey w3-xlarge">
        <i class="fa fa-facebook-official w3-hover-opacity"></i>
        <i class="fa fa-instagram w3-hover-opacity"></i>
        <i class="fa fa-snapchat w3-hover-opacity"></i>
        <i class="fa fa-pinterest-p w3-hover-opacity"></i>
        <i class="fa fa-twitter w3-hover-opacity"></i>
        <i class="fa fa-linkedin w3-hover-opacity"></i>
        <!-- <p class="w3-medium">Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p> -->
    </footer>
    <script>
        // When the user clicks anywhere outside of the modal, close it
        var modal = document.getElementById('ticketModal');
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
        var image = document.getElementsByClassName('thumbnail');
        new simpleParallax(image, {
            delay: .6,
            transition: 'cubic-bezier(0,0,0,1)'
        });
    </script>
</body>

</html>