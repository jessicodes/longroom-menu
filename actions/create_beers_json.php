<?php

// connect to db via notorm/pdo
include_once("../db/db_connect.php");

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
    'glassware' => array(
      'id' => $beer->glassware["id"],
      'label' => $beer->glassware["name"],
      'icon' => $beer->glassware["icon_letter"],
    ),
    'style' => $beer["style"],
    "abv" => $beer['abv'],
    "price" => $beer['price'],
    "description" => $beer['description'],
  );
}

// convert to json
$beers_json = json_encode($beers_data);

// populate the json file of all beer data
$file = fopen("../resources/data/beers.json", "w") or die("Unable to open file!");
fwrite($file, $beers_json);
fclose($file);