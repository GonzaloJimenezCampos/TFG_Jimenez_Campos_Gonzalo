<?php
include ('lib.php');
include ('config.php');

$connection = connect($server, $serveruser, $serverpassword, $PDOoptions);
$carrouselHeight = "900px";
$pagesTransform = "0";
$alert = "";

if (isset($_GET["alert"])) {
    if ($_GET["alert"] == "401Search") {
        $alert = "<script> customAlert('Unathorized access to summoner search - Error 401', 0) </script>";
    } else if ($_GET["alert"] == "404Search") {
        $alert = "<script> customAlert('Summoner " . $_GET['username'] . " not found', 0) </script>";
    } else if ($_GET["alert"] == "404Region") {
        $alert = "<script> customAlert('Summoner " . $_GET['username'] . " exists, but the region is incorrect', 2) </script>";
    }
}

if (isset($_GET["page"]) && $_GET["page"] == 1) {
    $carrouselHeight = "100%";
    $pagesTransform = "-100";
}

if (isset($_GET["postPage"])) {
    $actualPage = $_GET["postPage"];
} else {
    
}

$actualPage = 1;
$initialPostSearch = 25;

$sqlPostAmount = 'SELECT COUNT(1) AS postNumber FROM Posts';
$stmtPostAmount = $connection->prepare($sqlPostAmount);
$stmtPostAmount->execute();
$postCount = $stmtPostAmount->fetch();
$totalPostPages = ceil($postCount["postNumber"] / $initialPostSearch);
$postScript = "<script> getPosts(" . $initialPostSearch . ", " . $actualPage . ") </script>";


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
    <title>Gonzalo Jiménez - Porfolio</title>
    <link rel="stylesheet" href="css/css-reset.css">
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Karla:wght@400;700&family=Oswald:wght@400;700&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nabla&display=swap" rel="stylesheet">
</head>

