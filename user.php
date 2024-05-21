<?php
$controla = true;
include ('lib.php');
include ('config.php');

$connection = connect($server, $serveruser, $serverpassword, $PDOoptions);

$sqlMessages = 'SELECT m.message_id, m.message_date, m.message, m.message_read, 
COALESCE(u_sender.username, "[deleted]") AS sender_username, 
COALESCE(u_sender.profile_image, "img/profile.png") AS sender_profile_image 
FROM messages m 
LEFT JOIN users u_sender ON m.sender_id = u_sender.user_id 
INNER JOIN users u_receiver ON m.receiver_id = u_receiver.user_id 
WHERE m.receiver_id = :user_id
ORDER BY m.message_date DESC;';
$stmtMessages = $connection->prepare($sqlMessages);
$stmtMessages->bindParam(':user_id', $_SESSION["user_id"], PDO::PARAM_STR);
$stmtMessages->execute();


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
    <link rel="stylesheet" href="css/user.css">
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
        <div class="pageSelector">
            <div class="pageOption active" onclick="showPageProfile(0)">
                <h2>PROFILE</h2>
            </div>
            <div class="pageOption" onclick="showPageProfile(1)">
                <h2>ACCOUNT</h2>
            </div>
            <div class="pageOption" onclick="showPageProfile(2)">
                <h2>INBOX</h2>
            </div>
        </div>
        <div class="allInfo">
            <div class="userAvatarAndName">
                <div class="avatar"><img src="<?php echo $_SESSION["profile_image"] ?>" alt="User's avatar"></div>
                <div class="username"><?php echo $_SESSION["username"] ?></div>
            </div>
            <div class="carrousel">
                <div class="profileSettings page">
                    <div class="profileInfo">
                        <div class="label">Username</div>
                        <input type="text" name="username" value="<?php echo $_SESSION["username"] ?>"
                            onkeypress="changeUsername(event)" autocomplete="off">
                        <div class="label">Avatar</div>
                        <div class="avatarOptions">
                            <div class="avatarButton" style="cursor: pointer;" onclick="selectImage()">Change avatar
                            </div>
                            <div class="avatarButton" style="cursor: pointer;" onclick="deleteImage()">Delete avatar
                            </div>
                        </div>
                        <div class="logOutButton" onclick="logOut()" style="cursor: pointer;">LOG OUT</div>
                    </div>
                </div>
                <div class="profileSettings page" style="display: none;">
                    <div class="accountSettings">
                        <div class="accountDropDown" onclick="showPasswordInputs()">Change password</div>
                        <div id="passwordInputs" style="display: none;" class="passwordInputs">
                            <div class="passwordInput">
                                <input type="password" id="newPassword" placeholder="New password">
                            </div>
                            <div class="passwordInput">
                                <input type="password" id="confirmPassword" placeholder="Confirm new password">
                            </div>
                            <div class="passwordInput">
                                <div onclick="changePassword()" class="changePassword">Confirm</div>
                            </div>
                        </div>
                        <div class="accountButton" onclick="deleteAccount(0)">Delete account</div>
                        <div class="accountButton" onclick="deleteAccount(1)">Delete account <br> and interactions</div>
                    </div>
                </div>
                <div class="profileSettings page" style="display: none;">
                    <div class="inbox">
                        <?php
                        while ($regMessages = $stmtMessages->fetch()) {
                            echo '<div class="message">
                            <div class="author">
                                <div class=senderInfo>
                                    <div class="profileImg"><img src="' . $regMessages["sender_profile_image"] . '" alt="Profile image of the message sender"></div>
                                    <div class="senderUser">' . $regMessages["sender_username"] . '</div>
                                </div>
                                <div class="date">' . $regMessages["message_date"] . '</div>
                            </div>
                            <div class="content">' . $regMessages["message"] . '</div>
                            <div class="isRead"><input type="checkbox" id="markAsRead" class="markAsRead" onchange="markRead(this)" message-id="'.$regMessages["message_id"].'" message-status="';
                            if ($regMessages["message_read"]==1){
                                echo '1" checked';
                            }
                            else{
                                echo '0"';
                            }
                            echo '>Mark as read</div>
                            </div>';
                        }
                        ?>
                    </div>
                    <div class="readAll" onclick="markAllAsRed()">Mark all as read</div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="scripts.js"></script>
</body>

</html>