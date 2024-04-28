<?php
$json = file_get_contents('php://input');
$data = json_decode($json, true);


if ($data !== null) {
    echo $json;
} else {
    echo "Error al decodificar el JSON.";
}
