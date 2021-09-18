<?php
// $db = mysqli_connect("localhost", "root", "", "practice");

// // $sql = "SELECT * FROM tbl_comment ORDER BY parent_comment_id asc, comment_id asc";

// $result = mysqli_query($db, $sql);
// $record_set = array();
// while ($row = mysqli_fetch_assoc($result)) {
//     array_push($record_set, $row);
// }
// mysqli_free_result($result);

// mysqli_close($db);
// echo json_encode($record_set);


require_once '../includes/db.php';
$commentPostId = isset($_POST['post_id']) ? $_POST['post_id'] : "";
$sql = "SELECT * FROM tbl_comment where post_id= $commentPostId ORDER BY parent_comment_id asc, comment_id asc";

$statement = $db->prepare($sql);
$statement->execute();

$record_set = array();

while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
    array_push($record_set, $row);
}
echo json_encode($record_set);
