<?php
require_once '../../models/ingredient.php';
require_once '../../models/ingredientDB.php';
$db = Database::getDb();
$ing = new Ingredient();

if(isset($_POST['delete'])) {
    $recipe_id = $_POST['recipe_id'];
    $ing->setRecipeRef($recipe_id);
    IngredientDB::deleteIngredient($db, $ing);
} else {
    header("Location: ../index.php");
}

?>