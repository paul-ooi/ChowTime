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

    //Get and Return All Ingredients for a single recipe
    public static function getRecipeIngredients($db,$recipe) {
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "SELECT ri.recipe_id AS 'rec_id', ing.id AS 'ing_id', quantity, unit, measurement, prep, food_name, required FROM ingredients ing LEFT JOIN recipe_ingredients ri  ON ri.ingredient_id = ing.id LEFT JOIN food_types ft ON ing.food_type = ft.id LEFT JOIN measurements m ON m.id = ri.unit WHERE ri.recipe_id = :recipe_id ORDER BY required DESC;";
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

    //ADD INGREDIENTS ASSIGNED TO A RECIPE TO THE RECIPE_INGREDIENTS TABLE
    public static function addIngredient($db, $ing) {
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $count = 0;

        foreach ($ing as $ingredient) {
            $sql = "INSERT INTO recipe_ingredients (recipe_id, quantity, unit, prep, ingredient_id, required) VALUES (:recipe, :qty, :unit, :prep, :food, :req)";
            $pdostm = $db->prepare($sql);
            $pdostm->bindValue(':recipe',$ingredient->getRecipeRef(), PDO::PARAM_INT);
            $pdostm->bindValue(':qty',$ingredient->getQuantity(), PDO::PARAM_STR);
            $pdostm->bindValue(':unit',$ingredient->getUnit(), PDO::PARAM_INT);
            $pdostm->bindValue(':prep',$ingredient->getPreparation(), PDO::PARAM_STR);
            $pdostm->bindValue(':food',$ingredient->getFoodId(), PDO::PARAM_INT);
            $pdostm->bindValue(':req',$ingredient->getOptional(), PDO::PARAM_INT);
            if ($pdostm->execute()) {
                $count++;
            };

        }
        return $count;
    }

    //UPDATE INGREDIENTS ASSIGNED TO A RECIPE TO THE RECIPE_INGREDIENTS TABLE
    public static function updateIngredient($db, $ing) {
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $count = 0;

        //SINCE USER CAN CHANGE THE NUMBER OF INGREDIENTS PER RECIPE, DELETE OF ALL PRIOR INGREDIENTS THEN INSERT NEW LIST
        //DELETE EXISTING ROWS OF INGREDIENTS ASSIGNED TO THAT RECIPE
        // $sql = "DELETE FROM recipe_ingredients WHERE recipe_id = :recipe";
        // $pdostm = $db->prepare($sql);
        // $pdostm->bindValue(':recipe',$ing[0]->getRecipeRef(), PDO::PARAM_INT);
        // $pdostm->execute();
        self::deleteIngredient($db, $ing[0]);

        //ADD INGREDIENTS ASSIGNED TO THAT RECIPE TO THE RECIPE_INGREDIENTS TABLE
        foreach ($ing as $ingredient) {
            $sql = "INSERT INTO recipe_ingredients (recipe_id, quantity, unit, prep, ingredient_id, required) VALUES (:recipe, :qty, :unit, :prep, :food, :req)";
            $pdostm = $db->prepare($sql);
            $pdostm->bindValue(':recipe',$ingredient->getRecipeRef(), PDO::PARAM_INT);
            $pdostm->bindValue(':qty',$ingredient->getQuantity(), PDO::PARAM_STR);
            $pdostm->bindValue(':unit',$ingredient->getUnit(), PDO::PARAM_INT);
            $pdostm->bindValue(':prep',$ingredient->getPreparation(), PDO::PARAM_STR);
            $pdostm->bindValue(':food',$ingredient->getFoodId(), PDO::PARAM_INT);
            $pdostm->bindValue(':req',$ingredient->getOptional(), PDO::PARAM_INT);
            if ($pdostm->execute()) {
                $count++;
            };

        }

        return $count;
    }

     //DELETE INGREDIENTS ASSIGNED TO A RECIPE TO THE RECIPE_INGREDIENTS TABLE
     public static function deleteIngredient($db, $ing) {
        $sql = "DELETE FROM recipe_ingredients WHERE recipe_id = :recipe";
        $pdostm = $db->prepare($sql);
        $pdostm->bindValue(':recipe',$ing->getRecipeRef(), PDO::PARAM_INT);
        $pdostm->execute();
     }

     //DELETE INGREDIENT ITEM FROM THE MASTER INGREDIENT LIST
    public static function deleteIngredientItem($db, $ingredient) {
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "DELETE FROM ingredients WHERE id = :ingredient";
        $pdostm = $db->prepare($sql);
        $pdostm->bindValue(':ingredient',$ingredient, PDO::PARAM_INT);
        $count = $pdostm->execute();

        return $count;
    }

}


 ?>
