<?php
// session_start();
$r = new RecipeDb();

if(isset($_POST['updateRecipe'])) {
    $recipe_id = $_POST['recipe_id'];

    $allRecipes = $r->displayById($recipe_id);
    $recipeImgs = $r->allRecipeImgs($recipe_id);
    $datetime = $r->displayDateTime($recipe_id);

    $title = $allRecipes->title;
    $description = $allRecipes->description;
    $preptime = $allRecipes->prep_time;
    $cooktime = $allRecipes->cook_time;
    $dishlvl = $allRecipes->dishes_lvl;
    $ingredlvl = $allRecipes->ingred_lvl;
    $difflvl = $allRecipes->diff_lvl;
    $spicelvl = $allRecipes->spicy_lvl;
    $steps = $allRecipes->steps;

    $date = $datetime->d;
    $time = $datetime->t;

/* =======================ARRAYS TO DISPLAY ================== */
 // DIFF LEVEL ARRAY
 $diff['diff_level'] = array (
     "01" => '1',
     "02" => '2',
     "03" => '3',
     "04" => '4',
     "05" => '5'
 );

 //NUM DISH LEVEL
 $dish['dish_lvl'] = array (
     "001" => '1',
     "002" => '2',
     "003" => '3',
     "004" => '4',
     "005" => '5'
 );

 //INGRED DIFF
 $ingred['ingred_diff'] = array (
     "1" => '1',
     "2" => '2',
     "3" => '3',
     "4" => '4',
     "5" => '5'
 );

 //SPICY LEVEL
 $spicy['spicy_lvl'] = array (
     "0" => "None, Zero.",
     "1" => "Barely taste it.",
     "2" => "Ok, I feel some heat.",
     "3" => "That's Spicy.",
     "4" => "I Can't Feel My Tongue Anymore.",
     "5" => "Is my Face Melting?"
 );
 /* =======================END ARRAYS TO DISPLAY ================== */
}

 /* =======================VALIDATE UPDATE ================== */

if(isset($_POST['update'])) {
    $v = new Validation();

    $errors = array();

    $r = new Recipes();

}




 ?>