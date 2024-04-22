<?php
session_start();

if (isset($controla) && $controla) {
    if (empty($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }
} else if(isset($controla) && !$controla){
    if (!empty($_SESSION['user_id'])) {
        header('Location: index.php');
        exit;
    }
}

function connect($server, $serveruser, $serverpassword, $PDOoptions) {
    try {
        $connect = new PDO($server, $serveruser, $serverpassword, $PDOoptions);
    } catch (PDOException $e) {
        echo "Error al conectar con la base de datos: " . $e->getMessage();  
        exit;
    }
    return $connect;
}