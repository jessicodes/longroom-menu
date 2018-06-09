<?php
header('Content-type: application/json');
header('Access-Control-Allow-Headers: Content-Type');
header("Access-Control-Allow-Origin: *");

// connect to db via notorm/pdo
include_once($_SERVER['DOCUMENT_ROOT']."/db/db_connect.php");

// passed data, if any
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE);

// get users menu from DB
$menu_id = 1;
$menu = $db->library->menu[$menu_id];
$beer_ids = $menu['beer_ids'];

// get beers from user's menu
$beers = array();
if (!empty($beer_ids)) {
  $beer_ids = explode(',', $beer_ids);
  foreach ($beer_ids as $beer_id) {
    $beer = $db->library->beer[$beer_id];
    $beers[] = array(
      'id' => $beer["id"],
      'name' => $beer["name"],
      'brewery' => array(
        'id' => $beer->brewery["id"],
        'label' => $beer->brewery["name"],
        'location' => $beer->brewery["location"],
      ),
      'style' => array(
        'id' => $beer->style["id"],
        'label' => $beer->style["name"],
      ),
      'glassware' => array(
        'id' => $beer->glassware["id"],
        'label' => $beer->glassware["name"],
        'icon' => $beer->glassware["icon_letter"],
      ),
      "abv" => $beer['abv'],
      "price" => $beer['price'],
      "description" => $beer['description'],
    );
  }
}

$result['beers'] = $beers;
$result['message'] = '';
$result['error']  = false;

echo json_encode($result);