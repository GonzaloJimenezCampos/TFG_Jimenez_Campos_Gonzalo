<?php
include ("helpers.php");
include ('lib.php');
include ('config.php');
$queryString = $_SERVER['QUERY_STRING'];
$decodedQueryString = urldecode($queryString);
$data = json_decode($decodedQueryString, true);

$summonerName = $data["username"];
$regionCode = $data["regionCode"];
$region = "europe";
$wins = 0;
$farmPerMinuteSum = 0;
$totalGoldPerMinuteSum = 0;
$totalDamageTochampionsPerMinuteSum = 0;
$damageToObjectivesPerMinuteSum = 0;
$damageToBuildingsPerMinuteSum = 0;
$visionScoreSum = 0;
$killsAndAssistsSum = 0;
$totalTeamKillsSum = 0;
$deathsPerMinuteSum = 0;
$kdaRatioSum = 0;
$numberOfMatchesToAnalyze = (int) $data["numberMatches"];
if ($data["soloQueue"]) {
    $queueId = 420;
} else {
    $queueId = 440;
}

function champSelection($championUsed, $array, $dataSelection)
{
    if ($dataSelection == "ignore") {
        return !(in_array($championUsed, $array));
    } else if ($dataSelection == "focus") {
        return in_array($championUsed, $array);
    }
}

$summoner = getSummoner($summonerName, $region);
$summonerLastMatches = getSummonerMatchesIds($summoner["puuid"], 50, $region, $queueId);

for ($i = 0; $i < sizeof($summonerLastMatches) && $numberOfMatchesToAnalyze > 0; $i++) {
    $matchInfo = getMatchInfo($summonerLastMatches[$i], "europe");
    if (isset($matchInfo["metadata"]) && isset($matchInfo["metadata"]["participants"]) && is_array($matchInfo["metadata"]["participants"])) {
        $index = array_search($summoner["puuid"], $matchInfo["metadata"]["participants"]);
        if ((!$matchInfo["info"]["participants"][0]["gameEndedInEarlySurrender"]) && champSelection($matchInfo["info"]["participants"][$index]["championName"], $data["selectedChampions"], $data["championSelection"]) && $matchInfo["info"]["participants"][$index]["teamPosition"] == strtoupper($data["roleSelected"])) {
            $matchTime = $matchInfo["info"]["gameDuration"] / 60;
            $farmPerMinuteSum += ($matchInfo["info"]["participants"][$index]["totalMinionsKilled"] + $matchInfo["info"]["participants"][$index]["neutralMinionsKilled"]) / $matchTime;
            $totalGoldPerMinuteSum += $matchInfo["info"]["participants"][$index]["goldEarned"] / $matchTime;

            $totalDamageTochampionsPerMinuteSum += $matchInfo["info"]["participants"][$index]["totalDamageDealtToChampions"] / $matchTime;

            $damageToObjectivesPerMinuteSum += $matchInfo["info"]["participants"][$index]["damageDealtToObjectives"] / $matchTime;

            $visionScoreSum += $matchInfo["info"]["participants"][$index]["visionScore"] / $matchTime;

            $teamId = $matchInfo["info"]["participants"][$index]["teamId"];
            if ($teamId == $matchInfo["info"]["teams"][0]['teamId']) {
                $team = 0;
            } else {
                $team = 1;
            }
            $killsAndAssistsSum += ($matchInfo["info"]["participants"][$index]["kills"] + $matchInfo["info"]["participants"][$index]["assists"]);
            $totalTeamKillsSum += $matchInfo["info"]["teams"][$team]['objectives']['champion']['kills'];
            $deathsPerMinuteSum += $matchInfo["info"]["participants"][$index]["deaths"] / $matchTime;

            $wins += $matchInfo["info"]["participants"][$index]["win"] == true ? 1 : 0;
            $numberOfMatchesToAnalyze--;
        }
    }
}

