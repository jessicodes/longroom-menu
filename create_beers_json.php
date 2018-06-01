<?php
header('Content-type: application/json');
header('Access-Control-Allow-Headers: Content-Type');
header("Access-Control-Allow-Origin: *");

// connect to db via notorm/pdo
include_once($_SERVER['DOCUMENT_ROOT']."/db/db_connect.php");

// lets get the beers!
$beers = $db->library->beer();

// create array of data
$beers_data = array();
foreach ($beers as $beer) {
  $beers_data[] = array(
    'id' => $beer["id"],
    'name' => $beer["name"],
    'brewery' => array(
      'id' => $beer->brewery["id"],
      'label' => $beer->brewery["name"],
      'location' => $beer->brewery["location"]
    ),
    'style' => array(
      'id' => $beer->style["id"],
      'label' => $beer->style["name"],
    ),
    'glassware' => array(
      'id' => $beer->glassware["id"],
      'label' => $beer->glassware["name"],
    ),
    "abv" => $beer['abv'],
    "description" => $beer['description'],
  );
}

// notorm object to array
//$beers = array_map('iterator_to_array', iterator_to_array($beers));
//$beers = array_values($beers);

// convert to json
$beers_json = json_encode($beers_data);

// populate the json file of all beer data
$file = fopen("resources/data/beers.json", "w") or die("Unable to open file!");
fwrite($file, $beers_json);
fclose($file);