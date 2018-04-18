<?php
//Use the Ingredient Model and DB model to populate the Food Options and Required OPTION
require_once '../models/ingredient.php';
require_once '../models/ingredientDB.php';
$db = Database::getDb();
$ing = new Ingredient();
$fList = IngredientDB::getFoodNames($db);//get list of food items
$mList = IngredientDB::getUnitMeasurements($db);//get list of measurements

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
                            // echo '<pre>';
                            // var_dump($mList);
                            // echo '</pre>';
?>
 <fieldset class="form-group form-inline" name="ingreds">
     <div class="form-row">
         <legend class="col-form-label col-sm-3 col-md-2"><span class="text-danger">*</span>Ingredients</legend>
     <ul id="ingredientsList" class="col-md-10">
         <li class="ingred-item row mb-3">
                 <div class="form-group col-md-2 ingred_form_item">
                     <label class="ingred_form_label ingred_form_label_small" for="food_id"><span class="text-danger required">*</span>Food Item</label>
                     <select class="form-control" name="food_id[]" id="food_id">
                         <option value="">--Select Food Item--</option>
                         <?php echo $ddFoodOptions ?>

                     </select>
                     <label class="error" for="food_id" name="errName"><?php //echo htmlspecialchars($errorFoodId); ?></label>
                 </div>
                 <div class="form-group col-md-2 ingred_form_item">
                     <label class="ingred_form_label ingred_form_label_small"  for="qty"><span class="text-danger required">*</span>Quantity</label>
                     <input class="form-control"  type="number" name="qty[]" id="qty" value="<?php //echo $ing->getQuantity() ?>" />
                     <label class="error" for="qty" name="errQty"><?php //echo htmlspecialchars($errorQty); ?></label>
                 </div>
                 <div class="form-group col-md-2 mx-1 ingred_form_item">
                     <label class="ingred_form_label ingred_form_label_small"  for="measure">Unit of Measurement
                         <!-- <small>(if applicable)</small> -->
                     </label>
                    <select class="form-control" name="measure[]" id="measure">
                         <option value="">--If applicable--</option>
                         <?php foreach ($mList as $key => $m) { ?>
                             <option value="<?php echo $m->id ?>"><?php echo $m->measurement ?></option>
                         <?php } ?>
                     </select>

                     <!-- <input class="form-control" type="text" name="measure" id="measure" value="<?php //echo $ing->getUnit(); ?>"/> -->
                     <label class="error" for="measure" name="errMeasure"><?php //echo htmlspecialchars($errorMeasure); ?></label>
                 </div>
                 <div class="form-group col-md-3 ingred_form_item">
                     <label class="ingred_form_label ingred_form_label_small"  for="prep">Preparation <small>(if applicable)</small> </label>
                     <input class="form-control" type="text" name="prep[]" id="prep" value="<?php //echo $ing->getPreparation(); ?>" placeholder="chopped, quartered, seasoned"/>
                     <label class="error" for="prep" name="errPrep"><?php //echo htmlspecialchars($errorPrep); ?></label>
                 </div>
                 <div class="form-group align-content-end col-2 ingred_form_item">
                     <label class="ingred_form_label ingred_form_label_small" for="required"><span class="text-danger required">*</span>Required Ingredient</label>
                     <label class="error" for="optional" name="errOption"><?php //echo htmlspecialchars($errorRequired); ?></label>
                     <input class="form-check-input form-control" type="checkbox" name="required[]" value="true" checked/>
                 </div>
                 <!-- <div class="form-group align-content-end col-2 ingred_form_item">
                     <label class="ingred_form_label ingred_form_label_small sr-only" for="required">Is this Ingredient required to make this Recipe?<span class="required"> * </span></label>
                     <label class="error" for="optional" name="errOption"><?php //echo htmlspecialchars($errorRequired); ?></label>
                     <div class="ingred_form_opt form-check form-check-inline">
                         <input class="form-check-input form-control" type="radio" name="required" value="yes" id="ingred_form_radio_yes" <?php //echo $selectedRadioYes ?> checked/>
                         <label class="form-check-label ingred_form_label ingred_form_label_small" for="ingred_form_radio_yes">Required</label>
                     </div>
                     <div class="ingred_form_opt form-check form-check-inline">
                         <input class="form-check-input form-control" type="radio" name="required" value="no" id="ingred_form_radio_no" <?php //echo $selectedRadioNo ?>/>
                         <label class="form-check-label ingred_form_label ingred_form_label_small" for="ingred_form_radio_no">Optional (or garnish)</label>
                     </div>
                 </div> -->
         </li>
         
     </ul>
     <button type='button' class="btn btn-sm" id="addNewBtn">add New Ingredient</button>
     <!-- <div>
         <button id="ingredForm_add" type="submit" name="addIngredBtn" for="ingredForm">Add Ingredient</button>
     </div> -->
 <?php //echo $formMsg?>
</div>
</fieldset>
<script src="../assets/js/ingredients.js"></script>
