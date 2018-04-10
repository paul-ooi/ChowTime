<?php
/* =====================TESTING ZONE==================== */

 /* =======================TESTING ZONE================== */

// VALIDATE FIELDS AREN'T EMPTY ON SUBMIT
$v = new Validation();
if(isset($_POST["addRecipe"])) {
    //TO HANDLE ERRORS
    $errors = array();

    $inTitle = $v->checkAssignProperty("recipe-title");
    $inDescr = $v->checkAssignProperty("recipe-description");
    $inPrepTime = $v->checkAssignProperty("prep-time");
    $inCookTime = $v->checkAssignProperty("cook-time");
    $overallDiff = $v->checkAssignProperty("overallDiff");
    //ADD INGREDIENTS
    $ingredDiff = $v->checkAssignProperty("ingredDiff");
    $spiceLevel = $v->checkAssignProperty("spicy");
    $diffLevel = $v->checkAssignProperty("diffLvl");


        if(!checkInputFields($inTitle, $inDescr, $inPrepTime, $inCookTime, $overallDiff, $spiceLevel, $diffLevel, $errors)) {

            echo "<pre>";
            var_dump($_SESSION);
            echo "</pre>";

        }


        // if(isset($_FILES)) {
        //     if(checkFiles() && checkInputFields()) {
        //         if(allRecipeSteps() != false) {
        //             //DO INSERT INTO DATABASE
        //             echo "this is working";
        //
        //         }
        //     }
        // }


    }//END ADD RECIPE BUTTON

    function createSession($err) {
        $_SESSION['recipe_err_mssg'] = $err;
    }

    /* =======================INPUT VALIDATION================== */
    function checkInputFields($inTitle, $inDescr, $inPrepTime, $inCookTime, $spiceLevel, $diffLevel, $errors) {
        if ($inTitle == null || $inDescr == null || $inPrepTime == null || $inCookTime == null || $spiceLevel == null || $diffLevel == null || $overallDiff == null) {
            $errors['input_field_error'] = "Please fill out all fields to add a recipe!";
            createSession($errors);
            return false;
        } else {
            return true;
        }
    }
    /* =======================END INPUT VALIDATION================== */

    /* =======================FILE VALIDATION================== */
        function checkFiles($errors) {
            $file_size = $_FILES['upfile']['size']; //in bytes
            $file_type = $_FILES['upfile']['type'];
            $file_error = $_FILES['upfile']['error'];
            $file_name = $_FILES['upfile']['tmp_name'];
            //HANDLING FILE ERRORS = ERRORS['FILE_ERROR']

            if ($file_error > 0) {
                $errors['file_error'] = "There was an unknown error with your file upload";
                createSession($errors);
                return false;

                switch($file_error) {
                    case 1:
                    $errors['file_error'] = "File exceeded upload_max_filesize";
                    createSession($errors);
                    break;
                    case 2:
                    $errors['file_error'] = "File exceeded max_file_size";
                    createSession($errors);
                    break;
                    case 3:
                    $errors['file_error'] = "File only partially uploaded";
                    createSession($errors);
                    break;
                    case 4:
                    $errors['file_error'] = "No file uploaded";
                    createSession($errors);
                    break;
                }
            exit;
            }

            $max_file_size = 20000;
            if($file_size > $max_file_size) {
                $errors['file_error'] = "File size too big";
                createSession($errors);
                return false;
            }

            $target_path = "/ChowTime/assets/imgs/";
            $num = recipeDB::getImageCount();
            $file_name = "image" . $num[0] . "jpg";

            $target_path = $target_path . $file_name;
            if(move_uploaded_file($file_temp, $target_path)) {
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
    function allSteps($e){
        return $e["step"];
    }

    function allRecipeSteps() {
        if(isset($_POST['item'])) {
            $stepsArr = array_map("allSteps", $_POST['item']);
            foreach($stepsArr as $step) {
                if ($step != "") {
                    $all_recipe_steps = $step . ';';
                }
            }
        } else {
            return false;
        }
    }
    /* =======================END GET STEPS================== */
 ?>
