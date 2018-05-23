<?php
header('Content-type: application/json');
header('Access-Control-Allow-Headers: Content-Type');
header("Access-Control-Allow-Origin: *");

// connect to db via notorm/pdo
include_once($_SERVER['DOCUMENT_ROOT']."/db/db_connect.php");

// passed data, if any
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE);

$name = $input['name'];
$location = $input['location'];

// Insert into DB
$brewery = $db->library->brewery();
$data = array(
  "name" => $name,
  "location" => $location,
  "added" => new NotORM_Literal("NOW()"),
  "updated" => new NotORM_Literal("NOW()")
);
$brewery->insert($data);
$id = $brewery->insert_id();

$result['message'] = '';
$result['error']  = false;

if ($id){
  $result['message']  = "Posted Values => ".$name."-".$location;
  $result['error']  = false;
}
else {
  $result['error']  = 'Form submission failed.';
}


echo json_encode($result);