<?php
$json = file_get_contents('php://input');
$data = json_decode($json, true);


if ($data !== null) {

} else {
    echo "Error al decodificar el JSON.";
}
