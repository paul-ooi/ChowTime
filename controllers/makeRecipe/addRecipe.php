<?php
if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
} else {
    header("Location: http://localhost/chowtime/pages/controllers/login.php");
}
/* =====================TESTING ZONE==================== */
                    

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
     "zero" => "None, Zero.",
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

    //CHECK IF SPICE LEVEL IS = TO ZERO
    if($spiceLevel == "zero") {
        $spiceLevel = "0";
    }
        //CHECK ALL INPUT FIELDS ARE VALID
        if(checkInputFields($inTitle, $inDescr, $inPrepTime, $inCookTime, $overallDiff, $spiceLevel, $in_dishLvl, $errors)) {
            //CHECK FILES ARE VALID AND STEPS ARE ENTERED
            if(recipeStepsReturn()) {
                if(checkFiles($errors, $r)) {
                    //GET ALL THE STEPS
                    $steps = allRecipeSteps();

                    //LEAVE THE MAIN IMG ID AS NULL
                    $r->setRecipeProps(null, $user_id, null, $inTitle, $inDescr, $inPrepTime, $inCookTime, $in_dishLvl, $ingredDiff, $overallDiff, $spiceLevel, $steps);

                    //INSERT INTO RECIPE
                    $recipe_in = RecipeDb::addRecipe($r);

                    //GET THE MAX ID OF RECIPE WHICH JUST INSERTED INTO RECIPE IMAGES (IMG FILE NAME WAS ALREADY SET)
                    $last_recipe_id = RecipeDb::getLastRecipe();
                    $r->setRecipeId($last_recipe_id[0]);
                    $img_in = RecipeDb::insertImage($r);

                    //UPDATE THE RECIPE MAIN IMAGE BY GETTING THE MAX ID OF RECIPE AND MAX ID OF THE IMG
                    $last_img_id = RecipeDb::getLastImgId();
                    $last_recipe_id = RecipeDb::getLastRecipe();
                    $r->setImgId($last_img_id[0]);
                    $r->setRecipeId($last_recipe_id[0]);
                    
                    $main_img_updated = RecipeDb::updateMainImage($r);

                    //INSERT INGREDIENTS INTO RECIPE_INGREDIENTS TABLE
                    $ingredients = makeIngredientObjs(getAllIngredients(), $r->getRecipeId()); //build Array of Ingredients
                    $db = Database::getDb();
                    IngredientDB::addIngredient($db,$ingredients);

                   header("Location: ../pages/recipes.php?id=" . $r->getRecipeId());
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

            //RENAMING FILE, AND ADDING TO DIRECTORY WHERE THE NUMBER IS THE NEXT MAX NUMBER OF THE RECIPE_IMGS ID
            $num = RecipeDB::getLastImgId();
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


    //GET INGEDIENTS FIELDS FROM FORM AND PLACE IN AN ASSOCIATED ARRAY
    function getAllIngredients() {
        $ingredients = [
            'food_id' => $_POST['food_id'],
            'quantity' => $_POST['qty'],
            'measurement'  => $_POST['measure'],
            'preparation'  => $_POST['prep'],
            'required'  => $_POST['required']
        ];
        return $ingredients;
    }

    // CREATE ARRAY OF INGREDIENT OBJECTS TO SEND TO DATABASE ACTION
    function makeIngredientObjs($ingredientsArray, $recipe_id) {
        
        $ingredients = [];
        for ($i = 0; $i < count($ingredientsArray['food_id']); $i++) {
            //Check for empty values and assign appropriate values to Object
            $unit = ($ingredientsArray['measurement'][$i] == "") ? null : ($ingredientsArray['measurement'][$i]) ;
            $prep = ($ingredientsArray['preparation'][$i] == "") ? null : ($ingredientsArray['preparation'][$i]) ;
            $req = ($ingredientsArray['required'][$i] == "true") ? 1 : 0;
            
            $item = new Ingredient(
                $recipe_id,
                $ingredientsArray['food_id'][$i],
                $ingredientsArray['quantity'][$i],
                $unit,
                $prep,
                $req
            );

            //Add object to array
            $ingredients[] = $item;
        }
        //Reuturn the Array of Ingredient Objects
        return $ingredients;
    }



 ?>
