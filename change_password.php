<?php
$controla = true;
include ('lib.php');
include ('config.php');

function safePassword($password)
{

    // Al menos una letra mayúscula y una letra minúscula
    if (!preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password)) {
        return false;
    }

    // Al menos un número
    if (!preg_match('/[0-9]/', $password)) {
        return false;
    }

    // Al menos un carácter especial
    if (!preg_match('/[\'^£$%&*()}{@#~?><>,|=_+.¬-]/', $password)) {
        return false;
    }

    // La contraseña cumple con todos los criterios de seguridad
    return true;
}


$connection = connect($server, $serveruser, $serverpassword, $PDOoptions);

$newPassword = $_POST["password"];

if (safePassword($newPassword)) {
    $password=password_hash($newPassword, PASSWORD_DEFAULT);
    $sqlUpdate = 'UPDATE Users SET password=:password WHERE user_id = :user_id';
    $stmtUpdate = $connection->prepare($sqlUpdate);
    $stmtUpdate->bindParam(':password', $password, PDO::PARAM_STR);
    $stmtUpdate->bindParam(':user_id', $_SESSION["user_id"], PDO::PARAM_STR);
    $stmtUpdate->execute();
    $changed = true;
}else{
    $changed = false;
}

echo json_encode($changed);