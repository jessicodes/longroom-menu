<?php

// connect to db via notorm/pdo
include_once($_SERVER['DOCUMENT_ROOT']."/db/db_connect.php");

$glasswares = $db->library->glassware();

// notorm object to array
$glasswares = array_map('iterator_to_array', iterator_to_array($glasswares));
$glasswares = array_values($glasswares);

$glasswares_json = json_encode($glasswares);

$file = fopen("resources/data/glassware.json", "w") or die("Unable to open file!");
fwrite($file, $glasswares_json);
fclose($file);