<?php
include ('config.php');
include ('lib.php');

$connection = connect($server, $serveruser, $serverpassword, $PDOoptions);
$postsHTML = '';


if (isset($_GET['order']) && $_GET['order'] == 'likes') {
    if (isset($_SESSION["user_id"])) {
        $sql = 'SELECT p.post_id, p.post_title, p.post_body, p.post_date, u.user_id, COALESCE(u.username, "[deleted]") AS username, COALESCE(u.profile_image, "img/profile.png") AS profile_image, COALESCE(lp.likes_count, 0) AS likes, COALESCE(lp.user_liked, 0) AS user_liked, COALESCE(sp.user_saved, 0) AS user_saved, COALESCE(c.comments_count, 0) AS comments_count FROM Posts p LEFT JOIN Users u ON p.user_id = u.user_id LEFT JOIN (SELECT post_id, COUNT(*) AS likes_count, MAX(CASE WHEN user_id = ' . $_SESSION["user_id"] . ' THEN 1 ELSE 0 END) AS user_liked FROM LikedPosts GROUP BY post_id ) lp ON p.post_id = lp.post_id LEFT JOIN (SELECT post_id, MAX(CASE WHEN user_id = ' . $_SESSION["user_id"] . ' THEN 1 ELSE 0 END) AS user_saved FROM SavedPosts WHERE user_id = ' . $_SESSION["user_id"] . ' GROUP BY post_id ) sp ON p.post_id = sp.post_id LEFT JOIN (SELECT post_id, COUNT(*) AS comments_count FROM comments GROUP BY post_id) c ON p.post_id = c.post_id WHERE p.post_date >= DATE_SUB(NOW(), INTERVAL ' . $_GET["dateLimit"] . ' DAY) ORDER BY likes DESC;';
    } else {
        $sql = 'SELECT p.post_id, p.post_title, p.post_body, p.post_date, COALESCE(u.username, "[deleted]") AS username, COALESCE(u.profile_image, "img/profile.png") AS profile_image, COUNT(lp.post_id) AS likes, 0 AS user_liked, 0 AS user_saved, COALESCE(c.comments_count, 0) AS comments_count FROM Posts p LEFT JOIN Users u ON p.user_id = u.user_id LEFT JOIN LikedPosts lp ON p.post_id = lp.post_id LEFT JOIN (SELECT post_id, COUNT(*) AS comments_count FROM comments GROUP BY post_id) c ON p.post_id = c.post_id WHERE p.post_date >= DATE_SUB(NOW(), INTERVAL ' . $_GET["dateLimit"] . ' DAY) GROUP BY p.post_id ORDER BY likes DESC;';
    }
} else if (isset($_GET['order']) && $_GET['order'] == 'date') {
    if (isset($_SESSION['user_id'])) {
        $sql = 'SELECT p.post_id, p.post_title, p.post_body, p.post_date, u.user_id, COALESCE(u.username, "[deleted]") AS username, COALESCE(u.profile_image, "img/profile.png") AS profile_image, COALESCE(lp.likes_count, 0) AS likes, COALESCE(lp.user_liked, 0) AS user_liked, COALESCE(sp.user_saved, 0) AS user_saved, COALESCE(c.comments_count, 0) AS comments_count FROM Posts p LEFT JOIN Users u ON p.user_id = u.user_id LEFT JOIN ( SELECT post_id, COUNT(*) AS likes_count, MAX(CASE WHEN user_id = ' . $_SESSION["user_id"] . ' THEN 1 ELSE 0 END) AS user_liked FROM LikedPosts GROUP BY post_id ) lp ON p.post_id = lp.post_id LEFT JOIN ( SELECT post_id, MAX(CASE WHEN user_id = ' . $_SESSION["user_id"] . ' THEN 1 ELSE 0 END) AS user_saved FROM SavedPosts WHERE user_id = ' . $_SESSION["user_id"] . ' GROUP BY post_id ) sp ON p.post_id = sp.post_id LEFT JOIN ( SELECT post_id, COUNT(*) AS comments_count FROM comments GROUP BY post_id ) c ON p.post_id = c.post_id ORDER BY p.post_date DESC;';
    } else {
        $sql = 'SELECT p.post_id, p.post_title, p.post_body, p.post_date, COALESCE(u.username, "[deleted]") AS username, COALESCE(u.profile_image, "img/profile.png") AS profile_image, COUNT(lp.post_id) AS likes, 0 AS user_liked, 0 AS user_saved, COALESCE(c.comments_count, 0) AS comments_count FROM Posts p LEFT JOIN Users u ON p.user_id = u.user_id LEFT JOIN LikedPosts lp ON p.post_id = lp.post_id LEFT JOIN (SELECT post_id, COUNT(*) AS comments_count FROM comments GROUP BY post_id) c ON p.post_id = c.post_id GROUP BY p.post_id ORDER BY p.post_date DESC;';
    }
} else if (isset($_GET['order']) && $_GET['order'] == 'saved') {
    $sql = 'SELECT p.post_id, p.post_title, p.post_body, p.post_date, u.user_id, COALESCE(u.username, "[deleted]") AS username, COALESCE(u.profile_image, "img/profile.png") AS profile_image, COALESCE(lp.likes_count, 0) AS likes, COALESCE(lp.user_liked, 0) AS user_liked, COALESCE(sp.user_saved, 0) AS user_saved, COALESCE(c.comments_count, 0) AS comments_count FROM Posts p LEFT JOIN Users u ON p.user_id = u.user_id LEFT JOIN (SELECT post_id, COUNT(*) AS likes_count, MAX(CASE WHEN user_id = ' . $_SESSION["user_id"] . ' THEN 1 ELSE 0 END) AS user_liked FROM LikedPosts GROUP BY post_id) lp ON p.post_id = lp.post_id LEFT JOIN (SELECT post_id, MAX(CASE WHEN user_id = ' . $_SESSION["user_id"] . ' THEN 1 ELSE 0 END) AS user_saved FROM SavedPosts WHERE user_id = ' . $_SESSION["user_id"] . ' GROUP BY post_id) sp ON p.post_id = sp.post_id LEFT JOIN (SELECT post_id, COUNT(*) AS comments_count FROM comments GROUP BY post_id) c ON p.post_id = c.post_id WHERE user_saved = 1 ORDER BY p.post_date DESC;';
} else if (isset($_GET['order']) && $_GET['order'] == 'autoComplete') {
    $sql = 'SELECT p.post_id, p.post_title, p.post_body, p.post_date, u.user_id, COALESCE(u.username, "[deleted]") AS username, COALESCE(u.profile_image, "img/profile.png") AS profile_image, COALESCE(lp.likes_count, 0) AS likes, COALESCE(lp.user_liked, 0) AS user_liked, COALESCE(sp.user_saved, 0) AS user_saved, COALESCE(c.comments_count, 0) AS comments_count FROM Posts p LEFT JOIN Users u ON p.user_id = u.user_id LEFT JOIN (SELECT post_id, COUNT(*) AS likes_count, MAX(CASE WHEN user_id = ' . $_SESSION["user_id"] . ' THEN 1 ELSE 0 END) AS user_liked FROM LikedPosts GROUP BY post_id) lp ON p.post_id = lp.post_id LEFT JOIN (SELECT post_id, MAX(CASE WHEN user_id = ' . $_SESSION["user_id"] . ' THEN 1 ELSE 0 END) AS user_saved FROM SavedPosts WHERE user_id = ' . $_SESSION["user_id"] . ' GROUP BY post_id) sp ON p.post_id = sp.post_id LEFT JOIN (SELECT post_id, COUNT(*) AS comments_count FROM comments GROUP BY post_id) c ON p.post_id = c.post_id WHERE p.post_title LIKE "%' . $_GET["title"] . '%" ORDER BY p.post_date DESC;';
}else if (isset($_GET['order']) && $_GET['order'] == 'myPosts') {
    $sql = 'SELECT p.post_id, p.post_title, p.post_body, p.post_date, u.user_id, COALESCE(u.username, "[deleted]") AS username, COALESCE(u.profile_image, "img/profile.png") AS profile_image, COALESCE(lp.likes_count, 0) AS likes, COALESCE(lp.user_liked, 0) AS user_liked, COALESCE(sp.user_saved, 0) AS user_saved, COALESCE(c.comments_count, 0) AS comments_count FROM Posts p LEFT JOIN Users u ON p.user_id = u.user_id LEFT JOIN (SELECT post_id, COUNT(*) AS likes_count, MAX(CASE WHEN user_id = ' . $_SESSION["user_id"] . ' THEN 1 ELSE 0 END) AS user_liked FROM LikedPosts GROUP BY post_id) lp ON p.post_id = lp.post_id LEFT JOIN (SELECT post_id, MAX(CASE WHEN user_id = ' . $_SESSION["user_id"] . ' THEN 1 ELSE 0 END) AS user_saved FROM SavedPosts WHERE user_id = ' . $_SESSION["user_id"] . ' GROUP BY post_id) sp ON p.post_id = sp.post_id LEFT JOIN (SELECT post_id, COUNT(*) AS comments_count FROM comments GROUP BY post_id) c ON p.post_id = c.post_id WHERE u.user_id = '. $_SESSION["user_id"] .' ORDER BY p.post_date DESC;';
}

