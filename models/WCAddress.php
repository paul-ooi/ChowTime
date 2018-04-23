<?php
session_start();

if(isset($_SESSION['user_id'])) {
    $id = $_SESSION['user_id'];
} else {
    $id = 2;
}

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
    $titleKey = "t" . $count;
    $add = $user->getAdd();
    $city = $user->getCity();
    $province = $user->getProv();
    $post = $user->getPost();
    $title = $user->getTitle();
    $recipe_id = $user->getRecipeId();

    $address = "$add $city $province $post";
    $u[$addKey] = $address;
    $u[$imgKey] = $user->getImg();
    $u[$titleKey] = $title;
    $u['recipe_id'] = $recipe_id;

    //ADD THE ADDRESS, IMAGE, AND TITLE DETAILS TO THE USER 
    $array[$userKey] = $u;

    $finalArray = array('whats_cooking' => $array);
}

$currUserAdd = WhatsCooking::userAddress($id);
foreach($currUserAdd as $user) {
    $u = array();
    $id = $user->getId();
    $add1 = $user->getAdd();
    $city = $user->getCity();
    $prov = $user->getProv();
    $post = $user->getPost();

    $fullAdd = "$add1 $city $prov $post";

    $u['id'] = $id;
    $u['address'] = $fullAdd;

    $finalArray['currUserDetails'] = $u;
}

echo json_encode($finalArray);

//https://stackoverflow.com/questions/18377469/php-give-a-name-to-an-array-of-json-objects?utm_medium=organic&utm_source=google_rich_qa&utm_campaign=google_rich_qa



 ?>
