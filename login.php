<?php
$controla=false;
include('config.php');
include('lib.php');

// Token CSRF para seguridad en formularios
if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}

$alert = "";

if (isset($_GET["error"])) {
    if ($_GET["error"] == "login") {
        $alert = "<script> customAlert('The username or the password does not match', 0) </script>";
    }
}

$token = $_SESSION['token'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
    <link rel="stylesheet" href="css/css-reset.css">
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Karla:wght@400;700&family=Oswald:wght@400;700&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nabla&display=swap" rel="stylesheet">
</head>

<body>
    <div w3-include-html="userless_header.html"></div>
    <div class="alerts" id="alerts">
    </div>
    <div class="container">
        <h1>LOG IN</h1>
        <form action="login_control.php" method="POST">
            <input type="hidden" name="token" value="<?php echo $token; ?>">
            <input type="text" name="username" id="username" placeholder="Username" autocomplete="off">
            <input type="password" name="password" id="password" placeholder="Password">
            <input type="submit" class="submitButton" value="Log in">
        </form>
        <p>New around here? <a href="registration.php">Join now</a></p>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="scripts.js"></script>
    <?php echo $alert ?>
</body>

</html>