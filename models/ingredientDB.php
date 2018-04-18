<?php

class IngredientDB {
    //Get and Return All Ingredient entries in DB
    public static function getAllIngredients($db) {
        $query = "SELECT * FROM ingredients";
        $pdostm = $db->prepare($query);

        $pdostm->setFetchMode(PDO::FETCH_OBJ);
        $pdostm->execute();

        return $pdostm->fetchAll();
    }

    //Get and Return All Recipe Titles
    public static function getRecipeTitles($db) {
        $query = "SELECT id, title FROM recipes";
        $pdostm = $db->prepare($query);

        $pdostm->execute();
        return $pdostm->fetchAll(PDO::FETCH_OBJ);
    }

    //Get and Return All Ingredient entries in DB
    public static function getFoodNames($db) {
        $query = "SELECT id, food_name FROM ingredients ORDER BY food_name ASC";
        $pdostm = $db->prepare($query);

        $pdostm->execute();
        return $pdostm->fetchAll(PDO::FETCH_OBJ);
    }

    // public static function getRecipeIngredients($db,$recipe) {
    //     $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //     $query = "SELECT r.id AS 'rec_id', ing.id AS 'ing_id', required, quantity, unit, prep, food_name, title FROM ingredients ing LEFT JOIN foods f ON ing.food_id = f.id LEFT JOIN recipes r ON ing.recipe_id = r.id WHERE r.id = :recipe";
    //     $pdostm = $db->prepare($query);
    //     $pdostm->bindValue(':recipe',$recipe, PDO::PARAM_INT);
    //     $pdostm->execute();
    //     return $pdostm->fetchAll(PDO::FETCH_OBJ);
    // }

    //Get and Return All Ingredients for a single recipe
    public static function getRecipeIngredients($db,$recipe) {
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "SELECT ri.id AS 'rec_id', ing.id AS 'ing_id', quantity, measurement, prep, food_name, required FROM ingredients ing LEFT JOIN recipe_ingredients ri  ON ri.ingredient_id = ing.id LEFT JOIN food_types ft ON ing.food_type = ft.id LEFT JOIN measurements m ON m.id = ri.unit WHERE ri.recipe_id = :recipe_id ORDER BY required DESC;";
    $pdostm = $db->prepare($query);
    $pdostm->bindValue(':recipe_id',$recipe, PDO::PARAM_INT);
    $pdostm->execute();
    return $pdostm->fetchAll(PDO::FETCH_OBJ);
    }

    public static function getUnitMeasurements($db) {
        $query = "SELECT * FROM measurements";
        $pdostm = $db->prepare($query);

        $pdostm->execute();
        return $pdostm->fetchAll(PDO::FETCH_OBJ);
    }

    public static function addIngredient($db, $ing) {
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

    public static function deleteIngredient($db, $ingredient) {
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "DELETE FROM ingredients WHERE id = :ingredient";
        $pdostm = $db->prepare($sql);
        $pdostm->bindValue(':ingredient',$ingredient, PDO::PARAM_INT);
        $count = $pdostm->execute();

        return $count;
    }

}


 ?>
