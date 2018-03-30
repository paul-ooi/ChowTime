<?php

include_once '../../validators/validation.php';
include_once '../../models/recipesMade.php';
include_once '../../models/db.php';

$validate = new Validation();
$recipesMade = new RecipesMade();
$message;

if(isset($_POST['updateRM'])) {
    $id = $_POST['upId'];

    $recipe_sel = $recipesMade->getRecipeMadeById(Database::getDb(), $id);
}


if(isset($_POST['updRecipe'])) {
    $up_rid = $validate->checkAssignProperty('rid');
    $up_uid = $validate->checkAssignProperty('uid');
    $up_pDate = $validate->checkAssignProperty('pDate');
    $in_id = $_POST['id'];


    if($validate->number($up_rid) && $validate->number($up_uid)){
        if(!empty($up_pDate)) {
            $count = $recipesMade->updateRecipeMade(Database::getDb(), $in_id, $up_rid, $up_uid, $up_pDate);
            if($count) {
                $message = "$count entry updated.";
            } else {
                echo $count;
            }
        } else {
            $message = "Plese enter a date";
        }
    } else {
        $message = "Please enter a valid number";
    }
}

?>

<h1>Update Record of When User Made A Recipe</h1>
<form method="post" action="_updateRecipesMade.php">
    <div class="field">
        <label>Id:</label>
        <label><?php if(isset($recipe_sel)) {
            echo $recipe_sel->id;
        } ?></label>
        <input type="hidden" id="id" name="id" value="<?= $id ?>"/>
    </div>

    <div class="field">
        <label>Recipe Id:</label>
        <input type="number" id="rid" name="rid" value="<?php if(isset($recipe_sel)) {
            echo $recipe_sel->recipe_id;
        } ?>" />
    </div>

    <div class="field">
        <label>User Id:</label>
        <input type="number" id="uid" name="uid" value="<?php if(isset($recipe_sel)) {
            echo $recipe_sel->user_id;
        } ?>" />
    </div>

    <div class="field">
        <label>Published Date:</label>
        <input type="date" id="pDate" name="pDate" value=""/>
    </div>
    <input type="submit" id="updRecipe" name="updRecipe" value="Update the Recipe Made" />
    <div>
        <label><?php if(isset($message)){
            echo $message;
        } ?>
    </div>
</form>
<a href="_allRecipesMade.php">All Recipes Made</a>
