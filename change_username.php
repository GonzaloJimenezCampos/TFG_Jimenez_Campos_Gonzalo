<?php
$controla = true;
include ('lib.php');
include ('config.php');

$connection = connect($server, $serveruser, $serverpassword, $PDOoptions);

$newUsername = $_POST["new_username"];

$sql = 'SELECT username FROM Users WHERE username = :username';
$stmt = $connection->prepare($sql);
$stmt->bindParam(':username', $newUsername, PDO::PARAM_STR);
$stmt->execute();

if (!($reg = $stmt->fetch())) {
    $sqlUpdate = 'UPDATE Users SET username=:username WHERE user_id = :user_id';
    $stmtUpdate = $connection->prepare($sqlUpdate);
    $stmtUpdate->bindParam(':username', $newUsername, PDO::PARAM_STR);
    $stmtUpdate->bindParam(':user_id', $_SESSION["user_id"], PDO::PARAM_STR);
    $stmtUpdate->execute();
    $_SESSION["username"] = $newUsername;
    echo "success";
}

?>