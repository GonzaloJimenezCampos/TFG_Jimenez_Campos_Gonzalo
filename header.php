<?php
include ('lib.php');
include ('config.php');

if (empty($_SESSION["user_id"])) {
    $header = '<nav><a href="registration.php" class="logInHeaderButton registerButton">Register</a><a href="login.php" class="logInHeaderButton">Log in</a></nav>';
} else {
    $connection = connect($server, $serveruser, $serverpassword, $PDOoptions);
    $sql = 'SELECT COUNT(1) as notifications FROM messages WHERE receiver_id=:id AND message_read=0';
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':id', $_SESSION["user_id"], PDO::PARAM_INT);
    $stmt->execute();
    $reg = $stmt->fetch();
    $notifications = "";
    $display="none";
    if ($reg["notifications"] >= 1 && $reg["notifications"] <= 99) {
        $display="flex";
        $notifications = $reg["notifications"];
    } else if ($reg["notifications"] > 99) {
        $display="flex";
        $notifications = "99+";
    }
    $header = '<nav>
                <a href="user.php" class="username">' . $_SESSION["username"] . '</a>
                <a href="user.php">
                    <img width="100px" height="100px" style="border-radius: 50%;" src="' . $_SESSION["profile_image"] . '" alt="Users account avatar">
                    <div class="notificationsNumber" style="display:'.$display.'">'.$notifications.'</div>
                </a>
            </nav>';
}



?>

<div class="headerContainer">
    <header>
        <div class="nabla-logo"><a href="index.php?page=0">F(x)LoL</a></div>
        <?php echo $header ?>
    </header>
</div>