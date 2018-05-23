<?php
header('Content-type: application/json');
header('Access-Control-Allow-Headers: Content-Type');
header("Access-Control-Allow-Origin: *");

// connect to db via notorm/pdo
include_once($_SERVER['DOCUMENT_ROOT']."/db/db_connect.php");
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE);

$name = $input['name'];
$brewery = $input['brewery'];
$style = $input['style'];
$glassware = $input['glassware'];
$abv = $input['abv'];
$description = $input['description'];

// Insert into DB
$beers = $db->library->beer();
$data = array(
  "name" => $name,
  "brewery_id" => 1,
  "brewery" => $brewery,
  "location" => 'Location will come from brewery',
  "style" => $style,
  "glassware" => $glassware,
  "abv" => $abv,
  "description" => $description
);
$beers->insert($data);
$id = $beers->insert_id();

$result['message'] = '';
$result['error']  = false;

if ($name){
  $result['message']  = "Posted Values => ".$name."-".$description."-".$brewery;
  $result['error']  = false;
}
else {
  $result['error']  = 'Form submission failed.';
}


echo json_encode($result);