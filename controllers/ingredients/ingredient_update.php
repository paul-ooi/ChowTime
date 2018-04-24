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
} else if(isset($_POST['updateRecipe'])) {
    $recipe_id = $_POST['recipe_id'];
    $array = IngredientDB::getRecipeIngredients($db, $recipe_id);
    if (count($array) == 0) { 
        $arrayLength = 1 ;
     } else {
         $arrayLength = count($array);//Get the total number of entered ingredients
     }
} else {
    $arrayLength = 1;//If none, populate once
}

?>
 <fieldset class="form-group form-inline" name="ingreds">
     <div class="form-row">
         <legend class="col-form-label col-sm-3 col-md-2"><span class="text-danger">*</span>Ingredients</legend>
     <ul id="ingredientsList" class="col-md-10">
        <?php for ($i = 0; $i < $arrayLength; $i++) : ?>
         <li class="ingred-item row ml-3 ml-md-0">
             <button type="button" class="close" aria-label="Delete Ingredient">
                <span aria-hidden="true">&times;</span>
            </button>
                 <div class="form-group col-sm-12 col-lg-3 ingred_form_item input-group-sm mb-md-3 mb-1">
                     <label class="ingred_form_label ingred_form_label_small" for="food_id"><span class="text-danger required">*</span>Food Item</label>
                     <select class="form-control" name="food_id[]" id="food_id">
                         <option value="">-Select Food Item-</option>
                         <?php 
                         if (!empty($array)) {
                         foreach ($fList as $key => $f) : ?>
                         
                             <option value="<?php echo $f->id ?>" 
                                <?php if (isset($_POST['food_id']) && $f->id == $array['food_id'][$i]) : echo "selected"; endif ?>
                                <?php if (isset($_POST['updateRecipe']) && $f->id == $array[$i]->ing_id) { echo "selected"; } else { echo ""; }  ?>
                             ><?php echo $f->food_name ?>
                             </option>
                         <?php endforeach ;} else { 
                             foreach ($fList as $key => $f) : ?>
                             <option value="<?php echo $f->id ?>"><?php echo $f->food_name ?>
                             </option> 
                             <?php endforeach ;}?>

                     </select>
                     <label class="error" for="food_id" name="errName"><?php //echo htmlspecialchars($errorFoodId); ?></label>
                 </div>
                 <div class="form-group col-sm-12 col-lg-2 ingred_form_item input-group-sm mb-md-3 mb-1">
                     <label class="ingred_form_label ingred_form_label_small"  for="qty"><span class="text-danger required">*</span>Quantity</label>
                     <input class="form-control"  type="text" name="qty[]" id="qty" value="<?php 
                     if (!empty($array)) {
                     if (isset($_POST['qty']) && $_POST['qty'][$i] != "") : echo number_format($array['quantity'][$i], 2, ".",","); endif 
                     ?><?php 
                     if (isset($_POST['updateRecipe']) && $array[$i]->quantity != "") { echo number_format($array[$i]->quantity, 2, ".",","); } else { echo ""; } }?>" placeholder="example: 3.75"/>
                     <label class="error" for="qty" name="errQty"><?php //echo htmlspecialchars($errorQty); ?></label>
                 </div>
                 <div class="form-group col-sm-12 col-lg-2 ingred_form_item input-group-sm mb-md-3 mb-1">
                     <label class="ingred_form_label ingred_form_label_small"  for="measure">Unit Measurement</label>
                    <select class="form-control" name="measure[]" id="measure">
                         <option value="">-If applicable-</option>
                         <?php if (!empty($array)) {
                             foreach ($mList as $key => $m) : ?>
                             <option value="<?php echo $m->id ?>"
                             <?php if (isset($_POST['measure']) && $m->id == $array['measurement'][$i]) : echo "selected"; endif ?>
                             <?php if (isset($_POST['updateRecipe']) && $m->id == $array[$i]->unit) : echo "selected"; endif ?>
                             ><?php echo $m->measurement ?></option>
                         <?php endforeach ;}  else { 
                             foreach ($mList as $key => $m) : ?>
                             <option value="<?php echo $m->id ?>"><?php echo $m->measurement ?>
                             </option> 
                             <?php endforeach ;}?>
                     </select>
                     <label class="error" for="measure" name="errMeasure"><?php //echo htmlspecialchars($errorMeasure); ?></label>
                 </div>
                 <div class="form-group col-sm-12 col-lg-3 ingred_form_item input-group-sm mb-md-3 mb-1">
                     <label class="ingred_form_label ingred_form_label_small"  for="prep">Preparation <small>(if applicable)</small> </label>
                     <input class="form-control" type="text" name="prep[]" id="prep" value="<?php
                     if (!empty($array)) {
                     if (isset($_POST['prep'])) : echo $array['preparation'][$i]; endif 
                     ?><?php
                     if (isset($_POST['updateRecipe'])) { echo $array[$i]->prep; } else { echo ""; } ; }
                     ?>"
                     placeholder="chopped, quartered, seasoned"/>
                     <label class="error" for="prep" name="errPrep"><?php //echo htmlspecialchars($errorPrep); ?></label>
                 </div>
                 <div class="form-group align-content-end col-sm-12 col-lg-1 ingred_form_item input-group-sm mb-md-3 mb-1">
                     <label class="ingred_form_label ingred_form_label_small" for="required"><span class="text-danger required">*</span>Required Ingredient</label>
                     <label class="error" for="optional" name="errOption"><?php //echo htmlspecialchars($errorRequired); ?></label>
                     <input class="form-check-input form-control" type="checkbox" name="required[]" value="true" 
                     <?php
                     if (!empty($array)) {
                     if ((!isset($_POST['required'])) || (isset($_POST['required']) && $array['required'][$i] == "true")) : echo "checked"; endif ?>
                     <?php if ((!isset($_POST['updateRecipe'])) || (isset($_POST['updateRecipe']) && $array[$i]->required == "1")) { echo "checked"; } else { echo ""; }?>/>
                     <input class="form-check-input form-control" type="hidden" name="required[]" value="false"
                     <?php if ((isset($_POST['required']) && ($array['required'][$i] == "false" || (isset($array['required']))))) : echo "checked"; endif ?>
                     <?php if ((isset($_POST['updateRecipe']) && ($array[$i]->required == "0"))) { echo "checked"; } else { echo ""; } ;}?>
                     />
                 </div>
         </li>
         <?php endfor ?>
     </ul>
     <button type='button' class="btn btn-sm" id="addNewBtn">add New Ingredient</button>
</div>
</fieldset>
<script src="../assets/js/ingredients.js"></script>
