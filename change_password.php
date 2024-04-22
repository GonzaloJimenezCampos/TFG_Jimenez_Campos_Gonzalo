<?php
$controla = true;
include ('lib.php');
include ('config.php');

$connection = connect($server, $serveruser, $serverpassword, $PDOoptions);

$newPassword = $_POST["password"];

$sqlUpdate = 'UPDATE Users SET password=:password WHERE user_id = :user_id';
$stmtUpdate = $connection->prepare($sqlUpdate);
$stmtUpdate->bindParam(':password', $newPassword, PDO::PARAM_STR);
$stmtUpdate->bindParam(':user_id', $_SESSION["user_id"], PDO::PARAM_STR);
$stmtUpdate->execute();