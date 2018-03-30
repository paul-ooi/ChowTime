<?php
include_once '../../validators/validation.php';
include_once '../../models/recipesMade.php';
include_once '../../models/db.php';

$validate = new Validation();
$recipesMade = new RecipesMade();

if(isset($_POST['deleteRM'])) {
    $id = $_POST['upId'];

    $count = $recipesMade->deleteRecipeMade(Database::getDb(), $id);
}

 ?>
