<?php
 //include config
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
    <link rel="stylesheet" href="../style/main.css">
    <script src="https://cdn.tiny.cloud/1/92ltn95nzfq205vfh547qcolol9ltoexruk64k9xtl8qc9zz/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="../js/jquery-3.2.1.min.js"></script>
    <script>
        tinymce.init({
            selector: "textarea",
            plugins: [
                "advlist autolink lists link image charmap print preview anchor",
                "searchreplace visualblocks  fullscreen fullpage",
                "insertdatetime media table contextmenu paste",
                "code codesample"
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
            link_class_list: [{
                    title: 'None',
                    value: ''
                },
                {
                    title: 'black',
                    value: 'w3-button w3-black'
                },
                {
                    title: 'red',
                    value: 'w3-button w3-red'
                },
                {
                    title: 'green',
                    value: 'w3-button w3-green'
                },
                {
                    title: 'blue',
                    value: 'w3-button w3-blue'
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
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-parallax-js@5.5.1/dist/simpleParallax.min.js"></script>
</head>

<body>
    <div id="wrapper">
        <?php include('menu.php'); ?>
        <p><a href="./">crazyguitar Admin Index</a></p>
        <h2>Add Post</h2>
        <?php
        //if form has been submitted process it
        if (isset($_POST['submit'])) {
            //collect form data
            extract($_POST);
            //very basic validation
            if ($postDesc == '') {
                $error[] = 'Please enter the description.';
            }
            if (!isset($error)) {
                try {
                    $stmt0 = $db->prepare('SELECT  memberID FROM crazyguitar_members WHERE username = :author');
                    $stmt0->execute(array(':author' => $_SESSION['username']));
                    $row0 = $stmt0->fetch();
                    $postSlug = slug($postTitle);
                    //insert into database
                    $stmt = $db->prepare('INSERT INTO crazyguitar_landing (postDesc, postDate) VALUES (:postTitle, :postSlug,:postThumb, :postDesc, :postCont,:postKey ,:author,:views, :postDate)');
                    $stmt->execute(array(
                        ':postDesc' => $postDesc,
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
                    //redirect to index page
                    header('Location: index.php?action=added');
                    exit;
                } catch (PDOException $e) {
                    echo $e->getMessage();
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
        <form action='' method='post'>
            <p><label>Description</label><br />
                <textarea name='postDesc' cols='60' rows='10' placeholder='crazyguitar Description'><?php if (isset($error)) {
                echo $_POST['postDesc'];} ?></textarea>
            </p>

            <p class="view_MK"></p>
            <script>
                $("#postKey").keyup(function() {
                    $(".view_MK").text($("#postKey").val());
                });
            </script>
            <p><input type='submit' name='submit' value='Update'></p>
        </form>
    </div>