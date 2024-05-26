<?php
include ('lib.php');
include ('config.php');

$connection = connect($server, $serveruser, $serverpassword, $PDOoptions);

if (isset($_SESSION["user_id"])) {
    $sql = 'SELECT p.post_id, p.post_title, p.post_body, p.post_date, u.user_id, COALESCE(u.username, "[deleted]") AS username, COALESCE(u.profile_image, "img/profile.png") AS profile_image, COALESCE(lp.likes_count, 0) AS likes, COALESCE(lp.user_liked, 0) AS user_liked, COALESCE(sp.user_saved, 0) AS user_saved, COALESCE(c.comments_count, 0) AS comments_count FROM Posts p LEFT JOIN Users u ON p.user_id = u.user_id LEFT JOIN ( SELECT post_id, COUNT(*) AS likes_count, MAX(CASE WHEN user_id = ' . $_SESSION["user_id"] . ' THEN 1 ELSE 0 END) AS user_liked FROM LikedPosts GROUP BY post_id ) lp ON p.post_id = lp.post_id LEFT JOIN ( SELECT post_id, MAX(CASE WHEN user_id = ' . $_SESSION["user_id"] . ' THEN 1 ELSE 0 END) AS user_saved FROM SavedPosts WHERE user_id = ' . $_SESSION["user_id"] . ' GROUP BY post_id ) sp ON p.post_id = sp.post_id LEFT JOIN ( SELECT post_id, COUNT(*) AS comments_count FROM comments GROUP BY post_id ) c ON p.post_id = c.post_id WHERE p.post_id=:post_id;';
} else {
    $sql = 'SELECT p.post_id, p.post_date, p.post_title, p.post_body, COALESCE(u.username, "[deleted]") AS username, COALESCE(u.profile_image, "img/profile.png") AS profile_image, COUNT(lp.post_id) AS likes, 0 AS user_liked, 0 AS user_saved, COALESCE(c.comments_count, 0) AS comments_count FROM Posts p LEFT JOIN Users u ON p.user_id = u.user_id LEFT JOIN LikedPosts lp ON p.post_id = lp.post_id LEFT JOIN (SELECT post_id, COUNT(*) AS comments_count FROM comments WHERE post_id = :post_id) c ON p.post_id = c.post_id WHERE p.post_id=:post_id GROUP BY p.post_id ORDER BY p.post_date DESC;';
}
$stmt = $connection->prepare($sql);
$stmt->bindParam(':post_id', $_GET["post"], PDO::PARAM_STR);
$stmt->execute();
$post404 = false;
if (!($reg = $stmt->fetch())) {
    $post404 = true;
}

$sqlComments = 'SELECT c.comment_id, c.comment_date, c.comment_body, u.user_id, COALESCE(u.username, "[deleted]") AS username, COALESCE(u.profile_image, "img/profile.png") AS profile_image, 
c.post_id, IF(lc.user_id IS NOT NULL, 1, 0) AS user_liked, COALESCE(lc_count.likes_count, 0) AS likes FROM Comments c LEFT JOIN Users u ON c.user_id = u.user_id 
LEFT JOIN LikedComments lc ON c.comment_id = lc.comment_id AND lc.user_id = :user_id
LEFT JOIN (SELECT comment_id, COUNT(*) AS likes_count FROM LikedComments GROUP BY comment_id) AS lc_count ON c.comment_id = lc_count.comment_id WHERE c.post_id = :post_id ORDER BY c.comment_date DESC;';
$stmtComments = $connection->prepare($sqlComments);
$stmtComments->bindParam(':user_id', $_SESSION["user_id"], PDO::PARAM_STR);
$stmtComments->bindParam(':post_id', $_GET["post"], PDO::PARAM_STR);
$stmtComments->execute();

