<?php
// session_start();
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

/* =======================POPUALTE RECIPE TO UPDATE ================== */
if(isset($_POST['updateRecipe'])) {
    $r = new RecipeDb();

    $recipe_id = $_POST['recipe_id'];
    $allRecipes = $r->displayById($recipe_id);
    $recipeImgs = $r->allRecipeImgs($recipe_id);
    $datetime = $r->displayDateTime($recipe_id);
    $prepCookTimes = $r->getRecipeTimeInMin($recipe_id);

    $title = $allRecipes->title;
    $description = $allRecipes->description;
    $dishlvl = $allRecipes->dishes_lvl;
    $ingredlvl = $allRecipes->ingred_lvl;
    $difflvl = $allRecipes->diff_lvl;
    $spicelvl = $allRecipes->spicy_lvl;
    $steps = $allRecipes->steps;

    //PUB DATE SEPARATED INTO DATE AND TIME
    $date = $datetime->d;
    $time = $datetime->t;

    //PREP/COOK TIME
    $preptime = $prepCookTimes->CT;
    $cooktime = $prepCookTimes->PT;
}
 /* =======================DELETING PHOTOS ================== */
    if(isset($_POST['img_src'])) {
        $img_src = $_POST['img_src'];
        $count = deleteImgSrc($img_src);
        echo $count;
    }

    function deleteImgSrc($img_src) {
        require_once '../../models/recipeDB.php';
        require_once '../../models/db.php';
        $r = new RecipeDb();

        $count = $r->deleteImg($img_src);
        return $count;
    }
 /* =======================PROCESS UPDATE ================== */

if(isset($_POST['update'])) {
    require_once '../models/validation.php';
    require_once '../models/recipeDB.php';
    require_once '../models/db.php';
    require_once '../models/recipes.php';

    $v = new Validation();
    $r = new Recipes();
    $rDb = new RecipeDb();

    $errors = array();

    /**********************REPOPULATE THE FORM**********************/
    $recipe_id = $_POST['recipe_id'];
    $allRecipes = $rDb->displayById($recipe_id);
    $recipeImgs = $rDb->allRecipeImgs($recipe_id);
    $datetime = $rDb->displayDateTime($recipe_id);
    $prepCookTimes = $rDb->getRecipeTimeInMin($recipe_id);
    
    $title = $allRecipes->title;
    $description = $allRecipes->description;
    $dishlvl = $allRecipes->dishes_lvl;
    $ingredlvl = $allRecipes->ingred_lvl;
    $difflvl = $allRecipes->diff_lvl;
    $spicelvl = $allRecipes->spicy_lvl;
    $steps = $allRecipes->steps;

    $date = $datetime->d;
    $time = $datetime->t;

    $preptime = $prepCookTimes->CT;
    $cooktime = $prepCookTimes->PT;
    /**********************VALIDATE INPUTS**********************/


    $title = $v->checkAssignProperty('inTitle');
    $desc = $v->checkAssignProperty('inDesc');
    $prepTime = $v->checkAssignProperty('inPrep');
    $cookTime = $v->checkAssignProperty('inCook');
    $dishDiff = $v->checkAssignProperty('inDish');
    $ingredDiff = $v->checkAssignProperty('inIngred');
    $overallDiff = $v->checkAssignProperty('inOverallDiff');
    $date = $v->checkAssignProperty('inDate');
    $time = $v->checkAssignProperty('inTime');

    if(isset($_POST['inSpice'])){
        $spiceLvl = $_POST['inSpice'];
    }
    /************************FUNCTIONS****************************/
   function createSession($err) {
        $_SESSION['recipe_err_mssg'] = $err;
    }

    function checkForEmptySteps() {
        $steps = "";
        foreach($_POST['item'] as $key => $value) {
            $steps .= $value['step'];
        }
        if($steps == "") {
            return null;
        }
        return true;
    }

    //RETURN ALL STEPS TO ADD TO DATABASE
    function getAllSteps() {
        $steps = "";
        $count = 0;
        foreach($_POST['item'] as $key => $value) {
            $count++;
        }
        foreach($_POST['item'] as $key => $value) {
            if(($count-1) == $key) {
                $steps .= $value['step'];
            }
            $steps .= ($value['step'] . ';');
        }
    }

    /************************VALIDATION****************************/

    if(checkForEmptySteps() == null || $title == null || $desc == null || $prepTime == null || $cookTime == null || $dishDiff == null || $ingredDiff == null || $overallDiff == null || $spiceLvl == null || $date == null || $time == null){
        $errors['update_input_error'] = "Please fill out all fields to update your recipe";
        createSession($errors);
        return false;
    } else {
        unset($_SESSION['recipe_err_mssg']);

        //UPDATE SET VALUES THEN UPDATE

    }
    
    var_dump($_SESSION);    

} //END POST




 ?>