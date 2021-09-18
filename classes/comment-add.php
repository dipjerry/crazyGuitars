<?php
require_once("../includes/db.php");
// $db = mysqli_connect("localhost", "root", "", "practice");

$commentId = isset($_POST['comment_id']) ? $_POST['comment_id'] : "";
$commentPostId = isset($_POST['comment_post_id']) ? $_POST['comment_post_id'] : "";
$comment = isset($_POST['comment']) ? $_POST['comment'] : "";
$commentSenderName = isset($_POST['name']) ? $_POST['name'] : "";
$commentSenderEmail = isset($_POST['email']) ? $_POST['email'] : "";
$date = date('Y-m-d H:i:s');
$data = array(
    ':post_id' => $commentPostId,
    ':parent_comment_id' => $commentId,
    ':comment' => $comment,
    ':comment_sender_name' => $commentSenderName,
    ':comment_sender_email' => $commentSenderEmail,
    ':date' => $date,
);
// $stmt = $db->prepare('INSERT INTO tbl_comment(post_id, parent_comment_id,comment,comment_sender_name,comment_sender_email,date) VALUES (:post_id, :parent_comment_id,:comment,:comment_sender_name,:comment_sender_email,:date)');
// $stmt = $db->prepare('INSERT INTO tbl_comment(parent_comment_id, comment,comment_sender_name, comment_sender_email,date) VALUES (:parent_comment_id,:comment,:comment_sender_name,:comment_sender_email,:date)');
$stmt = $db->prepare('INSERT INTO tbl_comment(post_id, parent_comment_id, comment,comment_sender_name,comment_sender_email, date) VALUES (:post_id,:parent_comment_id,:comment,:comment_sender_name,:comment_sender_email,:date)');
if ($stmt->execute($data)) {
    echo 1;
} else {
    echo 0;
}
// $result = mysqli_query($db, $sql);

// if (!$result) {
//     $result = mysqli_error($db);
// }
// echo $result;
