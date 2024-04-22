<?php
$controla=true;
include ('lib.php');
include ('config.php');

// Directorio donde deseas guardar las imágenes
$directorio_destino = 'img/users_images/';

// Verificar si se recibió la imagen
if(isset($_FILES['image'])) {
    $archivo_tmp = $_FILES['image']['tmp_name'];
    $nombre_archivo_original = $_FILES['image']['name'];
    
    // Generar un nombre único para la imagen
    $extension = pathinfo($nombre_archivo_original, PATHINFO_EXTENSION);
    $nombre_archivo_nuevo = uniqid() . '.' . $extension;

    if (isset($_SESSION["profile_image"])) {
        $imagen_antigua = $_SESSION["profile_image"];
        if (file_exists($imagen_antigua) && $imagen_antigua!="img/profile.png") {
            unlink($imagen_antigua);
        }
    }
    
    // Mover la imagen al directorio de destino con el nuevo nombre
    if(move_uploaded_file($archivo_tmp, $directorio_destino . $nombre_archivo_nuevo)) {
        $connection = connect($server, $serveruser, $serverpassword, $PDOoptions);
        
        $sqlUpdate = 'UPDATE Users SET profile_image="'.$directorio_destino.$nombre_archivo_nuevo.'" WHERE user_id='.$_SESSION["user_id"];
        $stmt = $connection->prepare($sqlUpdate);
        $stmt->execute();
        $_SESSION["profile_image"]=$directorio_destino.$nombre_archivo_nuevo;
    }
}