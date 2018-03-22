<?php

require_once '../models/db.php';
require_once '../models/ingredient.php';

$pageTitle = "Ingredients";
require_once '_header.php';

//Debug Code
/*
*/
$ing = new Ingredient();
$rList = $ing->getRecipeTitles(Database::getDb());
$fList = $ing->getFoodNames(Database::getDb());
// echo '<pre>';
// var_dump($rList);
// echo '</pre>';

if (!isset($_POST['submitBtn'])) {
    //Set Error Labels to Empty
    $errorRecipeId = "";
    $errorFName = "";
    $errorQty = "";
    $errorMeasure = "";
    $errorPrep = "";
    $errorEmail = "";
}

?>
<main>
    <h1>Ingredients</h1>
    <h2>Fill in the form to add/update an ingredient. All fields required.</h2>

    <form action="_ingredients.php" method="post" id="ingred_form" name="ingredForm">
        <div>
            <label class="ingred_form_label ingred_form_label_small" for="recipe_id">For Recipe </label>
            <select type="text" name="recipe_id" id="recipe_id">
                <option value="">--Select Recipe--</option>
                <?php
                    foreach ($rList as $key => $recipe) {
                        echo '<option value="' . $recipe->id . '">' . $recipe->title . '</option>';
                    }
                ?>
            </select>
            <label class="error" for="name" name="recipe_id"><?php echo htmlspecialchars($errorRecipeId); ?></label>
        </div>
        <div>
            <label class="ingred_form_label ingred_form_label_small" for="name">Food ID#</label>
            <select type="text" name="name" id="name">
                <option value="">--Select Food Item--</option>
                <?php
                    foreach ($fList as $key => $food_item) {
                        echo '<option value="' . $food_item->id . '">' . $food_item->food_name . '</option>';
                    }
                ?>
            </select>
            <label class="error" for="name" name="errName"><?php echo htmlspecialchars($errorFName); ?></label>
        </div>
        <div>
            <label class="ingred_form_label ingred_form_label_small"  for="qty">Quantity</label>
            <input type="text" name="qty" id="qty" />
            <label class="error" for="qty" name="errQty"><?php echo htmlspecialchars($errorQty); ?></label>
        </div>
        <div>
            <label class="ingred_form_label ingred_form_label_small"  for="measure">Unit of Measurement <small>(if applicable)</small> </label>
            <input type="text" name="measure" id="measure" />
            <label class="error" for="measure" name="errMeasure"><?php echo htmlspecialchars($errorMeasure); ?></label>
        </div>
        <div>
            <label class="ingred_form_label ingred_form_label_small"  for="prep">Preparation <small>(if applicable)</small> </label>
            <input type="text" name="prep" id="prep" />
            <label class="error" for="prep" name="errPrep"><?php echo htmlspecialchars($errorPrep); ?></label>
        </div>
        <div>
            <label class="ingred_form_label ingred_form_label_small" for="required">Is this Ingredient required to make this Recipe?</label>
            <label class="error" for="optional" name="errOption"><?php echo htmlspecialchars($errorEmail); ?></label>
            <div>
                <label class="ingred_form_label ingred_form_label_small" for="yes">Yes</label>
                <input type="radio" name="required" value="yes" id="ingred_form_radio_yes"/>
            </div>
            <div>
                <label class="ingred_form_label ingred_form_label_small" for="no">No</label>
                <input type="radio" name="required" value="no" id="ingred_form_radio_no"/>
            </div>
        </div>
        <div>
            <button id="ingredForm_add" type="submit" name="submitBtn">Add Ingredient</button>
        </div>
    </form>
</main>
<?php
require_once '_footer.php';

?>
</body>
</html>
