<?php
header('Content-type: application/json');
header('Access-Control-Allow-Headers: Content-Type');
header("Access-Control-Allow-Origin: *");

// connect to db via notorm/pdo
include_once("db/db_connect.php");

// passed data, if any
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE);

// Action: update vs insert
$update_brewery_id = '';
$action = 'insert';
if (!empty($input['brewery_id'])) {
  $update_brewery_id = $input['brewery_id'];
  $action = 'update';
}

$name = $input['name'];
$location = $input['location'];

// Insert into DB
$data = array(
  "name" => $name,
  "location" => $location,
  "updated" => new NotORM_Literal("NOW()")
);

if ($action == 'insert') {
  // insert
  $brewery = $db->library->brewery();
  $data['added'] = new NotORM_Literal("NOW()");
  $success = $brewery->insert($data);
} else {
  // update
  $brewery = $db->library->brewery[$update_brewery_id];
  $success = $brewery->update($data);
}

$result['message'] = '';
$result['error']  = false;

if ($success){
  $result['message']  = "Posted Values => ".$name."-".$location;
  $result['error']  = false;

  // Update JSON of all breweries
  include_once("create_breweries_json.php");
}
else {
  $result['error']  = 'Form submission failed.';
}

echo json_encode($result);