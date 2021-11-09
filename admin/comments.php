<?php //include config
require_once('../includes/config.php');

//if not logged in redirect to login page
if (!$user->is_logged_in()) {
    header('Location: login.php');
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Admin - Add User</title>
    <link rel="icon" href="./images/icon.ico" type="image/icon type">
    <link rel="stylesheet" href="../style/normalize.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-parallax-js@5.5.1/dist/simpleParallax.min.js"></script>
</head>

<body>

    <div class="w3-content  w3-center w3-padding-64" style="max-width:max-content">
        <div id="w3-display-container w3-center w3-padding-64">

            <?php include('menu.php'); ?>
            no New Comments
        </div>
    </div>
</body>

</html>