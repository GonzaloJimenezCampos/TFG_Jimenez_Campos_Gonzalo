<?php
$controla = true;
include ('lib.php');
include ('config.php');

$connection = connect($server, $serveruser, $serverpassword, $PDOoptions);
$sqlDelete = 'DELETE FROM likedcomments WHERE user_id=:user_id;
DELETE FROM likedposts WHERE user_id=:user_id;
DELETE FROM savedposts WHERE user_id=:user_id;';

if (isset($_POST["hard"]) && $_POST["hard"] == 1) {
    $sqlDelete .= "INSERT INTO messages (message, message_date, message_read, sender_id, receiver_id)
    SELECT CONCAT('Your comment ', 
    CASE WHEN CHAR_LENGTH(c.comment_body) > 30 THEN CONCAT('\"', LEFT(c.comment_body, 30), '...\"') ELSE CONCAT('\"', c.comment_body, '\"') END,
    ' in the post \"', p.post_title, '\" was deleted. This comment was deleted because the account associated with it is being deleted.') AS message,
    NOW() AS message_date,
    0 as message_read,
    :user_id AS sender_id,
    c.user_id AS receiver_id
    FROM comments c
    INNER JOIN posts p ON c.post_id = p.post_id
    WHERE p.user_id = :user_id;
    DELETE FROM likedcomments WHERE comment_id in (SELECT comment_id FROM comments WHERE user_id=:user_id);
    DELETE FROM likedcomments WHERE comment_id in (SELECT comment_id FROM comments WHERE post_id in (SELECT post_id FROM posts WHERE user_id=:user_id));
    DELETE FROM comments WHERE post_id in (SELECT post_id FROM posts WHERE user_id=:user_id);
    DELETE FROM comments WHERE user_id=:user_id;
    DELETE FROM likedposts WHERE post_id in (SELECT post_id FROM posts WHERE user_id=:user_id);
    DELETE FROM savedposts WHERE post_id in (SELECT post_id FROM posts WHERE user_id=:user_id);
    DELETE FROM TagsPosts WHERE post_id in (SELECT post_id FROM posts WHERE user_id=:user_id);
    DELETE FROM posts WHERE user_id=:user_id;";
} else {
    $sqlDelete .= 'UPDATE posts SET user_id=NULL WHERE user_id=:user_id;
    UPDATE comments SET user_id=NULL WHERE user_id=:user_id;';
}

if($_SESSION["user_id"]){

}

$sqlDelete .= 'DELETE FROM messages WHERE receiver_id = :user_id;
UPDATE messages SET sender_id = NULL WHERE sender_id = :user_id;
DELETE FROM users WHERE user_id=:user_id;';
$stmtDelete = $connection->prepare($sqlDelete);
$stmtDelete->bindParam(':user_id', $_SESSION["user_id"], PDO::PARAM_STR);
$stmtDelete->execute();
