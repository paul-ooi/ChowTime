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
    private $user_id;
    private $img_id;
    private $title;
    private $description;
    private $total_time;
    private $prep_time;
    private $cook_time;
    private $dishes_lvl;
    private $ingred_lvl;
    private $diff_lvl;
    private $spicy_lvl;
    private $recomm_diff;
    private $pub_date;
    private $steps;

    public function setId($in_id) {
        $this->id = $in_id;
    }
    public function setUserId($in_user_id) {
        $this->user_id = $in_user_id;
    }
    public function setImgSrc($in_img_id) {
        $this->img_id = $in_img_id;
    }
    public function setTitle($in_title) {
        $this->title = $in_title;
    }
    public function setDescr($in_descr) {
        $this->description = $in_descr;
    }
    public function setTotalTime($in_total_time) {
        $this->total_time = $in_total_time;
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
    public function setRecommDiff($in_recomm_diff) {
        $this->recomm_diff = $in_recomm_diff;
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
    public function getTotalTime() {
        return $this->total_time;
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
    public function getRecommDiff() {
        return $this->recomm_diff;
    }
    public function getPubDate() {
        return $this->pub_date;
    }
    public function getSteps() {
        return $this->steps;
    }

//SET NEW CONSTRUCTOR
public function __construct() {

}

// DISPLAY ALL RECIPES
public function displayAllRecipes($db) {
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "SELECT * FROM recipes";
    $statement = $db->prepare($query);
    $statement->setFetchMode(PDO::FETCH_OBJ);
    $statement->execute();

    return $statement->fetchAll();
}

//DISPLAY ONLY RECIPE NAME
public function displayByTitle($db, $title) {
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "SELECT title FROM recipes WHERE title LIKE '%$title%';";
    $statement = $db->prepare($query);
    $statement->bindValue(":title", $title, PDO::PARAM_STR);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_OBJ);
}

//DISPLAY RECIPE BY ID
public function displayById($db, $in_id) {
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "SELECT * FROM recipes WHERE id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $in_id, PDO::PARAM_INT);
    $statement->setFetchMode(PDO::FETCH_OBJ);
    $statement->execute();
    return $statement->fetch();
}

//ADD A RECIPE
public function addRecipe($db, $in_id, $in_user_id, $in_img_id, $in_title, $in_descr, $in_t_time, $in_p_time, $in_c_time, $in_dish, $in_ingred, $in_diff, $in_spicy, $in_recomm, $in_p_date, $in_steps) {
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "INSERT INTO recipes VALUES (:id, :user_id, :img_id, :title, :descr, :t_time, :p_time, :c_time, :dish, :ingred, :diff, :spicy, :recomm, :p_date, :steps)";

    $statement = $db->prepare($query);

    $this->setId($in_id);
    $this->setUserId($in_user_id);
    $this->setImgSrc($in_img_id);
    $this->setTitle($in_title);
    $this->setDescr($in_descr);
    $this->setTotalTime($in_t_time);
    $this->setPrepTime($in_p_time);
    $this->setCookTime($in_c_time);
    $this->setDishLvl($in_dish);
    $this->setIngredLvl($in_ingred);
    $this->setDiffLvl($in_diff);
    $this->setSpicyLvl($in_spicy);
    $this->setRecommDiff($in_recomm);
    $this->setPubDate($in_p_date);
    $this->setSteps($in_steps);

    $id = $this->getId();
    $user_id = $this->getUserId();
    $img_id = $this->getImgId();
    $title = $this->getTitle();
    $descr = $this->getDescr();
    $t_time = $this->getTotalTime();
    $p_time = $this->getPrepTime();
    $c_time = $this->getCookTime();
    $dish = $this->getDishLvl();
    $ingred = $this->getIngredLvl();
    $diff = $this->getDiffLvl();
    $spicy = $this->getSpicyLvl();
    $recommD = $this->getRecommDiff();
    $p_date = $this->getPubDate();
    $steps = $this->getSteps();

    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $statement->bindValue(':img_id', $img_id, PDO::PARAM_INT);
    $statement->bindValue(':title', $title, PDO::PARAM_STR);
    $statement->bindValue(':descr', $descr, PDO::PARAM_STR);
    $statement->bindValue(':t_time', $t_time);
    $statement->bindValue(':p_time', $p_time);
    $statement->bindValue(':c_time', $c_time);
    $statement->bindValue(':dish', $dish, PDO::PARAM_INT);
    $statement->bindValue(':ingred', $ingred, PDO::PARAM_INT);
    $statement->bindValue(':diff', $diff, PDO::PARAM_INT);
    $statement->bindValue(':spicy', $spicy, PDO::PARAM_INT);
    $statement->bindValue(':recomm', $recommD, PDO::PARAM_INT);
    $statement->bindValue(':p_date', $p_date);
    $statement->bindValue(':steps', $steps, PDO::PARAM_STR);

    $statement->setFetchMode(PDO::FETCH_OBJ);
    $count = $statement->execute();

    return $count;
}

//UPDATE A RECIPE (also should be done based on user session)
//Default params are exhisting params from the recipe
public function updateRecipe($db, $in_id) {
    $query = "UPDATE Recipes SET
                user_id = :u_id,
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
    $statement->bindValue(":id", $id, PDO::PARAM_INT);
    $statement->bindValue(":title", $title, PDO::PARAM_STR);
    $statement->bindValue(":descr", $descr, PDO::PARAM_STR);
    $statement->bindValue(":img", $img, PDO::PARAM_STR);
    $statement->bindValue(":prep", $prep, PDO::PARAM_STR);
    $statement->bindValue(":ingred", $ingred, PDO::PARAM_STR);
    $statement->bindValue(":diff", $diff, PDO::PARAM_STR);
    $statement->setFetchMode(PDO::FETCH_OBJ);
    $count = $statement->execute();

    return $count;
}
//DELETE A RECIPE
public function deleteRecipe($db, $id) {
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "DELETE FROM recipes WHERE id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(":id", $id, PDO::PARAM_INT);
    $statement->setFetchMode(PDO::FETCH_OBJ);
    $count = $statement->execute();

    return $count;
}

//TOTAL RECIPE TIME
public function totalRecipeTime($db, $id) {
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "SELECT ADDTIME(prep_time, cook_time) AS 'total_time' FROM recipes WHERE id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(":id", $id, PDO::PARAM_INT);
    $statement->setFetchMode(PDO::FETCH_OBJ);
    $statement->execute();
    return $statement->fetch();
}

//RECOMMENDED DIFFICULTY
public function recommDiff($db, $id) {
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "SELECT ROUND(((dishes_lvl + ingred_lvl + spicy_lvl)/3), 2) AS 'recomm_diff' FROM recipes WHERE id= :id";
    $statement = $db->prepare($query);
    $statement->bindValue(":id", $id);
    $statement->setFetchMode(PDO::FETCH_OBJ);
    $statement->execute();
    return $statement->fetch();
}

//MAIN RECIPE IMAGE
public function mainRecipeImg($db, $id) {
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "SELECT img_src FROM recipe_imgs ri
    JOIN recipes r
    ON r.main_img_id = ri.id
    WHERE r.id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(":id", $id);
    $statement->setFetchMode(PDO::FETCH_OBJ);
    $statement->execute();

    return $statement->fetch();
}

//ALL RECIPE IMAGES
public function allRecipeImgs($db, $id) {
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "SELECT img_src FROM recipe_imgs ri
    JOIN recipes r
    ON r.id = ri.recipe_id
    WHERE r.id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(":id", $id);
    $statement->setFetchMode(PDO::FETCH_OBJ);
    $statement->execute();

    return $statement->fetchAll();
}


}

 ?>
