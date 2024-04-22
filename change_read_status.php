<?php
$controla = true;
include ('lib.php');
include ('config.php');

$connection = connect($server, $serveruser, $serverpassword, $PDOoptions);

$status = $_GET["status"]*-1+1;

// Preparar y ejecutar la consulta SQL
$sql = 'UPDATE Messages SET message_read=:status WHERE message_id=:id';
$stmt = $connection->prepare($sql);
$stmt->bindParam(':status', $status, PDO::PARAM_INT);
$stmt->bindParam(':id', $_GET["message"], PDO::PARAM_INT);
$stmt->execute();
