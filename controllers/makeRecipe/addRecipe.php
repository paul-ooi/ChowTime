<?php
if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
} else {
    header("Location: http://localhost/chowtime/pages/controllers/login.php");
}
/* =====================TESTING ZONE==================== */


            // $num = RecipeDB::getImageCount();
            // $next_num = $num[0] + 1;
            // var_dump($next_num);
            // // return false;

            // $last_img_id = RecipeDb::getLastImgId();
            // $next_img_id = $last_img_id[0] + 1;
            // var_dump($next_img_id);
            // return false;
 /* =======================TESTING ZONE================== */

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
     "0001" => '1',
     "0002" => '2',
     "0003" => '3',
     "0004" => '4',
     "0005" => '5'
 );

  $spicy['spicy_lvl'] = array (
     "0" => "None, Zero.",
     "1" => "Barely taste it.",
     "2" => "Ok, I feel some heat.",
     "3" => "That's Spicy.",
     "4" => "I Can't Feel My Tongue Anymore.",
     "5" => "Is my Face Melting?"
 );
 /* =======================END ARRAYS TO DISPLAY ================== */


// VALIDATE FIELDS AREN'T EMPTY ON SUBMIT
$v = new Validation();
if(isset($_POST["addRecipe"])) {
    //TO HANDLE ERRORS
    $errors = array();
    $r = new Recipes();

echo '<pre>';
var_dump($_POST);
echo '</pre>';
return false;

    $inTitle = $v->checkAssignProperty("recipe-title");
    $inDescr = $v->checkAssignProperty("recipe-description");
    $inPrepTime = $v->checkAssignProperty("prep-time");
    $inCookTime = $v->checkAssignProperty("cook-time");
    $overallDiff = $v->checkAssignProperty("overallDiff");
    $in_dishLvl = $v->checkAssignProperty("dishLevel");
    $spiceLevel = $v->checkAssignProperty("inSpice");
    //ADD INGREDIENTS
    $ingredDiff = $v->checkAssignProperty("ingredDiff");
    $img_src = "";

        //CHECK ALL INPUT FIELDS ARE VALID
        if(checkInputFields($inTitle, $inDescr, $inPrepTime, $inCookTime, $overallDiff, $spiceLevel, $in_dishLvl, $errors)) {
            //CHECK FILES ARE VALID AND STEPS ARE ENTERED
            if(recipeStepsReturn()) {
                if(checkFiles($errors, $r)) {
                    //DO INSERT IMAGE INTO DATABASE
                    $steps = allRecipeSteps();

                    $last_img_id = RecipeDb::getLastImgId();
                    $next_img_id = $last_img_id[0] + 1;

                    $r->setRecipeProps(null, $user_id, $next_img_id, $inTitle, $inDescr, $inPrepTime, $inCookTime, $in_dishLvl, $ingredDiff, $overallDiff, $spiceLevel, $steps);

                    //INSERT INTO RECIPE
                    $recipe_in = RecipeDb::addRecipe($r);
                    echo $recipe_in . " recipe was added. ";

                    //INSERT INTO RECIPE IMAGES
                    $last_recipe_id = RecipeDb::getLastRecipe();
                    $r->setRecipeId($last_recipe_id[0]);

                    $img_in = RecipeDb::insertImage($r);
                    echo $img_in . " image was added.";
                }
            }
        }
    }//END ADD RECIPE BUTTON

    function createSession($err) {
        $_SESSION['recipe_err_mssg'] = $err;
    }

    /* =======================INPUT VALIDATION================== */
    function checkInputFields($inTitle, $inDescr, $inPrepTime, $inCookTime, $spiceLevel, $overallDiff, $in_dishLvl, $errors) {
        if ($inTitle == null || $inDescr == null || $inPrepTime == null || $inCookTime == null || $spiceLevel == null || $overallDiff == null || $in_dishLvl == null) {
            $errors['input_field_error'] = "*Please fill out all fields to add a recipe!";
            createSession($errors);
            return false;
        } else {
            unset($_SESSION['recipe_err_mssg']);
            return true;
        }
    }
    /* =======================END INPUT VALIDATION================== */

    /* =======================FILE VALIDATION================== */
    //FIX FILE SIZE, AND IMAGE COUNT
        function checkFiles($errors, $recipe) {
            if(!isset($_FILES)) {
                $errors['file_error'] = "Please upload a photo of your recipe";
                createSession($errors);
                return false;
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
                    createSession($errors);
                    return false;
                }
            exit;
            }

            $max_file_size = 200000;
            if($file_size > $max_file_size) {
                $errors['file_error'] = "File size too big";
                createSession($errors);
                return false;
            }

            //RENAMING FILE, AND ADDING TO DIRECTORY
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
    /* =======================END FILE VALIDATION================== */

    /* =======================GET STEPS================== */
    //RETURNS THE ARRAY OF STEPS - EACH ITEM WILL BE RETURNED INTO STEPSARR, THEN FORMATTED INTO A STRING IN ALL_RECIPE_STEPS
    function allRecipeSteps() {
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

    function recipeStepsReturn() {
        if(isset($_POST['item'])) {
            if(empty($_POST['item'][0]['step'])) {
                $errors['input_field_error'] = "*Please fill out all fields to add a recipe!";
                createSession($errors);
                return false;
            }
        }
        unset($_SESSION['recipe_err_mssg']);
        return true;
    }
    /* =======================END GET STEPS================== */
 ?>
