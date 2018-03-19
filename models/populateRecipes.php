<?php

class Recipes {

    private $id;
    private $title;
    private $description;
    private $imgSrc;
    private $prepTime;
    private $dishLvl;
    private $ingredLvl;
    private $diffLvl;

    public function setTitle($in_title) {
        $this->title = $in_title;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setDescr($in_descr) {
        $this->description = $in_descr;
    }

    public function getDescr() {
        return $this->description;
    }

    public function setImgSrc($in_img) {
        $this->imgSrc = $in_img;
    }

    public function getImgSrc() {
        return $this->ImgSrc;
    }

    public function setPrepTime($in_time) {
        $this->prepTime = $in_time;
    }

    public function getPrepTime() {
        return $this->prepTime;
    }

    public function setDishLvl($in_dish) {
        $this->dishLvl = $in_dish;
    }

    public function getDishLvl() {
        return $this->dishLvl;
    }

    public function setIngredLvl($in_ingred) {
        $this->ingredLvl = $in_ingred;
    }

    public function getIngredLvl() {
        return $this->ingredLvl;
    }

    public function setDiffLvl($in_diff) {
        $this->$diffLvl = $in_diff;
    }

    public function getDiffLvl() {
        return $this->$diffLvl;
    }

// DISPLAY ALL RECIPES
public static function displayAllRecipes($db) {
    $query = "SELECT * FROM recipes";
    $statement = $db->prepare($query);
    $statement->setFetchMode(PDO::FETCH_OBJ);
    $statement->execute();

    return $statement->fetchAll();
}




}

 ?>
