<?php
define('DB_HOST', '193.203.175.60');
define('DB_USER', 'u741348489_wanderne_con');
define('DB_PASS', 'DIpIYIp25O');
define('DB_NAME', 'u741348489_preco_contrato');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8");
?>
