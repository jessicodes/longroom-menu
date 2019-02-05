<?php
header('Content-type: application/json');
header('Access-Control-Allow-Headers: Content-Type');
header("Access-Control-Allow-Origin: *");

// connect to db via notorm/pdo
include_once("../db/db_connect.php");

// passed data, if any
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE);

// get active beers
$active_beers = $input['activeBeers'];
$active_beers_ids = array_column($active_beers, 'id');

$beer_ids = '';
if (!empty($active_beers_ids)) {
  $beer_ids = implode(',', $active_beers_ids);
}

// update current menu
$menu_id = 1;
$menu = $db->library->menu[$menu_id];
if ($menu) {
  $data = array(
    "beer_ids" => $beer_ids,
    "updated" => new NotORM_Literal("NOW()")
  );
  $success = $menu->update($data);
}

$result['message'] = '';
$result['error'] = FALSE;

if (isset($success) && $success == true){
  $result['message']  = "active beers => " . $beer_ids;
  $result['error']  = false;
}
else {
  $result['error']  = 'Updated menu failed => ' . $beer_ids;
}

echo json_encode($result);