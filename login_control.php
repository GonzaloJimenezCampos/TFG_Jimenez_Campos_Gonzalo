
<?php
$controla=false;
include('config.php');
include('lib.php');

// Validaci�n del token CSRF
if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
    die("Operaci�n no permitida");
}

// Validación y limpieza de entradas
$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

try {
    $connection = connect($server, $serveruser, $serverpassword, $PDOoptions);

    // Consulta parametrizada para prevenir posibles inyecciones SQL
    $sql = 'SELECT * FROM Users WHERE username = :username';
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();

    if ($reg = $stmt->fetch()) {
        // Verificar la password
        if ($password==$reg['password']) {
            $_SESSION['username'] = $reg['username'];
            $_SESSION['user_id'] = $reg['user_id'];
            $_SESSION['profile_image']=$reg['profile_image'];
            $_SESSION['permissions']=$reg['permissions'];
            header('Location: index.php');
            exit;
        } else {
            header('Location: login.php');
        }
    } else {
        header('Location: login.php');
    }
} catch (PDOException $e) {
    die("Error en la conexi�n: " . $e->getMessage());
}
?>
