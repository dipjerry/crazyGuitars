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
    <link rel="stylesheet" href="../style/main.css">
</head>

<body>

    <div id="wrapper">

        <?php include('menu.php'); ?>
        no New Comments
    </div>
</body>

</html>