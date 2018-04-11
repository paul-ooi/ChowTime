<?php
// $serverRoot = $_SERVER['HTTP_HOST'];
// $appRoot = '/' . 'chowtime' . '/';
// set_include_path($serverRoot . $appRoot);

echo "<pre>";
// var_dump($_SERVER);
// echo get_include_path();
// set_include_path($root. $appRoot);
// echo 'in header';
// echo get_include_path();
echo "</pre>";

require_once '../../models/db.php';
require_once '../../models/ingredient.php';
require_once '../../models/ingredientDB.php';
require_once '../../models/validation.php';

$formMsg = "";

$v = new Validation();
$ing = new Ingredient();
$db = Database::getDb();
$rList = IngredientDB::getRecipeTitles($db);
$fList = IngredientDB::getFoodNames($db);

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
        $count = IngredientDB::addIngredient($db, $ing);

        if ($count) {
            //Show updated ingredient list for recipe
        } else {
            $formMsg = "Error Adding ingredient";
        }
    }
    $formMsg = "There are errors to fix before adding Ingredient";

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
if ($ing->getOptional() == true) {
    $selectedRadioYes = "checked";
    $selectedRadioNo = "";
} else {
    $selectedRadioYes = "";
    $selectedRadioNo = "checked";
}

?>

    <p>Fill in the form to add an ingredient.<small><span class="required"> * </span>fields are required.</small></p>

    <fieldset class="form-group form-inline row">
    <!-- <form action="_addingredient.php" method="post" id="ingred_form" name="ingredForm" class="col-12 d-flex"> -->
        <div class="form-group col-lg-3 ingred_form_item">
            <label class="ingred_form_label ingred_form_label_small" for="food_id">Food Item<span class="required"> * </span></label>
            <select class="form-control" type="text" name="food_id" id="food_id">
                <option value="">--Select Food Item--</option>
                <?php echo $ddFoodOptions ?>

            </select>
            <label class="error" for="food_id" name="errName"><?php echo htmlspecialchars($errorFoodId); ?></label>
        </div>
        <div class="form-group col-lg-3 ingred_form_item">
            <label class="ingred_form_label ingred_form_label_small"  for="qty">Quantity<span class="required"> * </span></label>
            <input class="form-control"  type="text" name="qty" id="qty" value="<?php echo $ing->getQuantity() ?>" />
            <label class="error" for="qty" name="errQty"><?php echo htmlspecialchars($errorQty); ?></label>
        </div>
        <div class="form-group col-lg-3 ingred_form_item">
            <label class="ingred_form_label ingred_form_label_small"  for="measure">Unit of Measurement <small>(if applicable)</small> </label>
            <input class="form-control" type="text" name="measure" id="measure" value="<?php echo $ing->getUnit(); ?>"/>
            <label class="error" for="measure" name="errMeasure"><?php echo htmlspecialchars($errorMeasure); ?></label>
        </div>
        <div class="form-group col-lg-3 ingred_form_item">
            <label class="ingred_form_label ingred_form_label_small"  for="prep">Preparation <small>(if applicable)</small> </label>
            <input class="form-control" type="text" name="prep" id="prep" value="<?php echo $ing->getPreparation(); ?>"/>
            <label class="error" for="prep" name="errPrep"><?php echo htmlspecialchars($errorPrep); ?></label>
        </div>
        <div class="form-group col-12 ingred_form_item">
            <label class="ingred_form_label ingred_form_label_small" for="required">Is this Ingredient required to make this Recipe?<span class="required"> * </span></label>
            <label class="error" for="optional" name="errOption"><?php echo htmlspecialchars($errorRequired); ?></label>
            <div class="ingred_form_opt form-check form-check-inline">
                <input class="form-check-input form-control" type="radio" name="required" value="yes" id="ingred_form_radio_yes" <?php echo $selectedRadioYes ?>/>
                <label class="form-check-label ingred_form_label ingred_form_label_small" for="ingred_form_radio_yes">Yes</label>
            </div>
            <div class="ingred_form_opt form-check form-check-inline">
                <input class="form-check-input form-control" type="radio" name="required" value="no" id="ingred_form_radio_no" <?php echo $selectedRadioNo ?>/>
                <label class="form-check-label ingred_form_label ingred_form_label_small" for="ingred_form_radio_no">No, it is optional (or used as garnish)</label>
            </div>
        </div>
        <div>
            <button id="ingredForm_add" type="submit" name="addIngredBtn" for="ingredForm">Add Ingredient</button>
        </div>
    <!-- </form> -->
    <?php $formMsg?>
</fieldset>
