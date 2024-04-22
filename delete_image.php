<?php
$controla = true;
include ('lib.php');
include ('config.php');



if (isset($_SESSION["profile_image"])) {
    $imagen_antigua = $_SESSION["profile_image"];
    if (file_exists($imagen_antigua) && $imagen_antigua != "img/profile.png") {
        unlink($imagen_antigua);
    }
}

$connection = connect($server, $serveruser, $serverpassword, $PDOoptions);

$sqlUpdate = 'UPDATE Users SET profile_image="img/profile.png" WHERE user_id=' . $_SESSION['user_id'];
$stmt = $connection->prepare($sqlUpdate);
$stmt->execute();
if ($stmt->execute()) {
    $_SESSION["profile_image"] = "img/profile.png";
    echo "<script>window.location.reload();</script>";
}
