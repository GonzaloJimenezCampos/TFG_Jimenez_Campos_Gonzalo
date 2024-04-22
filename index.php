<?php
include ('lib.php');
include ('config.php');

$connection = connect($server, $serveruser, $serverpassword, $PDOoptions);
$carrouselHeight = "900px";
$pagesTransform = "0";

if (isset($_GET["page"]) && $_GET["page"] == 1) {
    $carrouselHeight = "100%";
    $pagesTransform = "-100";
}

if (isset($_SESSION["user_id"])) {
    $sql = 'SELECT p.post_id, p.post_title, p.post_body, p.post_date, u.user_id, COALESCE(u.username, "[deleted]") AS username, COALESCE(u.profile_image, "img/profile.png") AS profile_image, COALESCE(lp.likes_count, 0) AS likes, COALESCE(lp.user_liked, 0) AS user_liked, COALESCE(sp.user_saved, 0) AS user_saved, COALESCE(c.comments_count, 0) AS comments_count FROM Posts p LEFT JOIN Users u ON p.user_id = u.user_id LEFT JOIN ( SELECT post_id, COUNT(*) AS likes_count, MAX(CASE WHEN user_id = ' . $_SESSION["user_id"] . ' THEN 1 ELSE 0 END) AS user_liked FROM LikedPosts GROUP BY post_id ) lp ON p.post_id = lp.post_id LEFT JOIN ( SELECT post_id, MAX(CASE WHEN user_id = ' . $_SESSION["user_id"] . ' THEN 1 ELSE 0 END) AS user_saved FROM SavedPosts WHERE user_id = ' . $_SESSION["user_id"] . ' GROUP BY post_id ) sp ON p.post_id = sp.post_id LEFT JOIN ( SELECT post_id, COUNT(*) AS comments_count FROM comments GROUP BY post_id ) c ON p.post_id = c.post_id ORDER BY p.post_date DESC;';
} else {
    $sql = 'SELECT p.post_id, p.post_title, p.post_body, p.post_date, COALESCE(u.username, "[deleted]") AS username, COALESCE(u.profile_image, "img/profile.png") AS profile_image, COUNT(lp.post_id) AS likes, 0 AS user_liked, 0 AS user_saved, COALESCE(c.comments_count, 0) AS comments_count FROM Posts p LEFT JOIN Users u ON p.user_id = u.user_id LEFT JOIN LikedPosts lp ON p.post_id = lp.post_id LEFT JOIN (SELECT post_id, COUNT(*) AS comments_count FROM comments GROUP BY post_id) c ON p.post_id = c.post_id GROUP BY p.post_id ORDER BY p.post_date DESC;';
}
$stmt = $connection->prepare($sql);
$stmt->execute();

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
    <link rel="stylesheet" href="css/index.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Karla:wght@400;700&family=Oswald:wght@400;700&display=swap"
        rel="stylesheet">
</head>