<body>
    <div class="alerts" id="alerts">
    </div>
    <div class="wrapper">
        <header>
            <i class="bx bx-cookie"></i>
            <h2>Consentimiento de las cookies</h2>
        </header>

        <div class="data">
            <p>Este sitio web utiliza cookies para ayudarte a tener una experiencia de navegación superior y más
                relevante en el sitio web.</p>
        </div>

        <div class="buttons">
            <button class="button" id="acceptBtn">Aceptar</button>
            <button class="button">Declinar</button>
        </div>
    </div>
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
                                    autocomplete="off" maxlength="50" required>
                                <label for="title">Tags</label>
                                <div class="tagsPack">
                                    <div class="tagsSelection"><input type="text" class="tags" id="tags"
                                            oninput="searchTags(this)" placeholder="Search for tags..."
                                            autocomplete="off" maxlength="30">
                                        <div class="autocomplete-items" id="autocomplete-items"></div>
                                    </div>
                                    <div class="selectedTags" id="selectedTags"></div>
                                </div>
                                <label for="body">Post body</label>
                                <textarea id="body" name="body" placeholder="Write what you want to share here..."
                                    maxlength="2000" required></textarea>
                                <button type="submit" onclick="createPost(event)">Publish</button>
                            </form>
                        </div>
                    </div>
                    <div class="nabla-logo logo">F(x)LoL</div>
                    <div class="summonerSearch">
                        <select id="region" name="region">
                            <option value="euw1">EUW</option>
                            <option value="na1">NA</option>
                            <option value="eune1">EUNE</option>
                            <option value="la1">LAN</option>
                            <option value="la2">LAS</option>
                        </select>
                        <div class="separator"></div>
                        <input type="text" name="summoner" id="summoner" placeholder="Summoner name + #Tag"
                            onkeypress="checkUserExistance(event)" autocomplete="off">
                    </div>
                    <div class="analysesRecords">
                        <?php

                        if (isset($_SESSION["user_id"])) {
                            $sqlRecord = "SELECT * FROM records WHERE user_id = " . $_SESSION["user_id"] . " ORDER BY record_date DESC LIMIT 5";
                            $stmtRecord = $connection->prepare($sqlRecord);
                            $stmtRecord->execute();

                            function getCategoryLevel($score)
                            {
                                switch ($score) {
                                    case ($score < 20):
                                        $category = "IRON";
                                        break;
                                    case ($score < 40):
                                        $category = "BRONZE";
                                        break;
                                    case ($score < 60):
                                        $category = "SILVER";
                                        break;
                                    case ($score < 75):
                                        $category = "GOLD";
                                        break;
                                    case ($score < 85):
                                        $category = "MASTER";
                                        break;
                                    default:
                                        $category = "GRANDMASTER";
                                        break;

                                }
                                return $category;
                            }

                            $i = 0;
                            while ($regRecord = $stmtRecord->fetch()) {
                                echo '<div class="analysis">
                            <div class="summonerInfo">
                                <div class="summonerAvatar"><img src="img/profileicon/' . $_SESSION["records"][$i][0] . '.png"></div>
                                <div class="summonerName">' . $_SESSION["records"][$i][1] . '</div>
                            </div>
                            <div class="analysisSubcategories">
                                <div class="damage">
                                    <div class="icon"><img src="img/categories/101101-' . getCategoryLevel($regRecord["damage"]) . '.png" alt=""></div>
                                    <div class="score">' . $regRecord["damage"] . '</div>
                                </div>
                                <div class="objectives">
                                    <div class="icon"><img src="img/categories/301106-' . getCategoryLevel($regRecord["objectives"]) . '.png" alt=""></div>
                                    <div class="score">' . $regRecord["objectives"] . '</div>
                                </div>
                                <div class="vision">
                                    <div class="icon"><img src="img/categories/204102-' . getCategoryLevel($regRecord["vision"]) . '.png" alt=""></div>
                                    <div class="score">' . $regRecord["vision"] . '</div>
                                </div>
                                <div class="kda">
                                    <div class="icon"><img src="img/categories/201003-' . getCategoryLevel($regRecord["kda"]) . '.png" alt=""></div>
                                    <div class="score">' . $regRecord["kda"] . '</div>
                                </div>
                                <div class="farm">
                                    <div class="icon"><img src="img/categories/202305-' . getCategoryLevel($regRecord["gold"]) . '.png" alt=""></div>
                                    <div class="score">' . $regRecord["gold"] . '</div>
                                </div>
                                <div class="winrate">
                                    <div class="icon"><img src="img/categories/303203-' . getCategoryLevel($regRecord["winrate"]) . '.png" alt=""></div>
                                    <div class="score">' . $regRecord["winrate"] . '%</div>
                                </div>
                            </div>
                            <div class="analysisScore">
                                <div class="icon"><img src="img/categories/101108-' . getCategoryLevel($regRecord["score"]) . '.png" alt=""></div>
                                <div class="score">' . $regRecord["score"] . '</div>
                            </div>
                        </div>';
                                $i++;
                            }
                            if ($i == 0) {
                                echo '<h2>No analysis here yet...</h2><br><p>Search for a summoner and analyze their gameplay!</p>';
                            }
                        } else {
                            echo '<h2>No analysis here yet...</h2><br><p>Log in and start analyzing summoners!</p>';
                        }
                        ?>
                    </div>
                </div>
                <div class="page" id="page2">
                    <div class="postHeader">
                        <div class="postSearch">
                            <div class="titleSearch">
                                <input type="text" name="postName" class="postName" id="postName"
                                    placeholder="Search post..." oninput="searchPosts(this)"
                                    onkeypress="searchPersonalTitlePost(event)" autocomplete="off">
                                <div class="autocomplete-posts" id="autocomplete-posts" style="display:none;"></div>
                            </div>
                            <div class="searchParameters">
                                <div class="order" id="orderSelect">Order by <select id="order" name="order"
                                        class="postOrder" onchange="toggleDateLimit()">
                                        <option value="date">Most recent</option>
                                        <option value="likes">Most liked</option>
                                    </select>
                                </div>
                                <div class="dateLimit" id="dateLimit" style="display: none;"><select id="maxDate"
                                        name="maxDate" onchange="getPosts(25,1,null, null)">
                                        <option value="1">Today</option>
                                        <option value="7">Last week</option>
                                        <option value="30">Last month</option>
                                        <option value="365">Last year</option>
                                    </select>
                                </div>
                                <div class="arrow" id="arrow" style="display: none;" onclick="goBackPost()"><img
                                        src="img/cursor.png"
                                        alt="Arrow that you can click to go to the forum main page"></div>
                            </div>
                        </div>
                        <?php
                        if (isset($_SESSION["user_id"])) {
                            echo '<div class="seeSaved" id="seeSaved">
                                <input type="submit" class="savedButton" id="savedButton" onclick="getPosts(25,1,\'saved\', null)" value="See saved posts">
                            </div>
                            <div class="seeMyPosts" id="seeMyPosts">
                                <input type="submit" class="myPostsButton" id="myPostsButton" onclick="getPosts(25,1,\'myPosts\', null)" value="See my posts">
                            </div>
                            <div class="createPost">
                                <input type="submit" class="postButton" id="openPopup" onclick="openPopUp()" value="Write a post">
                            </div>
                            <div class="hamburgerButton" id="hamburgerButton">
                                <img src="img/burgerButton.png" onclick="burgerMenu()">
                                <div class="hamburgerOptions">
                                    <input type="submit" class="savedButton" id="savedButton" onclick="getPosts(25,1,\'saved\', null)" value="See saved posts" style="display: none;">
                                    <input type="submit" class="myPostsButton" id="myPostsButton" onclick="getPosts(25,1,\'myPosts\', null)" value="See my posts" style="display: none;">
                                    <input type="submit" class="postButton" id="openPopup" onclick="openPopUp()" value="Write a post" style="display: none;">
                                </div>
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
                    </div>
                    <p class="returnSearch">Not finding what you are looking for? <span onclick="scrollToTop()">Return to the Searchbar</span></p>
                </div>
            </div>
        </div>
        </div>
        <div w3-include-html="footer.html"></div>
        <script src="https://code.jquery.com/jquery-3.7.1.js"
            integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
        <script src="scripts.js"></script>
        <script>
            const cookieBox = document.querySelector(".wrapper"),
                buttons = document.querySelectorAll(".button");

            const executeCodes = () => {
                if (!document.cookie.includes("cookie_accepted=true")) {
                    cookieBox.classList.add("show");
                    cookieBox.style.display = "block";
                }

                buttons.forEach((button) => {
                    button.addEventListener("click", () => {
                        cookieBox.classList.remove("show");
                        cookieBox.style.display = "none";

                        if (button.id == "acceptBtn") {
                            document.cookie = "cookie_accepted=true; max-age=" + 60 * 60 * 24 * 30;
                        }
                    });
                });
            };

            window.addEventListener("load", executeCodes);

        </script>
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <?php echo $postScript ?>
        <?php echo $alert ?>
        
</body>

</html>