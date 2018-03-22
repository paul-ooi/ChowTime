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

    // public function __construct($r_id, $qty = null, $unit = null, $prep = null, $required = true) {
    //     $this->setRecipeRef($r_id);
    //     $this->setQuantity($qty);
    //     $this->setMeasurment($unit);
    //     $this->setPreparation($prep);
    //     $this->setOptional($required);
    // }

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

}
 ?>
