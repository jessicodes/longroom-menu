<?php
header('Content-type: application/json');
header('Access-Control-Allow-Headers: Content-Type');
header("Access-Control-Allow-Origin: *");

// connect to db via notorm/pdo
include_once($_SERVER['DOCUMENT_ROOT']."/db/db_connect.php");

$beers = $db->library->beer();

// notorm object to array
$beers = array_map('iterator_to_array', iterator_to_array($beers));
$beers = array_values($beers);

$beers_json = json_encode($beers);

$file = fopen("resources/data/beers.json", "w") or die("Unable to open file!");
fwrite($file, $beers_json);
fclose($file);