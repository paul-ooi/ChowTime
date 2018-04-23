<?php
session_start();
// $_SESSION['user_id'] = 5;
if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
} else {
    header("Location: ../controllers/login.php");
}

if(isset($_SESSION['recipe_err_mssg'])) {
    $_SESSION['recipe_err_mssg'] = "";
}

$pageTitle = "Make a Recipe";
require_once 'partial/_header.php';
?>
<script src="../assets/js/makeRecipe.js"></script>
<link rel="stylesheet" type="text/css" href="../assets/css/makeRecipe.css" />
<link rel="stylesheet" type="text/css" href="../assets/css/ingredients.css" />
</head>
<?php
require_once 'partial/_mainnav.php';
require_once '../models/validation.php';
require_once '../models/db.php';
require_once '../models/recipes.php';
require_once '../models/recipeDB.php';
require_once '../models/recipeImgs.php';
require_once '../models/recipeImgsDB.php';
require_once '../models/ingredient.php';
require_once '../models/ingredientDB.php';
require_once '../controllers/makeRecipe/addRecipe.php'; //This checks and adds recipe to DB

/* =====================TESTING ZONE==================== */


 /* =======================TESTING ZONE================== */
 ?>
<main>
    <div class="wrapper">
        <form method="post" enctype="multipart/form-data" action="makeRecipe.php" name="newRecipe" novalidate class="needs-validation">
            <input type="hidden" id="user_id" value="<?= $user_id ?>" />
            <small class="instructions form-text text-danger">
                <?php if(isset($_SESSION['recipe_err_mssg']['input_field_error'])) {
                    echo $_SESSION['recipe_err_mssg']['input_field_error'];
                }?>
            </small>
            <div class="form-group">
                <div class="form-row">
                    <label for="recipe-title" class="col-sm-2 col-form-label"><span class="text-danger">*</span>Title</label>
                    <div class="col-sm-8">
                        <input type="text" id="recipe-title" class="form-control" placeholder="Spaghetti and Meatballs" name="recipe-title" value="<?php if(isset($inTitle)) {echo $inTitle;} ?>"/>
                        <small class="instructions form-text text-muted">Give your recipe a title name!</small>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="form-row">
                    <label for="recipe-description" class="col-sm-2 col-form-label"><span class="text-danger">*</span>Description</label>
                    <div class=" col-sm-8">
                        <textarea id="recipe-description" class="form-control" rows="3" placeholder="Made with fresh thyme and basil..." name="recipe-description"><?php if(isset($inDescr)) {echo $inDescr;}?></textarea>
                        <small class="instructions form-text text-muted">Describe your recipe</small>
                    </div>
                </div>
            </div>
