<?php
require_once '../models/db.php';
require_once '../models/ingredient.php';


if(isset($_POST['deleteIngred'])) {

    $ing = new Ingredient();
    echo '<pre>';
    var_dump($_POST);
    echo '</pre>';

    //get Ingredient
    $ing_id = intval($_POST['del_ing_id']);

    //call database
    $count = $ing->deleteIngredient(Database::getDb(), $ing_id);
    echo '<pre>';
    var_dump($ing);
    echo '</pre>';

    //Confirm Deleted the specific ingredient
    if ($count) {
        header("Location: _viewingredients.php");
    } else {
        echo "Error deleting ingredient.";
    }

} else {
    header("Location: _viewingredients.php");
}

 ?>
