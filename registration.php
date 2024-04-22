<?php
$controla=false;
include('config.php');
include('lib.php');

// Token CSRF para seguridad en formularios
if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}

$token = $_SESSION['token'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gonzalo Jiménez - Porfolio</title>
    <link rel="stylesheet" href="css/css-reset.css">
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/registration.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Karla:wght@400;700&family=Oswald:wght@400;700&display=swap"
        rel="stylesheet">
</head>

<body>
    <div w3-include-html="userless_header.html"></div>
    <div class="container">
        <div class="registrationInfo">
            <div class="title"><h1>CREATE YOUR ACCOUNT NOW</h1></div>
            <div class="body"><h2>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Autem consequatur in porro
                facere, veritatis fugit</h2></div>
        </div>
        <div class="registrationForm">
            <form action="registration_control.php"  method="POST">
                <input type="hidden" name="token" value="<?php echo $token; ?>">
                <input type="text" name="username" id="username" placeholder="Username">
                <input type="password" name="password" id="password" placeholder="Password">
                <input type="password" name="repeatPassword" id="repeatPassword" placeholder="Repeat password">
                <input type="submit" class="submitButton" value="Register">
            </form>
            <p>Alredy have an account? <a href="login.php">Log in</a></p>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="scripts.js"></script>
</body>

</html>