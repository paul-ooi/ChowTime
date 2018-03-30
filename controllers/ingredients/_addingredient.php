<?php

require_once '../models/db.php';
require_once '../models/ingredient.php';
require_once '../models/validation.php';

$formMsg = "";

$pageTitle = "Ingredients";
require_once '_header.php';

//Debug Code
/*
    echo '<pre>';
    var_dump($rList);
    echo '</pre>';
*/
$v = new Validation();
$ing = new Ingredient();
$db = Database::getDb();
$rList = $ing->getRecipeTitles($db);
$fList = $ing->getFoodNames($db);

//Set Error Labels to Empty
$errorRecipeId = "";
$errorFoodId = "";
$errorQty = "";
$errorMeasure = "";
$errorPrep = "";
$errorRequired = "";

//If user is adding ingredient to existing recipe, preselect the recipe
if (isset($_POST['addIngred'])) {
    $ing->setRecipeRef($_POST['add_ing_rec_id']);
}

if (isset($_POST['addIngredBtn'])) {

    // //Validate values
    $checkRecID = $v->checkNumOnly($_POST['recipe_id']);
    $checkFoodID = $v->checkNumOnly($_POST['food_id']);
    $checkQty = $v->checkNumOnly($_POST['qty']);

    if ($_POST['recipe_id'] == "") {
        $errorRecipeId = "Must Select Recipe";
    } else if (!$checkRecID) {
        $errorRecipeId = "Invalid Recipe Selection";
    }

    if ($_POST['food_id'] == "") {
        $errorFoodId = "Must Select Food item";
    }else if (!$checkFoodID) {
        $errorFoodId = "Invalid Food Selection";
    }

    if ($_POST['qty'] == "" || $_POST['qty'] == "0") {
        $errorQty = "Quantity must not be empty";
    } else if (!$v->checkNumOnly($_POST['qty'])){
        $errorQty = "Quantity can only be numbers 0-9, maximum 2 decimal places";
    }

    if ($_POST['measure'] != "") {
        if (!$checkMeasure = $v->checkTextOnly($_POST['measure'])) {
            $errorMeasure = "Unit of Measurement with words only";
        }
    }

    if ($_POST['prep'] != "") {
        if(!$checkPrep = $v->checkTextOnly($_POST['prep'])){
            $errorPrep = "Describe preparation with words only";
        }
    }

    if ($_POST['required'] == "yes" || $_POST['required'] == true) {
        $ing->setRequired(1);
    } else if ($_POST['required'] == "no"  || $_POST['required'] == false) {
        $ing->setRequired(0);
    } else {
        $errorRequired = "Must select whether this item is required or optional";
    }

    //Assign values to Object
    $ing->setRecipeRef($_POST['recipe_id']);
    $ing->setFoodId($_POST['food_id']);
    $ing->setQuantity($_POST['qty']);
    $ing->setUnit($_POST['measure']);
    $ing->setPreparation($_POST['prep']);

    //Once all validation is Approved, proceed to add to the database
    if ($checkRecID && $checkFoodID && $checkQty && $errorMeasure == "" && $errorPrep == "" && $errorQty == "") {

        //Add ingredient Object to the Database
        $count = $ing->addIngredient($db, $ing);

        // if ($count) {
        //     header("Location: _viewingredients.php");
        // } else {
        //     $formMsg = "Error Adding ingredient";
        // }
    }
    $formMsg = "There are errors to fix before adding Ingredient";

}


// Build Drop down Recipe options with the post value selected
$ddRecipeOptions = "";
foreach ($rList as $key => $recipe) {
    $ddRecipeOptions .= '<option value="' . $recipe->id . '"';
    if ($recipe->id == $ing->getRecipeRef()) {
        $ddRecipeOptions .= ' selected ';
    }
    $ddRecipeOptions .= '>' . $recipe->title . '</option>';
}