$stmt = $connection->prepare($sql);
$stmt->execute();

while ($reg = $stmt->fetch()) {
    $postsHTML .= '<div class="post">
    <a href="post.php?post=' . $reg["post_id"] . '">
    <div class="postInfo">
    <div class="userInfo">
        <div class="avatar"><img src="' . $reg["profile_image"] . '" alt="Original poster avatar"></div>
        <div class="postUsername">' . $reg["username"] . '</div>
        <div class="postTags">';
    $sqlTags = "SELECT tag_name FROM Tags WHERE tag_id in (SELECT tag_id FROM TagsPosts WHERE post_id=" . $reg["post_id"] . ")";
    $stmtTags = $connection->prepare($sqlTags);
    $stmtTags->execute();
    while ($regTags = $stmtTags->fetch()) {
        $postsHTML .= '<div class="postTag">' . $regTags["tag_name"] . '</div>';
    }
    $postsHTML .= '</div>
    </div>
    <div class="pubDate">' . $reg["post_date"] . '</div>
</div>
<div class="title">
    <h2>' . $reg["post_title"] . '</h2>
</div>
<div class="postBody">
    ' . $reg["post_body"] . '
</div>
<div class="interactions">
    <div class="likes">
    <div class="heart">';
    if (isset($_SESSION["user_id"])) {
        $postsHTML .= '<img src="img/like_' . $reg["user_liked"] . '.png" alt="Like icon. Click to like the post" 
    post-id="' . $reg["post_id"] . '" post-liked="' . $reg["user_liked"] . '" onclick="changeLikeStatePost(event, this)">';
    } else {
        $postsHTML .= '<a href="login.php"><img src="img/like_0.png" alt="Like icon. Click to like the post"></a>';
    }
    $postsHTML .= '</div><div class="number">' . $reg["likes"] . '</div>
    </div>
    <div class="save">';
    if (isset($_SESSION["user_id"])) {
        $postsHTML .= '<img src="img/save_' . $reg["user_saved"] . '.png" alt="Save icon. Click to save the post"
        post-id="' . $reg["post_id"] . '" post-saved="' . $reg["user_saved"] . '" onclick="changeSaveStatePost(event, this)">';
    } else {
        $postsHTML .= '<a href="login.php"><img src="img/save_0.png" alt="Save icon. Click to save the post"></a>';
    }
    $postsHTML .= '</div>
    <div class="comments">
        <div class="comment"><img src="img/comment.png" alt="Comment icon"></div>
        <div class="number">' . $reg["comments_count"] . '</div>
    </div>
    <div class="delete">';
    if ((isset($_SESSION["permissions"]) && $_SESSION["permissions"] == 1) || (isset($_SESSION["user_id"]) && $reg["user_id"] == $_SESSION["user_id"])) {
        $postsHTML .= '<img src="img/delete.png" alt="Delete icon. Click to delete the post"
        post-id="' . $reg["post_id"] . '" onclick="deletePost(event, this)">';
    }
    $postsHTML .= '</div>
    </div></a></div>';
}

echo $postsHTML;