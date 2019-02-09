<?php
header('Content-type: application/json');
header('Access-Control-Allow-Headers: Content-Type');
header("Access-Control-Allow-Origin: *");

// connect to db via notorm/pdo
include_once("../db/db_connect.php");

// passed data, if any
$inputJSON = file_get_contents('php://input');
$data = json_decode($inputJSON, TRUE);

// get beer data from DB
$beer_id = $data['beer_id'];
$beer = $db->library->beer[$beer_id];

// create array of data
$beer_data = array(
  'id' => $beer["id"],
  'name' => $beer["name"],
  'brewery' => array(
    'id' => $beer->brewery["id"],
    'label' => $beer->brewery["name"],
    'location' => $beer->brewery["location"],
  ),
  'glassware' => array(
    'id' => $beer->glassware["id"],
    'label' => $beer->glassware["name"]
  ),
  'style' => $beer["style"],
  "abv" => $beer['abv'],
  "price" => $beer['price'],
  "description" => $beer['description'],
);

$result['beer'] = $beer_data;
$result['message'] = '';
$result['error']  = false;

echo json_encode($result);