<!-- PHOTO UPLOAD - OPTION TO ADD MORE PHOTOS -->
            <div class="form-group">
                <div class="form-row">
                    <label for="photos" class="col-sm-2 col-form-label"><span class="text-danger">*</span>Upload Photos</label>
                    <div class="col-sm-8">
                        <input type="hidden" value="1000000" name="MAX_FILE_SIZE" />
                        <input type="file" name="upfile" id="photos" />
                        <small class="instructions form-text text-danger"><?php if(isset($_SESSION['recipe_err_mssg']['file_error'])) {echo $_SESSION['recipe_err_mssg']['file_error'];} ?></small>
                    </div>
                </div>
            </div>
    <!-- PREP TIME -->
            <div class="form-group">
                <div class="form-row">
                    <label for="prep-time" class="col-sm-2 col-form-label"><span class="text-danger">*</span>Prep Time</label>
                    <div class="col-sm-3">
                        <input type="number" class="form-control" id="prep-time" name="prep-time" placeholder="60" value="<?php if(isset($inPrepTime)) {echo $inPrepTime;}?>"/>
                        <small class="instructions form-text text-muted">How long will it take to prep? (minutes)</small>
                    </div>
                </div>
            </div>
    <!-- COOK/DIFF LEVELS -->
            <div class="form-group">
                <div class="form-row">
                    <label for="cook-time" class="col-sm-2 col-form-label"><span class="text-danger">*</span>Cook Time</label>
                    <div class="col-sm-3">
                        <input type="number" class="form-control" id="cook-time" name="cook-time" placeholder="15" value="<?php if(isset($inCookTime)) {echo $inCookTime;} ?>"/>
                        <small class="instructions form-text text-muted">How long will it take to cook? (minutes)</small>
                    </div>
                </div>
            </div>
            <!-- NUM DISHES LEVEL -->
            <fieldset class="form-group">
                <div class="form-row">
                    <div class="col-sm-2">
                        <legend class="col-form-label"><span class="text-danger">*</span>Dishes Level</legend>
                    </div>
                    <div class="col-sm-8">
                        <?php foreach($dish['dish_lvl'] as $key => $value) : ?>
                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" name="dishLevel" id="<?= $key ?>" value="<?= $value ?>" <?php if(isset($in_dishLvl)) {
                                    if($in_dishLvl == $value) {
                                        echo 'checked';
                                    }
                                } ?>/>
                            <label for="<?= $key ?>" class="form-check-label"><?= $value ?></label>
                        </div>
                        <?php endforeach ?>
                        <small class="form-text text-muted">From zero to a full washing machine.</small>

                    </div>
                </div>
            </fieldset>
            <!-- DIFF LEVEL -->
            <fieldset class="form-group">
                <div class="form-row">
                    <div class="col-sm-2">
                        <legend class="col-form-label"><span class="text-danger">*</span>Overall Difficulty Level</legend>
                    </div>
                    <div class="col-sm-8">
                        <?php foreach($diff['diff_level'] as $key => $value) : ?>
                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" name="overallDiff" id="<?= $key ?>" value="<?= $value ?>" <?php if(isset($overallDiff)) {
                                    if($overallDiff == $value) {
                                        echo 'checked';
                                    }
                                } ?>/>
                            <label for="<?= $key ?>" class="form-check-label"><?= $value ?></label>
                        </div>
                        <?php endforeach ?>
                        <small class="form-text text-muted">From household essentials to i've never heard of it.</small>

                    </div>
                </div>
            </fieldset>
    <!-- SPICY LEVEL -->
            <fieldset class="form-group">
                <div class="form-row">
                    <legend class="col-form-label col-sm-2"><span class="text-danger">*</span>Spicy Level</legend>
                    <div class="col-sm-10">
                    <?php foreach($spicy['spicy_lvl'] as $key => $value) : ?>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="inSpice" id="<?= $key ?>" value="<?= $key ?>" 
                            <?php 
                            if(isset($spiceLevel)) {
                                if($spiceLevel == $key) {
                                    echo 'checked';
                                }
                                if($spiceLevel == "0") {
                                    $spiceLevel = "zero";
                                    echo ($spiceLevel == $key) ? 'checked' : "";
                                }
                            }                            
                             ?>/>
                            <label for="<?= $key ?>" class="form-check-label"><?= $value ?></label>
                        </div>
                    <?php endforeach ?>
                    </div>
                </div>
            </fieldset>
    <!-- INGREDIENTS -->
    <?php // //include the Add Ingredient section  (Paul's Modified Lab 6)
     include '../controllers/ingredients/ingredient_add.php';?>
           <!-- <fieldset class="form-group">
                <div class="form-row">
                    <legend class="col-form-label col-sm-3 col-md-2"><span class="text-danger">*</span>Ingredients</legend>
                    <div class="col-sm-2">
                        //THIS FORM GROUP WILL BE REPEATED AND POPULATED WITH PHP
                        <div class="form-group">
                            <input type="checkbox" name="ingred" id="ingred" class="form-check-input" value=""/>
                            <label for="ingred" class="form-check-label">Ingred</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="ingred" id="ingred" class="form-check-input" value=""/>
                            <label for="ingred" class="form-check-label">Ingred</label>
                        </div>
                        //END FOREACH FROM PHP
                    </div>
                </div>
            </fieldset> -->
            <!-- INGREDIENT RATING -->
            <fieldset class="form-group">
                <div class="form-row">
                    <div class="col-sm-2">
                        <legend class="col-form-label"><span class="text-danger">*</span>Ingredient Difficulty</legend>
                    </div>
                    <div class="col-sm-8">
                        <?php foreach($ingred['ingred_diff'] as $key => $value) : ?>
                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" name="ingredDiff" id="<?= $key ?>" value="<?= $value ?>" <?php if(isset($ingredDiff)) {
                                if($ingredDiff == $value) {
                                    echo 'checked';
                                    }
                                 } ?>/>
                            <label for="<?= $key ?>" class="form-check-label"><?= $value ?></label>
                        </div>
                        <?php endforeach ?>
                        <small class="form-text text-muted">From household essentials to i've never heard of it.</small>

                    </div>
                </div>
            </fieldset>
            <!-- STEPS TO MAKE THE RECIPE -->
            <fieldset class="form-group">
                <div class="form-row">
                    <legend class="col-form-label col-sm-2"><span class="text-danger">*</span>Steps</legend>
                    <div class="col-sm-8">
                        <ol class="list-of-instructions">
                            <!-- REPEAT PHP HERE -->
                            <?php if(!isset($_POST['item'])) : ?>
                            <li><input type="text" class="form-control steps" name="item[0][step]" value=""/></li>
                            <li><input type="text" class="form-control steps" name="item[1][step]" value=""/></li>
                            <li><input type="text" class="form-control steps" name="item[2][step]" value=""/></li>
                            <li><input type="text" class="form-control steps" name="item[3][step]" value=""/></li>
                        <?php endif ?>
                            <!-- END PHP REPEAT HERE -->

                            <?php if(isset($_POST['item'])) :
                                $allSteps = allRecipeSteps();
                                $stepsArr = explode(";", $allSteps);
                                foreach($stepsArr as $key => $value) :
                            ?>
                            <li><input type="text" class="form-control steps" name="item[<?= $key ?>][step]" value="<?= $value ?>"/></li>
                        <?php endforeach ?>
                    <?php endif ?>
                        </ol>
                        <p id="moreRows">Add More Rows</p>
                        <!-- <input type="button" id="moreRows" name="moreRows" value="Add More Rows"/> -->
                    </div>
                </div>
            </fieldset>
            <input type="submit" id="addRecipe" name="addRecipe" class="btn" value="Add"/>
            <!-- <input type="text" readonly class="form-control-plaintext" name="errMssg" value=""> -->
        </form>
    </div>
</main>
<?php
require_once 'partial/_footer.php';
?>
