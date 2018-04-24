<?php
    session_start();
    require_once '../../models/recipesMade.php';
    require_once '../../models/db.php';
    $db = Database::getDb();

    if (!isset($_POST['madeIt']) || $_SESSION['user_id'] == 0) {
        header("Location: ../../index.php");
    } 
    else if (isset($_POST['madeIt']) && isset($_SESSION['user_id'])) {
        // CHECK IF USER IS A VALID USER BEFORE PASSING TO FUNCTION (USE/INCLUDE BRAD'S FUNCTION)
        $rm = new RecipesMade(NULL, $_POST['recipe_id'], $_SESSION['user_id'], NULL);
        $success = $rm->addRecipeMadeByUser($db,$rm);
    }
    else {
        header("Location: ../../index.php");
    }
    //REDIRECT ACCORDINGLY UPON DB ACTION
    if($success) {
        $wc =  "Location: ../../pages/whatsCooking.php";
        echo $wc;
        header($wc);
    } else {
        header("Location: ../../index.php");
    }

?>