<?php

// connect to db via notorm/pdo
include_once($_SERVER['DOCUMENT_ROOT'] ."/db/library/NotORM.php");
include_once($_SERVER['DOCUMENT_ROOT'] ."/db/class.connect.php");

$db = new connect();

// all beers
//    $beers = $db->library->beers();

// all beers, only brewery column
//    $beers = $db->library->beers()->select("brewery");

// a specific beer
//    $beers = $db->library->beers[1];
//    echo $beers['name'];

// sorting beers
//    $beers = $db->library->beers->order("id desc");
//
//    foreach ($beers as $beer) { // get all applications
//      echo ': ' . $beer["brewery"] . '<br />';
//    }

// Updating a single beer
//    $update_this_beer = $db->library->beers[1];
//    if ($update_this_beer) {
//      $data = array(
//        "name" => "Pro PHP Patterns, Frameworks, Testing and More"
//      );
//      $result = $update_this_beer->update($data);
//    }

//    $beers_table = $db->library->beers();
//    if ($beers_table) {
//      $data = array(
//        "name" => "whoaaaa"
//      );
//      $result = $beers_table->set($data);
//    }


//    $data = array("name" => "Beginning PHP");
//    $result = $beers->insert($data);
//    if (false === $result) {
//      echo 'false';
//    }
//    echo 'successs?' . $result['id'];