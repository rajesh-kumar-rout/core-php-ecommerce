<?php 

$db_host = "localhost";
$db_name = "php_demo";
$db_username = "root";
$db_password = "";

$pdo = new PDO("mysql:host={$db_host};dbname={$db_name}", $db_username, $db_password);

$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);