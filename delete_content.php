<?php
$controla = true;
include ('config.php');
include ('lib.php');

$connection = connect($server, $serveruser, $serverpassword, $PDOoptions);

if (isset($_POST['comment'])) {
    $deleteQuery = "INSERT INTO messages (message, message_date, message_read, sender_id, receiver_id)
    SELECT CONCAT('I deleted your comment ', 
              CASE WHEN CHAR_LENGTH(comment_body) > 30 THEN CONCAT('\"', LEFT(comment_body, 30), '...\"') ELSE CONCAT('\"', comment_body, '\"') END,
              ' in the post \"', p.post_title, '\"') AS message,
           NOW() AS message_date,
           0 as message_read,
           ".$_SESSION["user_id"]." AS sender_id,
           c.user_id AS receiver_id
    FROM comments c
    INNER JOIN posts p ON c.post_id = p.post_id
    WHERE c.comment_id = :id AND c.user_id IS NOT NULL;
    DELETE FROM LikedComments WHERE comment_id=:id;
    DELETE FROM Comments WHERE comment_id=:id;";
    $id = $_POST['comment'];
} else if (isset($_POST['post'])) {
    $deleteQuery = "INSERT INTO messages (message, message_date, message_read, sender_id, receiver_id)
    SELECT CONCAT('Your comment ', 
                 CASE WHEN CHAR_LENGTH(comment_body) > 30 THEN CONCAT('\"', LEFT(comment_body, 30), '...\"') ELSE CONCAT('\"', comment_body, '\"') END,
                 ' in the post \"', p.post_title, '\" was deleted. This comment was deleted because the post which contained it was deleted') AS message,
           NOW() AS message_date,
           0 as message_read,
           ".$_SESSION["user_id"]." AS sender_id,
           c.user_id AS receiver_id
    FROM comments c
    INNER JOIN posts p ON c.post_id = p.post_id
    WHERE c.post_id = :id AND c.user_id IS NOT NULL;
    
    INSERT INTO messages (message, message_date, sender_id, receiver_id)
    SELECT CONCAT('I deleted your post \"', p.post_title, '\"') AS message,
           NOW() AS message_date,
           ".$_SESSION["user_id"]." AS sender_id,
           p.user_id AS receiver_id
    FROM posts p
    WHERE p.post_id = :id AND p.user_id IS NOT NULL;
    
    DELETE FROM LikedComments WHERE comment_id IN (SELECT comment_id FROM Comments WHERE post_id = :id);
    DELETE FROM Comments WHERE post_id = :id;
    DELETE FROM LikedComments WHERE comment_id in (SELECT comment_id FROM Comments WHERE post_id=:id);
    DELETE FROM Comments WHERE comment_id in (SELECT comment_id FROM Comments WHERE post_id=:id);
    DELETE FROM LikedPosts WHERE post_id=:id;
    DELETE FROM SavedPosts WHERE post_id=:id;
    DELETE FROM TagsPosts WHERE post_id=:id;
    DELETE FROM Posts WHERE post_id=:id;";
    $id = $_POST['post'];
}
$deleteStmt = $connection->prepare($deleteQuery);
$deleteStmt->bindParam(':id', $id, PDO::PARAM_STR);
$deleteStmt->execute();