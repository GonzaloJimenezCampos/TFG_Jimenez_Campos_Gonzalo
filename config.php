<?php
$server = 'mysql:host=localhost;dbname=fxlol;port=3306;charset=utf8';
$serveruser = 'root';
$serverpassword = '';
$PDOoptions = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];
