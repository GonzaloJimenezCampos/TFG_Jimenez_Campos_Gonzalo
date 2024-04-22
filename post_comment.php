<?php
$controla=true;
include('config.php');
include('lib.php');

$connection = connect($server, $serveruser, $serverpassword, $PDOoptions);


$insertSQL = 'INSERT INTO Comments (comment_date, comment_body, user_id, post_id) VALUES (NOW(), :comment_body, :user_id, :post_id)';
$stmt = $connection->prepare($insertSQL);
$stmt->bindParam(':comment_body', $_POST["comment"], PDO::PARAM_STR);
$stmt->bindParam(':user_id', $_SESSION["user_id"], PDO::PARAM_STR);
$stmt->bindParam(':post_id', $_POST["post"], PDO::PARAM_STR);
$stmt->execute();