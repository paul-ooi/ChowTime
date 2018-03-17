<?php

class Ingredient {
    private $recipeRef;//Reference ID for the recipe
    private $name;
    private $quantity;
    private $measurment;
    private $preparation;
    private $optional;

    public function getRecipeRef() {
        return $this->recipeRef;
    }
    public function setRecipeRef($param) {
        $this->recipeRef = $param;
    }

    public function getName() {
        return $this->name;
    }
    public function setName($param) {
        $this->name = $param;
    }

    public function getQuantity() {
        return $this->quantity;
    }
    public function setQuantity($param) {
        $this->quantity = $param;
    }

    public function getMeasurment() {
        return $this->measurment;
    }
    public function setMeasurment($param) {
        $this->measurment = $param;
    }

    public function getPreparation() {
        return $this->preparation;
    }
    public function setPreparation($param) {
        $this->preparation = $param;
    }

    public function getOptional() {
        return $this->optional;
    }
    public function setOptional($param) {
        $this->optional = $param;
    }

    public function __construct($name, $qty = null, $measure = null, $prep = null, $optional = false) {
        $this->setName($name);
        $this->setQuantity($qty);
        $this->setMeasurment($measure);
        $this->setPreparation($prep);
        $this->setOptional($optional);
    }

    public static function displayAllIngredients($db) {
        $sql = "SELECT * FROM ingredients";
        $pdostm = $db->prepare($sql);

        $pdostm->setFetchMode(PDO::FETCH_OBJ);
        $pdostm->execute();

        return $pdostm->fetchAll();
    }

}
 ?>
