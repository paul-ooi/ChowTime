<!--
TO DO
=====
-Ensure the time format is proper when adding
-Get values from different table
-Populate recipes that is larger with instructions
-Get id's from sessions / user clicking
 -->

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

    public function setId($in_id) {
        $this->id = $in_id;
    }

    public function getId() {
        return $this->id;
    }

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
        return $this->imgSrc;
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
        $this->diffLvl = $in_diff;
    }

    public function getDiffLvl() {
        return $this->diffLvl;
    }

//SET ALL PARAMETERS
public function __construct($title, $descr, $img, $time, $dish, $ingred, $diff) {
    $this->setId(null);
    $this->setTitle($title);
    $this->setDescr($descr);
    $this->setImgSrc($img);
    $this->setPrepTime($time);
    $this->setDishLvl($dish);
    $this->setIngredLvl($ingred);
    $this->setDiffLvl($diff);
}

// DISPLAY ALL RECIPES
public function displayAllRecipes($db) {
    $query = "SELECT * FROM recipes";
    $statement = $db->prepare($query);
    $statement->setFetchMode(PDO::FETCH_OBJ);
    $statement->execute();

    return $statement->fetchAll();
}

//ADD A RECIPE
public function addRecipe($db) {
    $query = "INSERT INTO recipes VALUES (:id, :title, :descr, :img, :prep_time, :dish, :ingred, :diff)";

    $statement = $db->prepare($query);
    $id = $this->getId();
    $title = $this->getTitle();
    $descr = $this->getDescr();
    $img = $this->getImgSrc();
    $prep = $this->getPrepTime();
    $dish = $this->getDishLvl();
    $ingred = $this->getIngredLvl();
    $diff = $this->getDiffLvl();

    $statement->bindValue(':id', $id);
    $statement->bindValue(':title', $title);
    $statement->bindValue(':descr', $descr);
    $statement->bindValue(':img', $img);
    $statement->bindValue(':prep_time', $prep);
    $statement->bindValue(':dish', $dish);
    $statement->bindValue(':ingred', $ingred);
    $statement->bindValue(':diff', $diff);

    $statement->setFetchMode(PDO::FETCH_OBJ);
    $count = $statement->execute();

    return $count;
}

//DELETE A RECIPE
public function deleteRecipe($db, $id) {
    $query = "DELETE FROM recipes WHERE id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(":id", $id);
    $statement->setFetchMode(PDO::FETCH_OBJ);
    $count = $statement->execute();

    return $count;
}

//UPDATE A RECIPE (also should be done based on user session)
//Default params are exhisting params from the recipe
public function updateRecipe($db, $in_id) {
    $query = "UPDATE Recipes SET
                title = :title,
                descr =  :descr,
                img = :img,
                prep = :prep,
                ingred = :ingred,
                diff = :diff,
              WHERE id = :id";

    $this->setId($in_id);
    $id = $this->getId();
    $title = $this->getTitle();
    $descr = $this->getDescr();
    $img = $this->getImgSrc();
    $prep = $this->getPrepTime();
    $dish = $this->getDishLvl();
    $ingred = $this->getIngredLvl();
    $diff = $this->getDiffLvl();

    $statement = $db->prepare($query);
    $statement->bindValue(":id", $id);
    $statement->bindValue(":title", $title);
    $statement->bindValue(":descr", $descr);
    $statement->bindValue(":img", $img);
    $statement->bindValue(":prep", $prep);
    $statement->bindValue(":ingred", $ingred);
    $statement->bindValue(":diff", $diff);
    $statement->setFetchMode(PDO::FETCH_OBJ);
    $count = $statement->execute();

    return $count; 
}

}

 ?>
