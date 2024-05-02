<?php

//Le pasas la url, hace la consulta y te devuelve el array
function makeApiCall($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    $result = curl_exec($ch);
    curl_close($ch);
    return json_decode($result, true);
}

//Le pasas al usuario el username y te devuelve un array con su puuid, su gameName y su TagLine. Puedes usar cualquier region pero mejor el cluster más cercano
function getSummoner($summonerName, $region)
{
    include ("config.php");
    $summonerNameParts = explode("#", $summonerName);
    $summonerNameParts[0] = str_replace(" ", "%20", $summonerNameParts[0]);
    $summonerNameParts[1] = str_replace(" ", "%20", $summonerNameParts[1]);
    return makeApiCall("https://" . $region . ".api.riotgames.com/riot/account/v1/accounts/by-riot-id/" . $summonerNameParts[0] . "/" . $summonerNameParts[1] . "?" . $API_KEY);
}

function getAccountId($puuid, $regionCode)
{
    include ("config.php");
    return makeApiCall("https://" . $regionCode . ".api.riotgames.com/lol/summoner/v4/summoners/by-puuid/" . $puuid . "?" . $API_KEY);
}

//Le pasas el codigo de region y el puuid te devuelve un array con varios datos del usuario, entre ellos el icono, el nivel y varios ids
function getSummonerRecognitionData($puuid, $regionCode)
{
    include ("config.php");
    return makeApiCall("https://" . $regionCode . ".api.riotgames.com/lol/summoner/v4/summoners/by-puuid/" . $puuid . "?" . $API_KEY);
}

function getSummonerRanks($puuid, $regionCode)
{
    include ("config.php");
    return makeApiCall("https://" . $regionCode . ".api.riotgames.com/lol/league/v4/entries/by-summoner/" . $puuid . "?" . $API_KEY);
}

//Devuelve una lista con las id de los partidos que ha jugado un jugador. Puedes usar cualquier region pero mejor el cluster más cercano
function getSummonerMatchesIds($puuid, $matchesCount, $region, $queueId)
{
    include ("config.php");
    return makeApiCall("https://" . $region . ".api.riotgames.com/lol/match/v5/matches/by-puuid/" . $puuid . "/ids?" . (is_null($queueId) ? "" : "queue=" . $queueId . "&") . "start=0&count=" . $matchesCount . "&" . $API_KEY);
}

//Dado un id de una partida, devuelve todos los datos de esa partida. Puedes usar cualquier region pero mejor el cluster más cercano
function getMatchInfo($matchId, $region)
{
    include ("config.php");
    return makeApiCall("https://" . $region . ".api.riotgames.com/lol/match/v5/matches/" . $matchId . "?" . $API_KEY);
}

function getSummonerName($puuid, $region)
{
    include ("config.php");
    return makeApiCall("https://" . $region . ".api.riotgames.com/riot/account/v1/accounts/by-puuid/" . $puuid . "?" . $API_KEY);
}