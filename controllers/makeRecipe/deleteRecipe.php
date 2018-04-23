<?php

if(isset($_POST['delete'])) {
    //IF USER IS AN ADMIN
    if($_POST['user_role'] == 1) {
        require_once '../../models/db.php';
        require_once '../../models/recipeDB.php';
        require_once '../../models/Recipes.php';

        $errors = array();
        $recipe_id = $_POST['recipe_id'];

        function createErrorSession($e) {
            $_SESSION['recipe_err_mssg'] = $e;
        }
        /*************************************************************/
        
        //DELETE INGREDIENTS LINKED TO THIS RECIPE
        require_once '../ingredients/ingredient_delete.php';

        //DELETE THE IMAGES AND RECIPES
        $count = RecipeDb::deleteRecipe($recipe_id);
        $images = RecipeDb::getImgSrc($recipe_id);

        if($count == 2) {
            //DELETE THE IMAGE FROM THE DIRECTORY
            foreach($images as $img) {
                $imgs[] = $img->getImgSrc();
            }

            $filepath = "../";

            for($i = 0; $i<count($imgs); $i++) {
                $targetFile = $filepath . $imgs[$i];
                if(file_exists($targetFile)){
                    unlink($targetFile);
                }
            }

            //DELETE ALL RECORDS OF RECIPES_MADE FOR THAT RECIPE
        header("Location: ../../index.php");
        } else {
            $errors['delete_error'] = "There was an error with the deletion of the recipe.";
            createErrorSession($errors);
            header("Location: ../../pages/recipes.php");
        }
    }
    else {
        header("Location: ../../pages/login.php");
    }
}
else {
    header("Location: ../../pages/login.php");
}
?>