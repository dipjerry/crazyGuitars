<?php
require_once("../includes/db.php");
// $db = mysqli_connect("localhost", "root", "", "practice");

$feedback = isset($_POST['feedback']) ? $_POST['feedback'] : "";
$feedbackSenderName = isset($_POST['name']) ? $_POST['name'] : "";
$feedbackSenderEmail = isset($_POST['email']) ? $_POST['email'] : "";
$date = date('Y-m-d H:i:s');
$data = array(
    ':feedback' => $feedback,
    ':feedback_sender_name' => $feedbackSenderName,
    ':feedback_sender_email' => $feedbackSenderEmail,
    ':date' => $date,
);
// $stmt = $db->prepare('INSERT INTO tbl_comment(post_id, parent_comment_id,comment,comment_sender_name,comment_sender_email,date) VALUES (:post_id, :parent_comment_id,:comment,:comment_sender_name,:comment_sender_email,:date)');
// $stmt = $db->prepare('INSERT INTO tbl_comment(parent_comment_id, comment,comment_sender_name, comment_sender_email,date) VALUES (:parent_comment_id,:comment,:comment_sender_name,:comment_sender_email,:date)');
$stmt = $db->prepare('INSERT INTO tbl_feedback(feedback,sender_name,sender_email, date) VALUES (:feedback,:feedback_sender_name,:feedback_sender_email,:date)');
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
