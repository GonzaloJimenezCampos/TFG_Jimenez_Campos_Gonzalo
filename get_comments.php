<?php
include ('config.php');
include ('lib.php');

$connection = connect($server, $serveruser, $serverpassword, $PDOoptions);
$commentsHTML = '';


if (isset($_GET['order']) && $_GET['order'] == 'likes') {
    $sql = 'SELECT c.comment_id, c.comment_date, c.comment_body, u.user_id, COALESCE(u.username, "[deleted]") AS username, COALESCE(u.profile_image, "img/profile.png") AS profile_image, 
    c.post_id, IF(lc.user_id IS NOT NULL, 1, 0) AS user_liked, COALESCE(lc_count.likes_count, 0) AS likes FROM Comments c LEFT JOIN Users u ON c.user_id = u.user_id 
    LEFT JOIN LikedComments lc ON c.comment_id = lc.comment_id AND lc.user_id = :user_id
    LEFT JOIN (SELECT comment_id, COUNT(*) AS likes_count FROM LikedComments GROUP BY comment_id) AS lc_count ON c.comment_id = lc_count.comment_id WHERE c.post_id = :post_id ORDER BY likes DESC;';
} else if (isset($_GET['order']) && $_GET['order'] == 'date') {
    $sql = 'SELECT c.comment_id, c.comment_date, c.comment_body, u.user_id, COALESCE(u.username, "[deleted]") AS username, COALESCE(u.profile_image, "img/profile.png") AS profile_image, 
        c.post_id, IF(lc.user_id IS NOT NULL, 1, 0) AS user_liked, COALESCE(lc_count.likes_count, 0) AS likes FROM Comments c LEFT JOIN Users u ON c.user_id = u.user_id 
        LEFT JOIN LikedComments lc ON c.comment_id = lc.comment_id AND lc.user_id = :user_id
        LEFT JOIN (SELECT comment_id, COUNT(*) AS likes_count FROM LikedComments GROUP BY comment_id) AS lc_count ON c.comment_id = lc_count.comment_id WHERE c.post_id = :post_id ORDER BY c.comment_date DESC;';
}

$stmt = $connection->prepare($sql);
$stmt->bindParam(':user_id', $_SESSION["user_id"], PDO::PARAM_STR);
$stmt->bindParam(':post_id', $_GET["post"], PDO::PARAM_STR);
$stmt->execute();

while ($regComment = $stmt->fetch()) {
    $commentsHTML .= '<div class="post comment">
<div class="postInfo">
    <div class="userInfo">
        <div class="avatar"><img src="' . $regComment["profile_image"] . '" alt="Avatar of the user that made the comment"></div>
        <div class="postUsername">' . $regComment["username"] . '</div>
    </div>
    <div class="pubDate">' . $regComment["comment_date"] . '</div>
</div>
<div class="postBody">' . $regComment["comment_body"] . '</div>
<div class="interactions">
    <div class="likes">
        <div class="heart">';
    if (isset($_SESSION["user_id"])) {
        $commentsHTML .= '<img src="img/like_' . $regComment["user_liked"] . '.png" alt="Like icon. Click to like the post" 
        comment-id="' . $regComment["comment_id"] . '" comment-liked="' . $regComment["user_liked"] . '" onclick="changeLikeStateComment(event, this)">';
    } else {
        $commentsHTML .= '<a href="login.php"><img src="img/like_0.png" alt="Like icon. Click to like the post"></a>';
    }
    $commentsHTML .= '</div>
    <div class="number">' . $regComment["likes"] . '</div>
</div>
<div class="delete">';
    if ((isset($_SESSION["permissions"]) && $_SESSION["permissions"] == 1) || (isset($_SESSION["user_id"]) && $regComment["user_id"] == $_SESSION["user_id"])) {
        $commentsHTML .= '<img src="img/delete.png" alt="Save icon. Click to save the post"
        comment-id="' . $regComment["comment_id"] . '" onclick="deleteComment(event, this)">';
    }
    $commentsHTML .= '</div>
</div>
</div>';
}

echo $commentsHTML;