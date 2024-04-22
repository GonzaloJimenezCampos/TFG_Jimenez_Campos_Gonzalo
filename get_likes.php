<?php
$controla = true;
include('config.php');
include('lib.php');

$connection = connect($server, $serveruser, $serverpassword, $PDOoptions);

if (isset($_GET['post_id'])) {
    $postId = $_GET['post_id'];
    $query = "SELECT COUNT(post_id) AS likes FROM LikedPosts WHERE post_id=?;";
    $stmt = $connection->prepare($query);
    $stmt->execute([$postId]);
    $row = $stmt->fetch();
    $likes = $row['likes'];
    echo $likes;
}else if(isset($_GET['comment_id'])) {
    $commentId = $_GET['comment_id'];
    $query = "SELECT COUNT(comment_id) AS likes FROM LikedComments WHERE comment_id=?;";
    $stmt = $connection->prepare($query);
    $stmt->execute([$commentId]);
    $row = $stmt->fetch();
    $likes = $row['likes'];
    echo $likes;
}
?>
