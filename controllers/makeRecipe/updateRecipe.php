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

}//END UPDATE RECIPE
 /* =======================DELETING PHOTOS ================== */
    if(isset($_POST['img_src'])) {
        $img_src = $_POST['img_src'];
        $result = deleteImgSrc($img_src);
        var_dump($result);
    }

    function moreThanOne($imgArr) {
        $length = count($imgArr);
        if($length > 1) {
            return true;
        }
        else {
            return false;
        }
    }

    function isMain($mainImgId, $img_id) {
        if($mainImgId == $img_id) {
            return true;
        }
        else {
            return false;
        }
    }

    function deleteImgSrc($img_src) {
        require_once '../../models/recipeDB.php';
        require_once '../../models/db.php';
        $r = new RecipeDb();
        
        $recipe_idObj = $r->getRecipeIdFromSrc($img_src);
        $recipe_id = $recipe_idObj->recipe_id;

        $imgIdToDelObj = $r->getImgIdFromSrc($img_src);
        $imgToDel = $imgIdToDelObj->id;

        $recipeImgs = $r->allRecipeImgs($recipe_id);        
        $mainImgIdObj = $r->getMainImgId($recipe_id);
        $mainImgId = $mainImgIdObj->main_img_id;

        $nextRecipeId = $r->getRecipeIdFromSrc($img_src);

        $moreThanOne = moreThanOne($recipeImgs);
        $isMain = isMain($mainImgId, $imgToDel);

        //DETERMINE IF THE IMAGE TO DELETE IS THE MAIN IMAGE
        //COUNT THE TOTAL IMAGES. IF THERE IS MORE THAN 1, CHECK IF THIS IMAGE IS THE MAIN IMAGE
        if($moreThanOne) {
            //IF THERE IS MORE THAN ONE, AND IT IS THE MAIN IMAGE, MAKE THE SECOND IMAGE THE MAIN IMAGE, DELETE THE SELECTED
            if($isMain) {
                $nextRecipeSrc = $recipeImgs[1]->img_src;                
                $nextRecipeIdObj = $r->getRecipeIdFromSrc($nextRecipeSrc); 
                $nextRecipeId = $nextRecipeIdObj->recipe_id;

                $updated = $r->updateRecipeMainImgId($nextRecipeId, $recipe_id);
                $count = $r->deleteImg($img_src);
                return $count . " image has been deleted";
            }//END IS MAIN
            else {
                $count = $r->deleteImg($img_src);
                return $count . " image has been deleted";
            }
        }//END MORE THAN ONE
        else {
            return "Cannot delete the main image. You must have at least one.";
        }
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

    $user_id = $_SESSION['user_id'];
    $recipe_id = $_POST['recipe_id'];
    /**********************VALIDATE INPUTS**********************/
    $intitle = $v->checkAssignProperty('inTitle');
    $indesc = $v->checkAssignProperty('inDesc');
    $inprepTime = $v->checkAssignProperty('inPrep');
    $incookTime = $v->checkAssignProperty('inCook');
    $indishDiff = $v->checkAssignProperty('inDish');
    $iningredDiff = $v->checkAssignProperty('inIngred');
    $inoverallDiff = $v->checkAssignProperty('inOverallDiff');
    $indate = $v->checkAssignProperty('inDate');
    $intime = $v->checkAssignProperty('inTime');

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
                $val = trim($value['step']);
                $steps .= $val;
            } else {
                $val = trim($value['step']);
                $steps .= ($val . ';');
            }
        }
        return $steps;
    }

    //FILE VALIDATION
    function checkFiles($errors, $recipe) {
        if(!isset($_FILES)) {
            unset($_SESSION['recipe_err_mssg']);
            return true;
        }
        $file_size = $_FILES['upfile']['size']; //in bytes
        $file_type = $_FILES['upfile']['type'];
        $file_error = $_FILES['upfile']['error'];
        $file_name = $_FILES['upfile']['name'];
        $file_temp = $_FILES['upfile']['tmp_name'];
        //HANDLING FILE ERRORS = ERRORS['FILE_ERROR']

        if ($file_error > 0) {
            switch($file_error) {
                case 1:
                $errors['file_error'] = "File exceeded upload_max_filesize";
                createSession($errors);
                return false;
                case 2:
                $errors['file_error'] = "File exceeded max_file_size";
                createSession($errors);
                return false;
                case 3:
                $errors['file_error'] = "File only partially uploaded";
                createSession($errors);
                return false;
                case 4:
                $errors['file_error'] = "No file uploaded";
                unset($_SESSION['recipe_err_mssg']);
                return true;
            }
        exit;
        }

        $max_file_size = 200000;
        if($file_size > $max_file_size) {
            $errors['file_error'] = "File size too big";
            createSession($errors);
            return false;
        }

        $num = RecipeDB::getImageCount();
        $next_num = $num[0] + 1;

        $tmp = explode(".", $file_name);
        $new_file_name = "image" . $next_num . "." . end($tmp);
        $target_path = "../assets/imgs/";

        $img_src = $target_path . $new_file_name;
        $recipe->setImgSrc($img_src);

        if(move_uploaded_file($file_temp, $target_path . $new_file_name)) {
            unset($_SESSION['recipe_err_mssg']);
            return true;
        } else {
            $errors['file_error'] = "There was an error";
            createSession($errors);
            return false;
        }
    }//END CHECKFILES

    //BEGIN CHECK INPUT FIELDS
    function checkInputFields($inTitle, $inDescr, $inPrepTime, $inCookTime, $spiceLevel, $ingredDiff, $overallDiff, $in_dishLvl, $steps, $date, $time, $errors) {
        if ($inTitle == null || $inDescr == null || $inPrepTime == null || $inCookTime == null || $spiceLevel == null || $ingredDiff == null || $overallDiff == null || $in_dishLvl == null || $steps == null || $date == null || $time == null) {
        $errors['input_field_error'] = "Please fill out all fields to add a recipe!";
        createSession($errors);
        return false;
        } else {
            unset($_SESSION['recipe_err_mssg']);
            return true;
        }
    }
    /************************UPDATE****************************/
    //IF ALL INFORMATION IS VALID
    if(checkInputFields($intitle, $indesc, $inprepTime, $incookTime, $spiceLvl, $iningredDiff, $inoverallDiff, $indishDiff, checkForEmptySteps(), $indate, $intime, $errors)) {
        //INSERT INTO DATABASE RECIPES

        $datetime = $indate . " " . $intime;
        $steps = getAllSteps();

        $r->setRecipeUpdate($user_id, $intitle, $indesc, $inprepTime, $incookTime, $indishDiff, $iningredDiff, $inoverallDiff, $spiceLvl, $datetime, $steps);
        $updates = RecipeDB::updateRecipe($r);

        //REPOPULATE THE FORM
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

    } else {
        //REPOPULATE THE FORM
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
    }

    //CHECK FILE INFORMATION                    
    if(checkFiles($errors, $r)) {
    //INSERT INTO DATABASE (RECIPE IMGS) - NOTE RECIPE_IMG_SRC ALREADY SET IN CHECK FILES
        $r->setRecipeId($recipe_id);

        $img_in = RecipeDb::insertImage($r);
        $img_in . "image was added";
    }

    $_SESSION[$recipe_id] = $recipe_id;
    header("Location: http://localhost/chowtime/pages/recipes.php");
} //END UPDATE




 ?>

 <!--     if(checkForEmptySteps() == null || $title == null || $desc == null || $prepTime == null || $cookTime == null || $dishDiff == null || $ingredDiff == null || $overallDiff == null || $spiceLvl == null || $date == null || $time == null){
        $errors['update_input_error'] = "Please fill out all fields to update your recipe";
        createSession($errors);
        return false;
    } else {
        unset($_SESSION['recipe_err_mssg']);
        //UPDATE SET VALUES THEN UPDATE

    } -->