<?php
function getCategoryLevel($score)
{

    if ($score < 20) {
        $category = "IRON";
    } else if ($score < 40) {
        $category = "BRONZE";
    } else if ($score < 60) {
        $category = "SILVER";
    } else if ($score < 75) {
        $category = "GOLD";
    } else if ($score < 85) {
        $category = "MASTER";
    } else {
        $category = "GRANDMASTER";
    }

    return $category;
}

function getTipLevel($score, $lowScore, $averageScore, $contentArray, $analysisContentArray)
{
    if ($_GET[$score] < $lowScore) {
        $content = $analysisContentArray[$contentArray[0]];
    } else if ($_GET[$score] >= $lowScore && $_GET[$score] <= $averageScore) {
        $content = $analysisContentArray[$contentArray[1]];
    } else {
        $content = $analysisContentArray[$contentArray[2]];
    }

    return $content;
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
    <link rel="stylesheet" href="css/analysis_breakdown.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Karla:wght@400;700&family=Oswald:wght@400;700&display=swap"
        rel="stylesheet">
</head>

<body>
    <div class="container">
        <?php

        $analysisContent = file_get_contents('analysis_explanations.txt');
        $analysisContentArray = json_decode($analysisContent, true);
        if (isset($_GET["error"]) && $_GET["error"] = 404) {
            echo '<div class="error"><h2>ERROR 404: NO MATCHES FOUND</h2><p>There were no matchs found for the settings you specified</p></div>';
        } else {
            echo '
            <div class="generalScore">
                <img src="img/categories/101108-' . getCategoryLevel($_GET["totalScore"]) . '.png" alt="">
                <h1>TOTAL SCORE</h1>
                <p>' . getTipLevel("totalScore", 50, 75, ["totalBad", "totalAverage", "totalGood"], $analysisContentArray) . '</p>
            <div class="score"><h2>' . $_GET["totalScore"] . '</h2></div>
            </div>
            <div class="categories">
                <div class="category">
                    <img src="img/categories/202305-' . getCategoryLevel($_GET["gold"]) . '.png" alt="">
                    <h2>GOLD EARNING</h2>
                    <p>' . getTipLevel("farmPerMinute", 30, 45, ["badFarm", "averageFarm", "goodFarm"], $analysisContentArray);

            if ($_GET["farmPerMinute"] < 30 && $_GET["goldPerMinute"] < 20) {
                echo $analysisContentArray["goldBadBad"];
            } else if ($_GET["farmPerMinute"] < 30 && $_GET["goldPerMinute"] >= 20) {
                echo $analysisContentArray["goldBadGood"];
            } else if ($_GET["farmPerMinute"] >= 30 && $_GET["goldPerMinute"] < 20) {
                echo $analysisContentArray["goldGoodBad"];
            } else {
                echo $analysisContentArray["goldGoodGood"];
            }

            if ($_GET["goldPerMinute"] < 20) {
                echo $analysisContentArray["goldEarnedBad"] . '</p>';
            } else {
                echo $analysisContentArray["goldEarnedGood"] . '</p>';
            }

            echo '<p>';

            if ($_GET["farmPerMinute"] < 30) {
                echo $analysisContentArray["goldTipBadFarm"];
            } else if ($_GET["farmPerMinute"] >= 30 && $_GET["farmPerMinute"] <= 45) {
                echo $analysisContentArray["goldTipDecentFarm"];
            }

            if ($_GET["goldPerMinute"] < 20) {
                echo $analysisContentArray["goldTipBadGold"];
            }

            echo '</p>
            
            <div class="score"><h2>' . $_GET["gold"] . '</h2></div>
                </div>
                <div class="category">
                    <img src="img/categories/101101-' . getCategoryLevel($_GET["damage"]) . '.png" alt="">
                    <h2>DAMAGE</h2>
                    <p>' . getTipLevel("damage", 50, 75, ["damageChampionsBad", "damageChampionsAverage", "damageChampionsGood"], $analysisContentArray) . '</p>
                <div class="score"><h2>' . $_GET["damage"] . '</h2></div>
                </div>
                <div class="category">
                    <img src="img/categories/301106-' . getCategoryLevel($_GET["objectives"]) . '.png" alt="">
                    <h2>OBJECTIVES</h2>
                    <p>' . getTipLevel("objectives", 50, 75, ["objectivesBad", "objectivesAverage", "objectivesGood"], $analysisContentArray) . '</p>
                <div class="score"><h2>' . $_GET["objectives"] . '</h2></div>
                </div>
                <div class="category">
                    <img src="img/categories/204102-' . getCategoryLevel($_GET["vision"]) . '.png" alt="">
                    <h2>VISION</h2>
                    <p>' . getTipLevel("vision", 50, 75, ["visionBad", "visionAverage", "visionGood"], $analysisContentArray) . '</p>
                <div class="score"><h2>' . $_GET["vision"] . '</h2></div>
                </div>
                <div class="category">
                    <img src="img/categories/201003-' . getCategoryLevel($_GET["kda"]) . '.png" alt="">
                    <h2>KDA</h2>
                    <p>' . getTipLevel("killParticipation", 35, 52, ["kpBad", "kpAverage", "kpGood"], $analysisContentArray);

            if ($_GET["killParticipation"] < 35 || $_GET["deathScore"] < 15) {
                echo $analysisContentArray["kdaBadConnector"];
            } else {
                echo $analysisContentArray["kdaGoodConnector"];
            }
            echo getTipLevel("deathScore", 15, 22, ["deathsBad", "deathsAverage", "deathsGood"], $analysisContentArray). '</p>

            <p>';

            if ($_GET["killParticipation"] < 35 && $_GET["deathScore"] > 22) {
                echo $analysisContentArray["kdaInactiveTip"];
            } else {
                if ($_GET["killParticipation"] < 35) {
                    echo $analysisContentArray["kdaKpBadTip"];
                }
                if ($_GET["deathScore"] < 15) {
                    echo $analysisContentArray["kdaDeathBadTip"];
                }
            }

            echo '</p>';

            echo '<div class="score"><h2>' . $_GET["kda"] . '</h2></div>
                </div>
                <div class="category">
                    <img src="img/categories/303203-' . getCategoryLevel($_GET["winrate"]) . '.png" alt="">
                    <h2>WINRATE</h2>';
            echo '<p>' . str_replace("[REPLACEME]", ($_GET["winrate"] > 49 ? "right" : "wrong"), $analysisContentArray["winrate"]) . '</p>';
            echo '<div class="score"><h2>' . $_GET["winrate"] . '%</h2></div>
                </div>
            </div>';
        }
        ?>
        <a href="index.php?page=0" class="button">CONTINUE</a>
    </div>
</body>

</html>