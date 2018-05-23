<?php
header('Content-type: application/json');
header('Access-Control-Allow-Headers: Content-Type');
header("Access-Control-Allow-Origin: *");

// connect to db via notorm/pdo
include_once($_SERVER['DOCUMENT_ROOT']."/db/db_connect.php");

// passed data, if any
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE);

// insert into DB
$menu_id = 1;
$menu = $db->library->menu[$menu_id];
$beer_ids = $menu['beer_ids'];

// get beers from user's menu
$beers = array();
if (!empty($beer_ids)) {
  $beer_ids = explode(',', $beer_ids);
  foreach ($beer_ids as $beer_id) {
    $beers[] = $db->library->beer[$beer_id];
  }
}

$result['beers'] = $beers;
$result['message'] = '';
$result['error']  = false;

echo json_encode($result);