<body>
    <div w3-include-html="header.php"></div>
    <div class="container">
        <div class="pageSelector">
            <div class="pageOption active" onclick="showPage(0)">Analysis</a></div>
            <div class="pageOption" onclick="showPage(1)">Forum</a></div>
        </div>
        <div class="carrousel" id="carrousel" style="height:<?php echo $carrouselHeight ?>;">
            <div class="pages" style="transform: translateX(<?php echo $pagesTransform ?>%);">
                <div class="page" id="page1">
                    <div id="popupContainer" class="popupContainer">
                        <div id="popupContent" class="popupContent">
                            <span id="closePopup" class="closePopup">&times;</span>
                            <h2>Create a new post</h2>
                            <form id="postForm" class="postForm">
                                <label for="title">Title</label>
                                <input type="text" id="title" placeholder="Write the post's title here..." name="title"
                                    autocomplete="off" required>
                                <label for="title">Tags</label>
                                <div class="tagsPack">
                                    <div class="tagsSelection"><input type="text" class="tags" id="tags"
                                            oninput="searchTags(this)" placeholder="Search for tags..."
                                            autocomplete="off">
                                        <div class="autocomplete-items" id="autocomplete-items"></div>
                                    </div>
                                    <div class="selectedTags" id="selectedTags"></div>
                                </div>
                                <label for="body">Post body</label>
                                <textarea id="body" name="body" placeholder="Write what you want to share here..."
                                    required></textarea>
                                <button type="submit" onclick="createPost(event)">Publish</button>
                            </form>
                        </div>
                    </div>
                    <div class="logo"><img src="img/logo_placeholder.png" alt="FxLoL web logo"></div>
                    <div class="summonerSearch">
                        <form action="summoner_search.php" method="POST">
                            <select id="region" name="region">
                                <option value="volvo">EUW</option>
                                <option value="saab">NA</option>
                                <option value="mercedes">EUE</option>
                                <option value="audi">LAS</option>
                            </select>
                            <input type="text" name="summoner" id="summoner" placeholder="Summoner name + #Tag">
                            <a href="analysis_settings.html">Temporal link to access analysis settings</a>
                        </form>
                    </div>
                    <div class="analysesRecords">
                        <div class="analysis">
                            <div class="summonerInfo">
                                <div class="summonerAvatar"><img src="img/profile.png"></div>
                                <div class="summonerName">Ortega y Gasset</div>
                            </div>
                            <div class="analysisSubcategories">
                                <div class="farm">
                                    <div class="icon"><img src="img/profile.png" alt=""></div>
                                    <div class="score">50</div>
                                </div>
                                <div class="damage">
                                    <div class="icon"><img src="img/profile.png" alt=""></div>
                                    <div class="score">50</div>
                                </div>
                                <div class="objectives">
                                    <div class="icon"><img src="img/profile.png" alt=""></div>
                                    <div class="score">50</div>
                                </div>
                                <div class="vision">
                                    <div class="icon"><img src="img/profile.png" alt=""></div>
                                    <div class="score">50</div>
                                </div>
                                <div class="kda">
                                    <div class="icon"><img src="img/profile.png" alt=""></div>
                                    <div class="score">50</div>
                                </div>
                                <div class="winrate">
                                    <div class="icon"><img src="img/profile.png" alt=""></div>
                                    <div class="score">50%</div>
                                </div>
                            </div>
                            <div class="analysisScore">
                                <div class="icon"><img src="img/profile.png" alt=""></div>
                                <div class="score">50</div>
                            </div>
                        </div>
                        <div class="analysis">
                            <div class="summonerInfo">
                                <div class="summonerAvatar"><img src="img/profile.png"></div>
                                <div class="summonerName">Ortega y Gasset</div>
                            </div>
                            <div class="analysisSubcategories">
                                <div class="farm">
                                    <div class="icon"><img src="img/profile.png" alt=""></div>
                                    <div class="score">50</div>
                                </div>
                                <div class="damage">
                                    <div class="icon"><img src="img/profile.png" alt=""></div>
                                    <div class="score">50</div>
                                </div>
                                <div class="objectives">
                                    <div class="icon"><img src="img/profile.png" alt=""></div>
                                    <div class="score">50</div>
                                </div>
                                <div class="vision">
                                    <div class="icon"><img src="img/profile.png" alt=""></div>
                                    <div class="score">50</div>
                                </div>
                                <div class="kda">
                                    <div class="icon"><img src="img/profile.png" alt=""></div>
                                    <div class="score">50</div>
                                </div>
                                <div class="winrate">
                                    <div class="icon"><img src="img/profile.png" alt=""></div>
                                    <div class="score">50%</div>
                                </div>
                            </div>
                            <div class="analysisScore">
                                <div class="icon"><img src="img/profile.png" alt=""></div>
                                <div class="score">50</div>
                            </div>
                        </div>
                        <div class="analysis">
                            <div class="summonerInfo">
                                <div class="summonerAvatar"><img src="img/profile.png"></div>
                                <div class="summonerName">Ortega y Gasset</div>
                            </div>
                            <div class="analysisSubcategories">
                                <div class="farm">
                                    <div class="icon"><img src="img/profile.png" alt=""></div>
                                    <div class="score">50</div>
                                </div>
                                <div class="damage">
                                    <div class="icon"><img src="img/profile.png" alt=""></div>
                                    <div class="score">50</div>
                                </div>
                                <div class="objectives">
                                    <div class="icon"><img src="img/profile.png" alt=""></div>
                                    <div class="score">50</div>
                                </div>
                                <div class="vision">
                                    <div class="icon"><img src="img/profile.png" alt=""></div>
                                    <div class="score">50</div>
                                </div>
                                <div class="kda">
                                    <div class="icon"><img src="img/profile.png" alt=""></div>
                                    <div class="score">50</div>
                                </div>
                                <div class="winrate">
                                    <div class="icon"><img src="img/profile.png" alt=""></div>
                                    <div class="score">50%</div>
                                </div>
                            </div>
                            <div class="analysisScore">
                                <div class="icon"><img src="img/profile.png" alt=""></div>
                                <div class="score">50</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page" id="page2">
                    <div class="postHeader">
                        <div class="postSearch">
                            <div class="titleSearch">
                                <input type="text" name="postName" class="postName" id="postName"
                                    placeholder="Search post..." oninput="searchPosts(this)"
                                    onkeypress="searchPersonalTitlePost(event)">
                                <div class="autocomplete-posts" id="autocomplete-posts" style="display:none;"></div>
                            </div>
                            <div class="searchParameters">
                                <div class="order" id="orderSelect">Order by <select id="order" name="order"
                                        onchange="toggleDateLimit()">
                                        <option value="date">Most recent</option>
                                        <option value="likes">Most liked</option>
                                    </select>
                                </div>
                                <div class="dateLimit" id="dateLimit" style="display: none;"><select id="maxDate"
                                        name="maxDate" onchange="getPosts()">
                                        <option value="1">Today</option>
                                        <option value="7">Last week</option>
                                        <option value="30">Last month</option>
                                        <option value="365">Last year</option>
                                    </select>
                                </div>
                                <div class="arrow" id="arrow" style="display: none;" onclick="goBackPost()"><img
                                        src="img/backwardsArrow.png"
                                        alt="Arrow that you can click to go to the forum main page"></div>
                            </div>
                        </div>
                        <?php
                        if (isset($_SESSION["user_id"])) {
                            echo '<div class="seeSaved" id="seeSaved">
                            <input type="submit" class="savedButton" id="savedButton" onclick="getSavedPosts()" value="See saved posts">
                            </div>
                            <div class="seeMyPosts" id="seeMyPosts">
                            <input type="submit" class="myPostsButton" id="myPostsButton" onclick="getMyPosts()" value="See my posts">
                            </div>
                            <div class="createPost">
                            <input type="submit" class="postButton" id="openPopup" value="Write a post">
                        </div>';
                        } else {
                            echo '<div class="createPost"><a href="login.php">
                            <input type="submit" class="postButton" value="Log in to write a post">
                            </a>
                            </div>';
                        }
                        ?>
                    </div>
                    <div class="posts" id="posts">
                        <?php while ($reg = $stmt->fetch()) {
                            echo '<div class="post">
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
                                echo '<div class="postTag">' . $regTags["tag_name"] . '</div>';
                            }
                            echo '</div>
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
                                echo '<img src="img/like_' . $reg["user_liked"] . '.png" alt="Like icon. Click to like the post" 
                            post-id="' . $reg["post_id"] . '" post-liked="' . $reg["user_liked"] . '" onclick="changeLikeStatePost(event, this)">';
                            } else {
                                echo '<a href="login.php"><img src="img/like_0.png" alt="Like icon. Click to like the post"></a>';
                            }
                            echo '</div><div class="number">' . $reg["likes"] . '</div>
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
                                <div class="comment"><img src="img/comment.png" alt="Comment icon"></div>
                                <div class="number">' . $reg["comments_count"] . '</div>
                            </div>
                            <div class="delete">';
                            if ((isset($_SESSION["permissions"]) && $_SESSION["permissions"] == 1) || (isset($_SESSION["user_id"]) && $reg["user_id"] == $_SESSION["user_id"])) {
                                echo '<img src="img/delete.png" alt="Delete icon. Click to delete the post"
                                post-id="' . $reg["post_id"] . '" onclick="deletePost(event, this)">';
                            }
                            echo '</div>
                            </div></a></div>';
                        } ?>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.7.1.js"
            integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
        <script src="scripts.js"></script>
</body>

</html>