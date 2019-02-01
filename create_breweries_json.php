<?php

// connect to db via notorm/pdo
include_once($_SERVER['DOCUMENT_ROOT']."/db/db_connect.php");

$beers = $db->library->brewery();

// notorm object to array
$beers = array_map('iterator_to_array', iterator_to_array($beers));
$beers = array_values($beers);
$beers_json = json_encode($beers);

$file = fopen("resources/data/breweries.json", "w") or die("Unable to open file!");
fwrite($file, $beers_json);
fclose($file);