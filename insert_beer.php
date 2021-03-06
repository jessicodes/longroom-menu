<?php
header('Content-type: application/json');
header('Access-Control-Allow-Headers: Content-Type');
header("Access-Control-Allow-Origin: *");

// connect to db via notorm/pdo
include_once($_SERVER['DOCUMENT_ROOT']."/db/db_connect.php");

// passed data, if any
$inputJSON = file_get_contents('php://input');
$data = json_decode($inputJSON, TRUE);

// Action: update vs insert
$update_beer_id = '';
$action = 'insert';
if (!empty($data['beer_id'])) {
  $update_beer_id = $data['beer_id'];
  $action = 'update';
}

// Data for DB
$data = array(
  "name" => $data['name'],
  "brewery_id" => $data['brewery_id'],
  "style_id" => $data['style_id'],
  "glassware_id" => $data['glassware_id'],
  "abv" => $data['abv'],
  "description" => $data['description'],
  "updated" => new NotORM_Literal("NOW()")
);

if ($action == 'insert') {
  // insert
  $beers = $db->library->beer();
  $data['added'] = new NotORM_Literal("NOW()");
  $success = $beers->insert($data);
  //$id = $beers->insert_id();
} else {
  // update
  $beer = $db->library->beer[$update_beer_id];
  $success = $beer->update($data);
}

if ($success) {
  $result['message'] =  $action . "!";
  $result['error']  = false;

  // Update JSON of all beers
  include_once($_SERVER['DOCUMENT_ROOT']."/create_beers_json.php");

} else {
  $result['message']  = 'Form ' . $action . ' failed.';
  $result['error']  = true;
}

echo json_encode($result);