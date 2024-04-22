<?php
include('config.php');
include('lib.php');

$input = $_POST['input'];

$connection = connect($server, $serveruser, $serverpassword, $PDOoptions);

$sql = 'SELECT tag_name FROM Tags WHERE tag_name LIKE :input';
$stmt = $connection->prepare($sql);
$input = $input . '%';
$stmt->bindParam(':input', $input, PDO::PARAM_STR);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Crear un array para almacenar los tag_names
$tagNames = array();

// Iterar sobre los resultados y almacenar los tag_names en el array
foreach ($results as $row) {
    $tagNames[] = $row['tag_name'];
}

// Devolver el array como JSON al Ajax
echo json_encode($tagNames);