<?php
$controla = false;
include('config.php');
include('lib.php');

// Validaci�n del token CSRF
if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
    die("Operaci�n no permitida");
}

// Validación y limpieza de entradas
$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
$passwordRepeat = filter_input(INPUT_POST, 'repeatPassword', FILTER_SANITIZE_STRING);

try {
    $connection = connect($server, $serveruser, $serverpassword, $PDOoptions);

    // Consulta parametrizada para prevenir posibles inyecciones SQL
    $sql = 'SELECT username FROM Users WHERE username = :username';
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();

    //Verificamos que el nombre de usuario esta disponible
    if (!($reg = $stmt->fetch())) {
        if ($password==$passwordRepeat) {
            $insertSQL = 'INSERT INTO Users (creation_date, permissions, username, password, profile_image) VALUES (NOW(), 0, :username, :password, "img/profile.png")';
            $stmt = $connection->prepare($insertSQL);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            $stmt->execute();
            $sql = 'SELECT * FROM Users WHERE username = :username';
            $stmtUser = $connection->prepare($sql);
            $stmtUser->bindParam(':username', $username, PDO::PARAM_STR);
            $stmtUser->execute();
            $regUser = $stmtUser->fetch();
            $_SESSION['username'] = $regUser['username'];
            $_SESSION['user_id'] = $regUser['user_id'];
            $_SESSION['profile_image']=$regUser['profile_image'];
            $_SESSION['permissions']=$reg['permissions'];
            header('Location: index.php');
            exit;
        }else{
            header('Location: registration.php');
        }
    } else {
        header('Location: registration.php');;
    }
} catch (PDOException $e) {
    die("Connection error: " . $e->getMessage());
}
?>
