<?php
//Use the Ingredient Model and DB model to populate the Food, Measurement Options
require_once '../models/ingredient.php';
require_once '../models/ingredientDB.php';
$db = Database::getDb();
$ing = new Ingredient();
$fList = IngredientDB::getFoodNames($db);//get list of food items
$mList = IngredientDB::getUnitMeasurements($db);//get list of measurements

if(isset($_POST['food_id'])) {
    $array = getAllIngredients();
    $arrayLength = count($_POST['food_id']);//Get the total number of entered ingredients
} else {
    $arrayLength = 1;//If none, populate once
}
echo "<pre>";
var_dump($array['quantity'][0]);
var_dump($array);
// print_r(debug_backtrace());
echo "</pre>";
?>
 <fieldset class="form-group form-inline" name="ingreds">
     <div class="form-row">
         <legend class="col-form-label col-sm-3 col-md-2"><span class="text-danger">*</span>Ingredients</legend>
     <ul id="ingredientsList" class="col-md-10">
        <?php for ($i = 0; $i < $arrayLength; $i++) : ?>
         <li class="ingred-item row mb-3">
                 <div class="form-group col-md-2 ingred_form_item">
                     <label class="ingred_form_label ingred_form_label_small" for="food_id"><span class="text-danger required">*</span>Food Item</label>
                     <select class="form-control" name="food_id[]" id="food_id">
                         <option value="">--Select Food Item--</option>
                         <?php foreach ($fList as $key => $f) : ?>
                             <option value="<?php echo $f->id ?>" 
                                <?php if (isset($_POST['food_id']) && $f->id == $array['food_id'][$i]) : echo "selected"; endif ?>
                             ><?php echo $f->food_name ?>
                             </option>
                         <?php endforeach ?>

                     </select>
                     <label class="error" for="food_id" name="errName"><?php //echo htmlspecialchars($errorFoodId); ?></label>
                 </div>
                 <div class="form-group col-md-2 ingred_form_item">
                     <label class="ingred_form_label ingred_form_label_small"  for="qty"><span class="text-danger required">*</span>Quantity</label>
                     <input class="form-control"  type="number" name="qty[]" id="qty" value="
                     <?php if (isset($_POST['quantity'])) : echo $array['quantity'][$i]; endif ?>" />
                     <label class="error" for="qty" name="errQty"><?php //echo htmlspecialchars($errorQty); ?></label>
                 </div>
                 <div class="form-group col-md-2 mx-1 ingred_form_item">
                     <label class="ingred_form_label ingred_form_label_small"  for="measure">Unit of Measurement</label>
                    <select class="form-control" name="measure[]" id="measure">
                         <option value="">--If applicable--</option>
                         <?php foreach ($mList as $key => $m) : ?>
                             <option value="<?php echo $m->id ?>"><?php echo $m->measurement ?></option>
                         <?php endforeach ?>
                     </select>
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
                     <input class="form-check-input form-control" type="hidden" name="required[]" value="false"/>
                 </div>
         </li>
         <?php endfor ?>
     </ul>
     <button type='button' class="btn btn-sm" id="addNewBtn">add New Ingredient</button>
</div>
</fieldset>
<script src="../assets/js/ingredients.js"></script>
