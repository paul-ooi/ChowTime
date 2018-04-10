<?php
// $addr = array (
//     'a' => "61 Talara Dr, North York, ON M2K 1A3",
//     'b' => "62 Talara Dr, North York, ON M2K"
// );
// echo json_encode($addr);

session_start();
$_SESSION['user_id'] = 1;

include 'db.php';
include 'whatsCookingDb-2.php';
include 'whatsCookingDB.php';


//OBJECT OF USERS ADDRESS, IMG-SRC, RECIPE TITLE, ETC...
$users = WhatsCooking::whatsCookingAll();

$count = 0;

foreach($users as $user) {
    $count += 1;
    //CLEAN THE ARRAY
    $u = array();
    $addKey = "add" . $count;
    $imgKey = "img" . $count;
    $userKey = "u" . $count;
    $add = $user->getAdd();
    $city = $user->getCity();
    $province = $user->getProv();
    $post = $user->getPost();

    $address = "$add $city $province $post";
    $u[$addKey] = $address;
    $u[$imgKey] = $user->getImg();
    $array[$userKey] = $u;

}

echo json_encode(array('whats_cooking' => $array));
//https://stackoverflow.com/questions/18377469/php-give-a-name-to-an-array-of-json-objects?utm_medium=organic&utm_source=google_rich_qa&utm_campaign=google_rich_qa



 ?>
