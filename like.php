<?php
$controla=true;
include('config.php');
include('lib.php');

$connection = connect($server, $serveruser, $serverpassword, $PDOoptions);

if (isset($_SESSION['user_id']) && isset($_POST['liked'])) {
    $liked = $_POST['liked'];
    $userId = $_SESSION['user_id'];
    
    if (isset($_POST['comment'])){
        $deleteQuery = "DELETE FROM LikedComments WHERE user_id = ? AND comment_id = ?";
        $insertQuery = "INSERT INTO LikedComments (user_id, comment_id) VALUES (?, ?)";
        $id=$_POST['comment'];
    }else if(isset($_POST['post'])){
        $deleteQuery = "DELETE FROM LikedPosts WHERE user_id = ? AND post_id = ?";
        $insertQuery = "INSERT INTO LikedPosts (user_id, post_id) VALUES (?, ?)";
        $id=$_POST['post'];
    }
    if ($liked == 0) {
        $deleteStmt = $connection->prepare($deleteQuery);
        $deleteStmt->execute([$userId, $id]);
    } else if ($liked == 1) {
        $insertStmt = $connection->prepare($insertQuery);
        $insertStmt->execute([$userId, $id]);
    }
}
?>
