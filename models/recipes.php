<?php
class Recipes {

    private $id;
    private $user_id;
    private $img_id;
    private $title;
    private $description;
    private $prep_time;
    private $cook_time;
    private $dish_lvl;
    private $ingred_lvl;
    private $diff_lvl;
    private $spicy_lvl;
    private $pub_date;
    private $steps;

    //FOR IMAGES
    private $recipe_id;
    private $img_src;

    public function setId($in_id) {
        $this->id = $in_id;
    }
    public function setUserId($in_user_id) {
        $this->user_id = $in_user_id;
    }
    public function setImgId($in_img_id) {
        $this->img_id = $in_img_id;
    }
    public function setTitle($in_title) {
        $this->title = $in_title;
    }
    public function setDescr($in_descr) {
        $this->description = $in_descr;
    }
    public function setPrepTime($in_prep_time) {
        $this->prep_time = $in_prep_time;
    }
    public function setCookTime($in_cook_time) {
        $this->cook_time = $in_cook_time;
    }
    public function setDishLvl($in_dish_lvl) {
        $this->dish_lvl = $in_dish_lvl;
    }
    public function setIngredLvl($in_ingred_lvl) {
        $this->ingred_lvl = $in_ingred_lvl;
    }
    public function setDiffLvl($in_diff_lvl) {
        $this->diff_lvl = $in_diff_lvl;
    }
    public function setSpicyLvl($in_spicy_lvl) {
        $this->spicy_lvl = $in_spicy_lvl;
    }
    public function setPubDate($in_pub_date) {
        $this->pub_date = $in_pub_date;
    }
    public function setSteps($in_steps) {
        $this->steps = $in_steps;
    }


    public function getId() {
        return $this->id;
    }
    public function getUserId() {
        return $this->user_id;
    }
    public function getImgId() {
        return $this->img_id;
    }
    public function getTitle() {
        return $this->title;
    }
    public function getDescr() {
        return $this->description;
    }
    public function getPrepTime() {
        return $this->prep_time;
    }
    public function getCookTime() {
        return $this->cook_time;
    }
    public function getDishLvl() {
        return $this->dish_lvl;
    }
    public function getIngredLvl() {
        return $this->ingred_lvl;
    }
    public function getDiffLvl() {
        return $this->diff_lvl;
    }
    public function getSpicyLvl() {
        return $this->spicy_lvl;
    }
    public function getPubDate() {
        return $this->pub_date;
    }
    public function getSteps() {
        return $this->steps;
    }

    public function setRecipeId($recipe_id) {
        $this->recipe_id = $recipe_id;
    }

    public function setImgSrc($in_img_src) {
        $this->img_src = $in_img_src;
    }

    public function getRecipeId() {
        return $this->recipe_id;
    }

    public function getImgSrc() {
        return $this->img_src;
    }

    public function setRecipeProps($id, $user_id, $img_id, $title, $description, $prep_time, $cook_time, $dishes_lvl, $ingred_lvl, $diff_lvl, $spicy_lvl, $steps) {
        $this->setId($id);
        $this->setUserId($user_id);
        $this->setImgId($img_id);
        $this->setTitle($title);
        $this->setDescr($description);
        $this->setPrepTime($prep_time);
        $this->setCookTime($cook_time);
        $this->setDishLvl($dishes_lvl);
        $this->setIngredLvl($ingred_lvl);
        $this->setDiffLvl($diff_lvl);
        $this->setSpicyLvl($spicy_lvl);
        $this->setSteps($steps);
    }

    public function setRecipeUpdate($id, $title, $description, $prep_time, $cook_time, $dishes_lvl, $ingred_lvl, $diff_lvl, $spicy_lvl, $pub_date, $steps) {
        $this->setId($id);
        $this->setTitle($title);
        $this->setDescr($description);
        $this->setPrepTime($prep_time);
        $this->setCookTime($cook_time);
        $this->setDishLvl($dishes_lvl);
        $this->setIngredLvl($ingred_lvl);
        $this->setDiffLvl($diff_lvl);
        $this->setSpicyLvl($spicy_lvl);
        $this->setPubDate($pub_date);
        $this->setSteps($steps);
    }

    //SET NEW CONSTRUCTOR
    public function __construct() {

    }

}
?>
