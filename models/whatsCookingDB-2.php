<?php

class WhatsCookingDB {
    private $address;
    private $city;
    private $country;
    private $province;
    private $postal;
    private $title;
    private $img_src;
    private $user_id;
    private $recipe_id;

    public function setAdd($add) {
        $this->address = $add;
    }

    public function setCity($city) {
        $this->city = $city;
    }

    public function setCountry($coun) {
        $this->country = $coun;
    }

    public function setProv($prov) {
        $this->province = $prov;
    }

    public function setPost($post) {
        $this->postal = $post;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setImg($img) {
        $this->img_src = $img;
    }

    public function setId($user_id) {
        $this->user_id = $user_id;
    }

    public function setRecipeId($recipe_id) {
        $this->recipe_id = $recipe_id;
    }


    public function getAdd() {
        return $this->address;
    }

    public function getCity() {
        return $this->city;
    }

    public function getCountry() {
        return $this->country;
    }

    public function getProv() {
        return $this->province;
    }

    public function getPost() {
        return $this->postal;
    }

    public function getTitle(){
        return $this->title;
    }

    public function getImg() {
        return $this->img_src;
    }

    public function getId() {
        return $this->user_id;
    }

    public function getRecipeId() {
        return $this->recipe_id;
    }

    public function __construct($user_id){
        $this->setId($user_id);
    }
}



 ?>