function calculateTimeAgo($date)
{
    $now = time(); // Fecha y hora actual en segundos
    $timestamp = strtotime($date); // Convertir la fecha recibida a un timestamp

    // Calcular la diferencia en segundos
    $difference = $now - $timestamp;

    if ($difference < 60) { // Menos de un minuto
        return "now";
    } elseif ($difference < 3600) { // Menos de una hora
        $minutes = round($difference / 60);
        return "$minutes minutes ago";
    } elseif ($difference < 86400) { // Menos de 24 horas
        $hours = round($difference / 3600);
        return "$hours hours ago";
    } elseif ($difference < 2592000) { // Menos de un mes (30 días)
        $days = round($difference / 86400);
        return "$days days ago";
    } elseif ($difference < 31536000) { // Menos de un año (365 días)
        $months = round($difference / 2592000);
        return "$months months ago";
    } else { // Más de un año
        $years = round($difference / 31536000);
        return "$years years ago";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo ($post404 ? "Post not found" : $reg["post_title"]) ?></title>
    <link rel="icon" type="image/x-icon" href="img/favicon.png">
    <link rel="stylesheet" href="css/css-reset.css">
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/post.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Karla:wght@400;700&family=Oswald:wght@400;700&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nabla&display=swap" rel="stylesheet">
</head>

<body>
    <div class="alerts" id="alerts">
    </div>
    <div w3-include-html="header.php"></div>
    <div class="arrow"><a href="index.php?page=1"><img src="img/cursor.png"
                alt="Arrow that you can click to go to the forum main page"></a>
    </div>
    
        <?php
        if ($post404) {
            echo '<div class="container" style="background-color: #15191d">
            <div class="error"><h1>ERROR 404</h1></div>
            <div class="errorDescription">The post you were looking for does no longer exists (or never existed)</div>
            </div>';
        } else {
            echo '<div class="container">
            <div class="post">
        <div class="postInfo">
            <div class="userInfo">
                <div class="avatar"><img src="' . $reg["profile_image"] . '" alt="Original poster avatar"></div>
                <div class="postUsername">' . $reg["username"] . '</div>
                <div class="postTags">';
            $sqlTags = "SELECT tag_name FROM Tags WHERE tag_id in (SELECT tag_id FROM TagsPosts WHERE post_id=" . $reg["post_id"] . ")";
            $stmtTags = $connection->prepare($sqlTags);
            $stmtTags->execute();
            while ($regTags = $stmtTags->fetch()) {
                echo '<div class="postTag">' . $regTags["tag_name"] . '</div>';
            }
            echo '</div>
            </div>
            <div class="pubDate">' . calculateTimeAgo($reg["post_date"]) . '</div>
        </div>
        <div class="title">
            <h1>' . $reg["post_title"] . '</h1>
        </div>
        <div class="postBody">' . $reg["post_body"] . '</div>
        <div class="interactions">
            <div class="likes">
                <div class="heart">';
            if (isset($_SESSION["user_id"])) {
                echo '<img src="img/like_' . $reg["user_liked"] . '.png" alt="Like icon. Click to like the post" 
            post-id="' . $reg["post_id"] . '" post-liked="' . $reg["user_liked"] . '" onclick="changeLikeStatePost(event, this)">';
            } else {
                echo '<a href="login.php"><img src="img/like_0.png" alt="Like icon. Click to like the post"></a>';
            }
            echo '</div>
            <div class="number">' . $reg["likes"] . '</div>
        </div>
        <div class="save">';
            if (isset($_SESSION["user_id"])) {
                echo '<img src="img/save_' . $reg["user_saved"] . '.png" alt="Save icon. Click to save the post"
                post-id="' . $reg["post_id"] . '" post-saved="' . $reg["user_saved"] . '" onclick="changeSaveStatePost(event, this)">';
            } else {
                echo '<a href="login.php"><img src="img/save_0.png" alt="Save icon. Click to save the post"></a>';
            }
            echo '</div>
            <div class="comments">
            <div><img src="img/comment.png" alt="Comment icon"></div>
            <div class="number">' . $reg["comments_count"] . '</div>
        </div>
        <div class="delete">';
            if ((isset($_SESSION["permissions"]) && $_SESSION["permissions"] == 1) || (isset($_SESSION["user_id"]) && $reg["user_id"] == $_SESSION["user_id"])) {
                echo '<img src="img/delete.png" alt="Save icon. Click to save the post"
                post-id="' . $reg["post_id"] . '" onclick="deletePost(event, this)">';
            }
            echo '</div>
    </div>
</div>';

            if (isset($_SESSION["user_id"])) {
                echo '<input type="text" class="commentBox" placeholder="Write a comment" id="comment-posting" onkeypress="enterPostComment(' . $_GET["post"] . ')" autocomplete="off">
        <div class="commentButton" onclick="postComment(' . $_GET["post"] . ')">Comment</div>';
            } else {
                echo '<a href="login.php" class="loginButton">Login to make a comment</a>';
            }
            echo ' <div class="order" id="orderSelect">Order by <select id="order" name="order"
            onchange="getComments(' . $reg["post_id"] . ')">
            <option value="date">Most recent</option>
            <option value="likes">Most liked</option>
            </select>
            </div>
            <div id="comments">';

            while ($regComment = $stmtComments->fetch()) {
                echo '<div class="post comment">
            <div class="postInfo">
                <div class="userInfo">
                    <div class="avatar"><img src="' . $regComment["profile_image"] . '" alt="Avatar of the user that made the comment"></div>
                    <div class="postUsername">' . $regComment["username"] . '</div>
                </div>
                <div class="pubDate">' . calculateTimeAgo($regComment["comment_date"]) . '</div>
            </div>
            <div class="postBody">' . $regComment["comment_body"] . '</div>
            <div class="interactions">
                <div class="likes">
                    <div class="heart">';
                if (isset($_SESSION["user_id"])) {
                    echo '<img src="img/like_' . $regComment["user_liked"] . '.png" alt="Like icon. Click to like the post" 
                    comment-id="' . $regComment["comment_id"] . '" comment-liked="' . $regComment["user_liked"] . '" onclick="changeLikeStateComment(event, this)">';
                } else {
                    echo '<a href="login.php"><img src="img/like_0.png" alt="Like icon. Click to like the post"></a>';
                }
                echo '</div>
                <div class="number">' . $regComment["likes"] . '</div>
            </div>
            <div class="delete">';
                if ((isset($_SESSION["permissions"]) && $_SESSION["permissions"] == 1) || (isset($_SESSION["user_id"]) && $regComment["user_id"] == $_SESSION["user_id"])) {
                    echo '<img src="img/delete.png" alt="Save icon. Click to save the post"
                    comment-id="' . $regComment["comment_id"] . '" onclick="deleteComment(event, this)">';
                }
                echo '</div>
            </div>
            </div>';
            }

            echo '</div>
            </div>';
        }

        ?>
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="scripts.js"></script>
</body>

</html>