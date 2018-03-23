<?php

class Ingredient {
    private $id;
    private $recipe_id;//Reference ID from the Recipe table
    private $food_id;//Reference ID from the Food Table
    private $quantity;
    private $unit; //Tablespoon, Cup, ML
    private $preparation;
    private $required;

    public function getRecipeRef() {
        return $this->recipe_id;
    }
    public function setRecipeRef($param) {
        $this->recipe_id = $param;
    }

    public function getFoodId() {
        return $this->food_id;
    }
    public function setFoodId($param) {
        $this->food_id = $param;
    }

    public function getQuantity() {
        return $this->quantity;
    }
    public function setQuantity($param) {
        $this->quantity = $param;
    }

    public function getUnit() {
        return $this->unit;
    }
    public function setUnit($param) {
        $this->unit = $param;
    }

    public function getPreparation() {
        return $this->preparation;
    }
    public function setPreparation($param) {
        $this->preparation = $param;
    }

    public function getOptional() {
        return $this->required;
    }
    public function setOptional($param) {
        $this->required = $param;
    }

    public function __construct($r_id = '', $f_id = '' ,$qty = '', $unit = '', $prep = '', $required = true) {
        $this->setRecipeRef($r_id);
        $this->setFoodId($f_id);
        $this->setQuantity($qty);
        $this->setUnit($unit);
        $this->setPreparation($prep);
        $this->setOptional($required);
    }

    public function displayAllIngredients($db) {
        $query = "SELECT * FROM ingredients";
        $pdostm = $db->prepare($query);

        $pdostm->setFetchMode(PDO::FETCH_OBJ);
        $pdostm->execute();

        return $pdostm->fetchAll();
    }

    public function getRecipeTitles($db) {
        $query = "SELECT id, title FROM recipes";
        $pdostm = $db->prepare($query);

        $pdostm->execute();
        return $pdostm->fetchAll(PDO::FETCH_OBJ);
    }

    public function getFoodNames($db) {
        $query = "SELECT id, food_name FROM foods";
        $pdostm = $db->prepare($query);

        $pdostm->execute();
        return $pdostm->fetchAll(PDO::FETCH_OBJ);
    }

    public function getRecipeIngredients($db,$recipe) {
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "SELECT r.id AS 'rec_id', ing.id AS 'ing_id', required, quantity, unit, prep, food_name, title FROM ingredients ing LEFT JOIN foods f ON ing.food_id = f.id LEFT JOIN recipes r ON ing.recipe_id = r.id WHERE r.id = :recipe";
        $pdostm = $db->prepare($query);
        $pdostm->bindValue(':recipe',$recipe, PDO::PARAM_INT);
        $pdostm->execute();
        return $pdostm->fetchAll(PDO::FETCH_OBJ);
    }

    public function addIngredient($db, $ing) {
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO ingredients (recipe_id, quantity, unit, prep, food_id, required) VALUES (:recipe, :qty, :unit, :prep, :food, :req)";
        $pdostm = $db->prepare($sql);
        $pdostm->bindValue(':recipe',$ing->recipe_id, PDO::PARAM_INT);
        $pdostm->bindValue(':qty',$ing->quantity, PDO::PARAM_STR);
        $pdostm->bindValue(':unit',$ing->unit, PDO::PARAM_STR);
        $pdostm->bindValue(':prep',$ing->preparation, PDO::PARAM_STR);
        $pdostm->bindValue(':food',$ing->food_id, PDO::PARAM_INT);
        $pdostm->bindValue(':req',$ing->required, PDO::PARAM_STR);
        $count = $pdostm->execute();

        return $count;
    }

    public function deleteIngredient($db, $ingredient) {
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "DELETE FROM ingredients WHERE id = :ingredient";
        $pdostm = $db->prepare($sql);
        $pdostm->bindValue(':ingredient',$ingredient, PDO::PARAM_INT);
        $count = $pdostm->execute();

        return $count;
    }

}
 ?>
