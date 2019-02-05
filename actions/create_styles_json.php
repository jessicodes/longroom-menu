<?php
header('Content-type: application/json');
header('Access-Control-Allow-Headers: Content-Type');
header("Access-Control-Allow-Origin: *");

// connect to db via notorm/pdo
include_once("../db/db_connect.php");

$styles = $db->library->style();

// notorm object to array
$styles = array_map('iterator_to_array', iterator_to_array($styles));
$styles = array_values($styles);

$styles_json = json_encode($styles);

$file = fopen("../resources/data/styles.json", "w") or die("Unable to open file!");
fwrite($file, $styles_json);
fclose($file);