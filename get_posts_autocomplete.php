<?php
include('config.php');
include('lib.php');

$input = $_POST['input'];

$connection = connect($server, $serveruser, $serverpassword, $PDOoptions);

$sql = 'SELECT post_title FROM Posts WHERE post_title LIKE :input LIMIT 10';
$stmt = $connection->prepare($sql);
$input = '%' .$input . '%';
$stmt->bindParam(':input', $input, PDO::PARAM_STR);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

$postNames = array();

foreach ($results as $row) {
    $postNames[] = $row['post_title'];
}

// Devolver el array como JSON al Ajax
echo json_encode($postNames);