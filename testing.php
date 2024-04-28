<?php

include ("helpers.php");

$summonerName = "EL OG#EUW";

$summoner = getSummoner($summonerName, 'europe');

$summonerRecognitionData = getSummonerRecognitionData($summoner["puuid"], "euw1");

$summonerLastMatches = getSummonerMatchesIds($summoner["puuid"], 3, "europe");

// 



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TEST</title>
</head>

<body>
    <div><?php echo $summoner["puuid"]; ?></div>
    <div><?php echo $summoner["gameName"] . '#' . $summoner["tagLine"]; ?></div>
    <div><?php echo $summonerRecognitionData["summonerLevel"]; ?></div>
    <div></div>
    <br>
    <!-- Este for contiene toda la informacion que necesitamos sacar de la api para la comprobación del usuario, falta maquetarla -->
    <?php
    for ($i = 0; $i < sizeof($summonerLastMatches); $i++) {
        $matchInfo = getMatchInfo($summonerLastMatches[$i], "europe");
        $index = array_search($summoner["puuid"], $matchInfo["metadata"]["participants"]);
        echo '<div style="display: flex;">
            <div>' . $matchInfo["info"]["participants"][$index]["championName"] . '</div>
            <div>' . $matchInfo["info"]["participants"][$index]["summoner1Id"] . ' ' . $matchInfo["info"]["participants"][$index]["summoner2Id"] . '</div>
            <div>' . $matchInfo["info"]["participants"][$index]["kills"] . '/' . $matchInfo["info"]["participants"][$index]["deaths"] . '/' . $matchInfo["info"]["participants"][$index]["assists"] . '</div>
            <div>' . var_dump($matchInfo["info"]["participants"][$index]["perks"]["styles"][0]["selections"][0]["perk"]) . '</div>
            <div>' . var_dump($matchInfo["info"]["participants"][$index]["perks"]["styles"][1]["style"]) . ' </div>
            <div>';
            for ($j = 0; $j < 7; $j++){
                echo '  '. $matchInfo["info"]["participants"][$index]["item". $j] . '  ';
            }
            echo '</div>
            <div>' . $matchInfo["info"]["participants"][$index]["win"] . '</div>
        </div>';

    }
    ?>
</body>

</html>