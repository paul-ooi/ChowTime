<?php

if(isset($_POST['deleteRecipe'])) {
    //IF USER IS AN ADMIN
    if($_POST['user_role'] == 1) {
        require_once '../../models/db.php';
        require_once '../../models/recipeDB.php';

    $errors = array();
    $recipe_id = $_POST['recipe_id'];   

    function createErrorSession($e) {
        $_SESSION['recipe_err_mssg'] = $e;
    }
    /*************************************************************/
    
    //DELETE THE IMAGES AND RECIPES
    $count = RecipeDb::deleteRecipe($recipe_id);

    if($count == 2) {
        header("Location: ../../index.php");
    } else {
        $error['delete_error'] = "There was an error with the deletion of the recipe.";
        createErrorSession($error);
        header("Location: ../../pages/recipes.php");
    }

    } else {
        header("Location: ../../pages/login.php");
    }
}
?>