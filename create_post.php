<?php
$controla = true;
include ('config.php');
include ('lib.php');

$connection = connect($server, $serveruser, $serverpassword, $PDOoptions);

$tagsString = $_POST["tags"];
$tags = explode(',', $tagsString);

$insertSQL = 'INSERT INTO posts (post_date, post_title, post_body, user_id) VALUES (NOW(), :post_title, :post_body, :user_id);';
$stmt = $connection->prepare($insertSQL);
$stmt->bindParam(':post_title', $_POST["title"], PDO::PARAM_STR);
$stmt->bindParam(':post_body', $_POST["body"], PDO::PARAM_STR);
$stmt->bindParam(':user_id', $_SESSION["user_id"], PDO::PARAM_STR);
$stmt->execute();

// Obtener el ID generado automáticamente
$generated_id = $connection->lastInsertId();

$insertSQL2 = 'INSERT INTO tagsposts (tag_id, post_id) VALUES ((SELECT tag_id FROM Tags WHERE tag_name=:tag_name), :post_id);';
for ($i = 0; $i < count($tags); $i++) {
    $stmt2 = $connection->prepare($insertSQL2);
    $stmt2->bindParam(':tag_name', $tags[$i], PDO::PARAM_STR);
    $stmt2->bindParam(':post_id', $generated_id, PDO::PARAM_STR);
    $stmt2->execute();
}
