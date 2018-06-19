<?php
header('Content-type: application/json');
header('Access-Control-Allow-Headers: Content-Type');
header("Access-Control-Allow-Origin: *");

// connect to db via notorm/pdo
include_once($_SERVER['DOCUMENT_ROOT']."/db/db_connect.php");

// passed data, if any
$inputJSON = file_get_contents('php://input');
$data = json_decode($inputJSON, TRUE);

// get beer data from DB
$brewery_id = $data['brewery_id'];
$brewery = $db->library->brewery[$brewery_id];

// create array of data
$result['name'] = $brewery["name"];
$result['location'] = $brewery["location"];
$result['message'] = '';
$result['error']  = false;

echo json_encode($result);