// Build Drop down Food options with the post value selected
$ddFoodOptions = "";
foreach ($fList as $key => $food_item) {
    $ddFoodOptions .= '<option value="' . $food_item->id . '"';
    if ($food_item->id == $ing->getFoodId()) {
        $ddFoodOptions .= ' selected ';
    }
    $ddFoodOptions .= '>' . $food_item->food_name . '</option>';
}



//Build Radio button Options with the post value selected
if ($ing->getRequired() == true) {
    $selectedRadioYes = "checked";
    $selectedRadioNo = "";
} else {
    $selectedRadioYes = "";
    $selectedRadioNo = "checked";
}

?>
<header>
    <h1>Ingredients Function</h1>
    <nav>
        <ul>
            <li><a href="_viewingredients.php">View</a></li>
            <li><a href="_addingredient.php">Add New Ingredient</a></li>
        </ul>
    </nav>
</header>
<main>
    <p>Fill in the form to add an ingredient.<small><span class="required"> * </span>fields are required.</small></p>

    <form action="_addingredient.php" method="post" id="ingred_form" name="ingredForm">
        <div>
            <label class="ingred_form_label ingred_form_label_small" for="recipe_id">For Recipe<span class="required"> * </span></label>
            <select type="text" name="recipe_id" id="recipe_id">
                <option value="">--Select Recipe--</option>
                <?php echo $ddRecipeOptions ?>
            </select>
            <label class="error" for="name" name="recipe_id"><?php echo htmlspecialchars($errorRecipeId); ?></label>
        </div>
        <div>
            <label class="ingred_form_label ingred_form_label_small" for="food_id">Food Item<span class="required"> * </span></label>
            <select type="text" name="food_id" id="food_id">
                <option value="">--Select Food Item--</option>
                <?php echo $ddFoodOptions ?>

            </select>
            <label class="error" for="food_id" name="errName"><?php echo htmlspecialchars($errorFoodId); ?></label>
        </div>
        <div>
            <label class="ingred_form_label ingred_form_label_small"  for="qty">Quantity<span class="required"> * </span></label>
            <input type="text" name="qty" id="qty" value="<?php echo $ing->getQuantity() ?>" />
            <label class="error" for="qty" name="errQty"><?php echo htmlspecialchars($errorQty); ?></label>
        </div>
        <div>
            <label class="ingred_form_label ingred_form_label_small"  for="measure">Unit of Measurement <small>(if applicable)</small> </label>
            <input type="text" name="measure" id="measure" value="<?php echo $ing->getUnit(); ?>"/>
            <label class="error" for="measure" name="errMeasure"><?php echo htmlspecialchars($errorMeasure); ?></label>
        </div>
        <div>
            <label class="ingred_form_label ingred_form_label_small"  for="prep">Preparation <small>(if applicable)</small> </label>
            <input type="text" name="prep" id="prep" value="<?php echo $ing->getPreparation(); ?>"/>
            <label class="error" for="prep" name="errPrep"><?php echo htmlspecialchars($errorPrep); ?></label>
        </div>
        <div>
            <label class="ingred_form_label ingred_form_label_small" for="required">Is this Ingredient required to make this Recipe?<span class="required"> * </span></label>
            <label class="error" for="optional" name="errOption"><?php echo htmlspecialchars($errorRequired); ?></label>
            <div class="ingred_form_opt">
                <input type="radio" name="required" value="yes" id="ingred_form_radio_yes" <?php echo $selectedRadioYes ?>/>
                <label class="ingred_form_label ingred_form_label_small" for="ingred_form_radio_yes">Yes</label>
            </div>
            <div class="ingred_form_opt">
                <input type="radio" name="required" value="no" id="ingred_form_radio_no" <?php echo $selectedRadioNo ?>/>
                <label class="ingred_form_label ingred_form_label_small" for="ingred_form_radio_no">No, it is optional (or used as garnish)</label>
            </div>
        </div>
        <div>
            <button id="ingredForm_add" type="submit" name="addIngredBtn">Add Ingredient</button>
        </div>
    </form>
    <?php $formMsg?>
</main>
<footer>
    &copy; Paul Ooi - Lab 6
</footer>
</body>
</html>
