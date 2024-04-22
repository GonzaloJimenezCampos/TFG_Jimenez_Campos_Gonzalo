<?php
$controla = true;
include('config.php');
include('lib.php');

$connection = connect($server, $serveruser, $serverpassword, $PDOoptions);

if (isset($_SESSION['user_id']) && isset($_POST['saved'])) {
    $saved = $_POST['saved'];
    $userId = $_SESSION['user_id'];
    $deleteQuery = "DELETE FROM SavedPosts WHERE user_id = ? AND post_id = ?";
    $insertQuery = "INSERT INTO SavedPosts (user_id, post_id) VALUES (?, ?)";
    if ($saved == 0) {
        $deleteStmt = $connection->prepare($deleteQuery);
        $deleteStmt->execute([$userId, $_POST["post"]]);
    } else if ($saved == 1) {
        $insertStmt = $connection->prepare($insertQuery);
        $insertStmt->execute([$userId, $_POST["post"]]);
    }
}
?>