if ($numberOfMatchesToAnalyze == (int) $data["numberMatches"]) {

    $analysisScores = array(
        'error' => "404",
    );

} else {

    $farmPerMinuteAverage = $farmPerMinuteSum / ((int) $data["numberMatches"] - $numberOfMatchesToAnalyze);
    $totalGoldPerMinuteAverage = $totalGoldPerMinuteSum / ((int) $data["numberMatches"] - $numberOfMatchesToAnalyze);
    $totalDamageTochampionsPerMinuteAverage = $totalDamageTochampionsPerMinuteSum / ((int) $data["numberMatches"] - $numberOfMatchesToAnalyze);
    $damageToObjectivesPerMinuteAverage = $damageToObjectivesPerMinuteSum / ((int) $data["numberMatches"] - $numberOfMatchesToAnalyze);
    $visionScoreAverage = $visionScoreSum / ((int) $data["numberMatches"] - $numberOfMatchesToAnalyze);
    //Si los asesintatos del equipo totales han sido 0 da 0/0 (error) y si las muertes totales son 0 da x/0 (error tambien)
    $killParticipationAverage = $killsAndAssistsSum / $totalTeamKillsSum * 100;
    $deathsPerMinuteAverage = $deathsPerMinuteSum / ((int) $data["numberMatches"] - $numberOfMatchesToAnalyze);
    $winrate = $wins / ((int) $data["numberMatches"] - $numberOfMatchesToAnalyze) * 100;

    //Hay que cambiarlo para support y jungla.
    $farmGoal = 10;
    $totalGoldGoal = 522;
    $totalDamageToChampionsGoal = 1100;
    $totalDamageToObjectivesGoal = 577;
    $visionGoal = 1.25;
    $killParticipationGoal = 60;
    if ($data["roleSelected"] == "utility") {
        $farmGoal = 1;
        $totalGoldGoal = 300;
        $totalDamageToChampionsGoal = 400;
        $totalDamageToObjectivesGoal = 200;
        $visionGoal = 2;
        $killParticipationGoal = 70;
    } else if ($data["roleSelected"] == "jungle") {
        $farmGoal = 8.5;
        $totalGoldGoal = 480;
        $totalDamageToObjectivesGoal = 600;
        $visionGoal = 1.5;
        $killParticipationGoal = 70;
    } else if ($data["roleSelected"] == "bottom") {
        $totalDamageToChampionsGoal = 1300;
    }

    function calculateCategoryScore($average, $goal, $maxScore)
    {

        if ($average > $goal) {
            $score = $maxScore;
        } else {
            $score = $average / $goal * $maxScore;
        }

        return $score;
    }

    $farmPerMinuteScore = calculateCategoryScore($farmPerMinuteAverage, $farmGoal, 60);
    $goldperMinuteScore = calculateCategoryScore($totalGoldPerMinuteAverage, $totalGoldGoal, 40);
    $totalGoldScore = $goldperMinuteScore + $farmPerMinuteScore;
    $totalDamageScore = calculateCategoryScore($totalDamageTochampionsPerMinuteAverage, $totalDamageToChampionsGoal, 100);
    $totalObjectivesScore = calculateCategoryScore($damageToObjectivesPerMinuteAverage, $totalDamageToObjectivesGoal, 100);
    $totalVisionScore = calculateCategoryScore($visionScoreAverage, $visionGoal, 100);
    $totalKillParticipationScore = calculateCategoryScore($killParticipationAverage, $killParticipationGoal, 70);
    if ($deathsPerMinuteAverage >= 1) {
        $totalDeathPerMinuteScore = 0;
    } else if ($deathsPerMinuteAverage <= 0.1) {
        $totalDeathPerMinuteScore = 30;
    } else {
        $totalDeathPerMinuteScore = 30 * (1.1 - $deathsPerMinuteAverage);
    }
    $totalKdaScore = $totalKillParticipationScore + $totalDeathPerMinuteScore;

    $totalScore = ($totalGoldScore + $totalDamageScore + $totalObjectivesScore + $totalVisionScore + $totalKdaScore) / 5;

    $analysisScores = array(
        'farmPerMinute' => $farmPerMinuteScore,
        'goldPerMinute' => $goldperMinuteScore,
        'gold' => number_format($totalGoldScore, 0),
        'damage' => number_format($totalDamageScore, 0),
        'objectives' => number_format($totalObjectivesScore, 0),
        'vision' => number_format($totalVisionScore, 0),
        'killParticipation' => $totalKillParticipationScore,
        'deathScore' => $totalDeathPerMinuteScore,
        'kda' => number_format($totalKdaScore, 0),
        'winrate' => number_format($winrate, 0),
        'totalScore' => number_format($totalScore, 0),
    );

    if (isset($_SESSION['user_id'])) {
        $connection = connect($server, $serveruser, $serverpassword, $PDOoptions);
        $sql = 'INSERT INTO records (record_date, puuid, region, score, gold, damage, objectives, vision, kda, winrate, user_id) VALUES (NOW(), "' . $summoner["puuid"] . '", "' . $regionCode . '" ,' . number_format($totalScore, 0) . ', ' . number_format($totalGoldScore, 0) . ', ' . number_format($totalDamageScore, 0) . ', ' . number_format($totalObjectivesScore, 0) . ', ' . number_format($totalVisionScore, 0) . ', ' . number_format($totalKdaScore, 0) . ', ' . number_format($winrate, 0) . ', ' . $_SESSION["user_id"] . ')';
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        array_pop($_SESSION['records']);
        $summonerIcon = getSummonerRecognitionData($summoner["puuid"], $regionCode)["profileIconId"];
        $summonerInfo = getSummonerName($summoner["puuid"], 'europe');
        $summonerName = $summonerInfo["gameName"] . "#" . $summonerInfo["tagLine"];
        array_unshift($_SESSION['records'], [$summonerIcon, $summonerName]);
    }
}

$scoreQuery = http_build_query($analysisScores);

header('Location: analysis_breakdown.php?' . $scoreQuery);