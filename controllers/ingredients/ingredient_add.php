<?php
//Use the Ingredient Model and DB model to populate the Food Options and Required OPTION
require_once '../models/ingredient.php';
require_once '../models/ingredientDB.php';
$db = Database::getDb();
$ing = new Ingredient();
$fList = IngredientDB::getFoodNames($db);
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
 <fieldset class="form-group form-inline">
     <div class="row">
         <legend class="col-form-label col-sm-2"><span class="text-danger">*</span>Ingredients</legend>
         <div class="ingred-item row">
             <div class="form-group col-md-2 ingred_form_item">
                 <label class="ingred_form_label ingred_form_label_small" for="food_id"><span class="text-danger required">*</span>Food Item</label>
                 <select class="form-control" type="text" name="food_id" id="food_id">
                     <option value="">--Select Food Item--</option>
                     <?php //echo $ddFoodOptions ?>

                 </select>
                 <label class="error" for="food_id" name="errName"><?php //echo htmlspecialchars($errorFoodId); ?></label>
             </div>
             <div class="form-group col-md-2 ingred_form_item text-left">
                 <label class="ingred_form_label ingred_form_label_small col-8"  for="qty"><span class="text-danger required">*</span>Quantity</label>
                 <input class="form-control"  type="text" name="qty" id="qty" value="<?php //echo $ing->getQuantity() ?>" />
                 <label class="error" for="qty" name="errQty"><?php //echo htmlspecialchars($errorQty); ?></label>
             </div>
             <div class="form-group col-md-2 ingred_form_item  text-left">
                 <label class="ingred_form_label ingred_form_label_small"  for="measure">Unit of Measurement <small>(if applicable)</small> </label>
                 <input class="form-control" type="text" name="measure" id="measure" value="<?php //echo $ing->getUnit(); ?>"/>
                 <label class="error" for="measure" name="errMeasure"><?php //echo htmlspecialchars($errorMeasure); ?></label>
             </div>
             <div class="form-group col-md-2 ingred_form_item">
                 <label class="ingred_form_label ingred_form_label_small col-12 text-left"  for="prep">Preparation <small>(if applicable)</small> </label>
                 <input class="form-control" type="text" name="prep" id="prep" value="<?php //echo $ing->getPreparation(); ?>"/>
                 <label class="error" for="prep" name="errPrep"><?php //echo htmlspecialchars($errorPrep); ?></label>
             </div>
             <div class="form-group col-md-4 ingred_form_item">
                 <label class="ingred_form_label ingred_form_label_small sr-only" for="required">Is this Ingredient required to make this Recipe?<span class="required"> * </span></label>
                 <label class="error" for="optional" name="errOption"><?php //echo htmlspecialchars($errorRequired); ?></label>
                 <div class="ingred_form_opt form-check form-check-inline">
                     <input class="form-check-input form-control" type="radio" name="required" value="yes" id="ingred_form_radio_yes" <?php //echo $selectedRadioYes ?>/>
                     <label class="form-check-label ingred_form_label ingred_form_label_small" for="ingred_form_radio_yes">Required</label>
                 </div>
                 <div class="ingred_form_opt form-check form-check-inline">
                     <input class="form-check-input form-control" type="radio" name="required" value="no" id="ingred_form_radio_no" <?php //echo $selectedRadioNo ?>/>
                     <label class="form-check-label ingred_form_label ingred_form_label_small" for="ingred_form_radio_no">Optional (or garnish)</label>
                 </div>
             </div>
         </div>
     </div>
     <!-- <div>
         <button id="ingredForm_add" type="submit" name="addIngredBtn" for="ingredForm">Add Ingredient</button>
     </div> -->
 <?php //echo $formMsg?>
</fieldset>
