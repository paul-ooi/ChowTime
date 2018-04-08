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

$users = WhatsCooking::whatsCookingAll();

$count = 0;

foreach($users as $user) {
    $count += 1;
    $key = "key" . $count;
    $add = $user->getAdd();
    $city = $user->getCity();
    $province = $user->getProv();
    $post = $user->getPost();

    $address = "$add $city $province $post";
    $fullAdd[$key] = $address;
}

// echo count($fullAdd);
echo json_encode($fullAdd);




 ?>
