<?php

include ("helpers.php");

if (isset($_GET["username"]) && isset($_GET["regionCode"])) {
    $summonerName = urldecode($_GET["username"]);
    $regionCode = $_GET["regionCode"];
    $region = "europe";
    $summoner = getSummoner($summonerName, $region);

    $accountId = getAccountId($summoner["puuid"], $regionCode)["id"];

    $summonerRank = getSummonerRanks($accountId, $regionCode);
    $soloQueue = -1;
    $flexQueue = -1;

    for ($i = 0; $i < count($summonerRank); $i++) {
        $queue = $summonerRank[$i]["queueType"];
        switch ($queue) {
            case "RANKED_FLEX_SR":
                $flexQueue = $i;
                $rankFlexQueue = ucfirst(strtolower($summonerRank[$flexQueue]["tier"]));
                break;
            case "RANKED_SOLO_5x5":
                $soloQueue = $i;
                $rankSoloQueue = ucfirst(strtolower($summonerRank[$soloQueue]["tier"]));
                break;
        }
    }

    $summonerRecognitionData = getSummonerRecognitionData($summoner["puuid"], $regionCode);

    $summonerLastMatches = getSummonerMatchesIds($summoner["puuid"], 1, $region, null);

    $data = json_decode(file_get_contents('./champion.json', true));
} else {
    header("Location: index.php?alert=401Search");
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
    <link rel="stylesheet" href="css/analysis_settings.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Karla:wght@400;700&family=Oswald:wght@400;700&display=swap"
        rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="arrow"><a href="index.php?page=0"><img src="img/backwardsArrow.png"
                    alt="Arrow that you can click to go to the main page"></a></div>
        <div class="summoner">
            <p class="isYou">Is this you? Try searching again</p>
            <div class="summonerSearch">
                <select id="region" name="region">
                    <option value="euw1">EUW</option>
                    <option value="na1">NA</option>
                    <option value="eune1">EUNE</option>
                    <option value="la1">LAN</option>
                    <option value="la2">LAS</option>
                </select>
                <input type="text" name="summoner" id="summoner" placeholder="Summoner name + #Tag"
                    onkeypress="checkUserExistance(event)">
            </div>
            <div class="summonerSummary">
                <div class="summonerInfo">
                    <div class="summonerIcon"><img
                            src="img/profileicon/<?php echo $summonerRecognitionData["profileIconId"]; ?>.png"
                            alt="Summoner's ingame icon"></div>
                    <div class="summonerUser"><?php echo $summoner["gameName"] . '#' . $summoner["tagLine"]; ?></div>
                </div>
                <div class="summonerLevel"><?php echo $summonerRecognitionData["summonerLevel"]; ?></div>
                <div class="ranks">
                    <div class="queue">
                        <h2>SOLO</h2>
                        <div class="rankImg"><img
                                src="img/ranks/<?php echo $soloQueue != -1 ? $summonerRank[$soloQueue]["tier"] : "UNRANKED"; ?>.png"
                                alt="Image of the rank"></div>
                        <div class="division">
                            <?php echo ($soloQueue != -1 ? $rankSoloQueue . ($rankSoloQueue=="Challenger" || $rankSoloQueue=="Grandmaster" || $rankSoloQueue=="Master" ? "": " ".$summonerRank[$soloQueue]["rank"]) : "Unranked"); ?>
                        </div>
                        <div class="lp"><?php echo $soloQueue != -1 ? $summonerRank[$soloQueue]["leaguePoints"]." LP" : ""; ?>
                        </div>
                    </div>
                    <div class="queue">
                        <h2>FLEX</h2>
                        <div class="rankImg"><img
                                src="img/ranks/<?php echo $flexQueue != -1 ? $summonerRank[$flexQueue]["tier"] : "UNRANKED"; ?>.png"
                                alt="Image of the rank"></div>
                        <div class="division">
                            <?php echo $flexQueue != -1 ? $rankFlexQueue . ($rankFlexQueue=="Challenger" || $rankFlexQueue=="Grandmaster" || $rankFlexQueue=="Master" ? "": " ".$summonerRank[$flexQueue]["rank"]) : "Unranked"; ?>
                        </div>
                        <div class="lp"><?php echo $flexQueue != -1 ? $summonerRank[$flexQueue]["leaguePoints"]." LP" : ""; ?>
                        </div>
                    </div>
                </div>
                <!-- El 3 tiene que ser dinámico, a lo mejor encontramos solo 2, 1 o ninguna -->
                <p class="lastGames">Last game</p>
                <div class="summonerMatches">
                    <?php
                    for ($i = 0; $i < sizeof($summonerLastMatches); $i++) {
                        $matchInfo = getMatchInfo($summonerLastMatches[$i], "europe");
                        $index = array_search($summoner["puuid"], $matchInfo["metadata"]["participants"]);
                        echo '<div class="game" style=" background-color:' . ($matchInfo["info"]["participants"][$index]["win"] == 1 ? "#5282e99a" : "#e940579a") . ';">
                        <div class="statsAndSetup">
                        <img src="img/champion/' . $matchInfo["info"]["participants"][$index]["championName"] . '.png" alt="Image of the champion played on this game">
                        <div class="spells">
                            <div class="spell"><img src="img/summonerspells/' . $matchInfo["info"]["participants"][$index]["summoner1Id"] . '.png" alt="Image of the primary summoner spell in this game"></div>
                            <div class="spell"><img src="img/summonerspells/' . $matchInfo["info"]["participants"][$index]["summoner2Id"] . '.png" alt="Image of the secondary summoner spell in this game"></div>
                        </div>
                        <div class="runes">
                            <div class="rune"><img src="img/mainrunes/' . $matchInfo["info"]["participants"][$index]["perks"]["styles"][0]["selections"][0]["perk"] . '.png" alt="Image of the rune taken for the game"></div>
                            <div class="tree"><img src="img/runetrees/' . $matchInfo["info"]["participants"][$index]["perks"]["styles"][1]["style"] . '.png" alt="Image of the secondary summoner spell in this game"></div>
                        </div>
                        <p class="score">' . $matchInfo["info"]["participants"][$index]["kills"] . '/' . $matchInfo["info"]["participants"][$index]["deaths"] . '/' . $matchInfo["info"]["participants"][$index]["assists"] . '</p>
                        </div>
                        <div class="build">';
                        for ($j = 0; $j < 7; $j++) {
                            echo '<img src="img/item/' . $matchInfo["info"]["participants"][$index]["item" . $j] . '.png" alt="Ingame item">';
                        }
                        echo '</div>
                        </div>';
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="analysisSettings">
            <h1>SETTINGS</h1>
            <div class="matchesAndQueue">
                <label for="matches">Number of matches: </label>
                <input type="number" id="numberMatches" name="matches" min="1" max="20" oninput="isAnalysisReady()">
                <div class="Queues">
                    <input type="button" id="soloButton" value="Solo" active="0" onclick="toggleActive(this)">
                    <input type="button" id="flexButton" value="Flex" active="0" onclick="toggleActive(this)">
                </div>
            </div>
            <div class="championSelect">
                Champions to
                <select name="champion" id="champion" onchange="toggleChampionDiv()">
                    <option value="ignore">ignore</option>
                    <option value="focus">focus</option>
                </select>
                <div class="championAutocomplete">
                    <div class="championSelection">
                        <input type="text" id="championInput" oninput="autoCompleteChampion(this)" autocomplete="of">
                    </div>
                    <div class="autocomplete-champions" id="autocomplete-champions"></div>
                </div>
            </div>
            <div class="selectedChampions" id="ignoreChampions" style="display: flex;">
            </div>
            <div class="selectedChampions" id="focusChampions" style="display: none;">
            </div>
            <div class="role" id="role">
                <img src="img/roles/unselected.png" role="unselected" onmouseover="hoverRole(this)" onmouseout="unhoverRole(this)" onclick="showRoles()" id="roleImg">
            </div>
            <div class="roles" id="roles" style="display: none;">
                <img src="img/roles/top.png" alt="" role="top" onmouseover="hoverRole(this)" onmouseout="unhoverRole(this)" onclick="selectRole(this)">
                <img src="img/roles/jungle.png" alt="" role="jungle" onmouseover="hoverRole(this)" onmouseout="unhoverRole(this)" onclick="selectRole(this)">
                <img src="img/roles/middle.png" alt="" role="middle" onmouseover="hoverRole(this)" onmouseout="unhoverRole(this)" onclick="selectRole(this)">
                <img src="img/roles/bottom.png" alt="" role="bottom" onmouseover="hoverRole(this)" onmouseout="unhoverRole(this)" onclick="selectRole(this)">
                <img src="img/roles/utility.png" alt="" role="utility" onmouseover="hoverRole(this)" onmouseout="unhoverRole(this)" onclick="selectRole(this)">
            </div>
            <div class="analysisButtonContainer">
            <button onclick="" id="analysisButton">ANALYZE</button>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="scripts.js"></script>
</body>

</html>