<?php
session_start();
// $_SESSION['user_id'] = 8;
/*======================*/

$pageTitle = "Recipes";
require_once 'partial/_header.php';
?>
<script src="../assets/js/makeRecipe.js"></script>
<script src="../assets/js/recipe.js"></script>
<link rel="stylesheet" href="../assets/css/recipe.css" />
<link rel="stylesheet" type="text/css" href="../assets/css/makeRecipe.css" />
<link rel="stylesheet" type="text/css" href="../assets/css/ingredients.css" />
</head>

<?php
require_once 'partial/_mainnav.php';
require_once '../models/recipeDB.php';
require_once '../models/db.php';
require_once '../models/recipes.php';
require_once '../models/ingredient.php';
require_once '../models/ingredientDB.php';
require_once '../controllers/makeRecipe/updateRecipe.php';
/*********************TESTING***********************/

/************************TESTING********************/ 
if(isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $userRole = RecipeDb::getUserRole($user_id);
} else {
    header("Location: http://localhost/chowtime/pages/login.php");
}
?>

<header class="container ddwrapper">
    <?php require_once 'partial/_mainnav.php' ?>
</header>
<main>
    <div class="wrapper">
        <small class="instructions form-text text-danger">
            <?php if(isset($_SESSION['recipe_err_mssg']['input_field_error'])) {
                echo $_SESSION['recipe_err_mssg']['input_field_error'];
            } ?>
        </small>
        <form method="post" enctype="multipart/form-data" action="">
        <input type="hidden" name="recipe_id" value="<?php if(isset($recipe_id)) {echo $recipe_id;} ?>" />
        <input type="hidden" name="user_role" value="<?php if(isset($userRole)) {echo $userRole;} ?>" />
        <!-- RECIPE TITLE -->
            <div class="form-group">
                <div class="form-row">
                    <label for="recipe_title" class="col-sm-2 col-form-label">
                    <span class="text-danger">*</span>Title</span></label>
                    <div class="col-sm-8">
                        <input type="text" name="inTitle" value="<?php if(isset($title)) {echo $title;} ?>" class="form-control" id="recipe_title" />
                        <small class="instructions form-text text-muted">Give your recipe a title name!</small>
                    </div>                    
                </div>
            </div>
        <!-- RECIPE DESCRIPTION -->
            <div class="form-group">
                <div class="form-row">
                    <label for="recipe-description" class="col-sm-2 col-form-label"><span class="text-danger">*</span>Description</label>
                    <div class=" col-sm-8">
                        <textarea id="recipe-description" class="form-control" rows="3" placeholder="Made with fresh thyme and basil..." name="inDesc"><?php if(isset($description)) {echo $description;}?></textarea>
                        <small class="instructions form-text text-muted">Describe your recipe</small>
                    </div>
                </div>
            </div>
        <!-- DELETE A PHOTO OPTION -->
            <div class="form-group">
                <div class="form-row">
                    <label class="col-sm-2 col-form-label">Delete Images
                        <small class="instructions form-text text-muted">Select an image to delete (please note that you must have at least one photo)</small>
                    </label>
                    <div class="col-sm-8">
                        <?php if(isset($recipeImgs)) : ?>
                        <?php foreach($recipeImgs as $imgs) : ?>
                                <?php foreach($imgs as $key => $value) : ?>
                                    <div class="col-sm-4">
                                        <img src="<?= $value ?>" alt="<?= $title ?>" class="thumbnail currImgDel" />
                                        <div class="imgSrc deleteButton">x</div>
                                    </div>
                                <?php endforeach ?>
                            <?php endforeach ?>
                        <?php endif ?>
                        <small class="instructions form-text text-muted" id="delImgErr"></small>
                    </div>
                </div>
            </div>
        <!-- UPLOAD PHOTOS OPTION -->
            <div class="form-group">
                <div class="form-row">
                    <label for="photos" class="col-sm-2 col-form-label">Upload Photos</label>
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
                        <input type="number" class="form-control" id="prep-time" name="inPrep" placeholder="60" value="<?php if(isset($preptime)) {echo $preptime;}?>"/>
                        <small class="instructions form-text text-muted">How long will it take to prep? (minutes)</small>
                    </div>
                </div>
            </div>
        <!-- COOK TIME -->
           <div class="form-group">
                <div class="form-row">
                    <label for="cook-time" class="col-sm-2 col-form-label"><span class="text-danger">*</span>Cook Time</label>
                    <div class="col-sm-3">
                        <input type="number" class="form-control" id="cook-time" name="inCook" placeholder="15" value="<?php if(isset($cooktime)) {echo $cooktime;} ?>"/>
                        <small class="instructions form-text text-muted">How long will it take to cook? (minutes)</small>
                    </div>
                </div>
            </div>
        <!-- DISH LEVEL -->
            <fieldset class="form-group">
                <div class="form-row">
                    <div class="col-sm-2">
                        <legend class="col-form-label"><span class="text-danger">*</span>Dishes Level</legend>
                    </div>
                    <div class="col-sm-8">
                        <?php foreach($dish['dish_lvl'] as $key => $value) : ?>
                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" name="inDish" id="<?= $key ?>" value="<?= $value ?>" 
                            <?php 
                            if(isset($dishlvl)) {
                                if($dishlvl == $value) {
                                    echo 'checked';
                                }
                            }
                            ?>/>
                            <label for="<?= $key ?>" class="form-check-label"><?= $value ?></label>
                        </div>
                        <?php endforeach ?>
                        <small class="form-text text-muted">From zero to a full washing machine.</small>
                    </div>
                </div>
            </fieldset>
        <!-- INGREDIENT LEVEL -->
            <fieldset class="form-group">
                <div class="form-row">
                    <div class="col-sm-2">
                        <legend class="col-form-label"><span class="text-danger">*</span>Ingredient Difficulty</legend>
                    </div>
                    <div class="col-sm-8">
                        <?php foreach($ingred['ingred_diff'] as $key => $value) : ?>
                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" name="inIngred" id="<?= $key ?>" value="<?= $value ?>" 
                            <?php if(isset($ingredlvl)) {
                                    if($ingredlvl == $value) {
                                        echo 'checked';
                                    }
                            }?>/>
                            <label for="<?= $key ?>" class="form-check-label"><?= $value ?></label>
                        </div>
                        <?php endforeach ?>
                        <small class="form-text text-muted">From household essentials to i've never heard of it.</small>
                    </div>
                </div>
            </fieldset>
        <!-- DIFFICULTY LEVEL -->
            <fieldset class="form-group">
                <div class="form-row">
                    <div class="col-sm-2">
                        <legend class="col-form-label"><span class="text-danger">*</span>Overall Difficulty Level</legend>
                    </div>
                    <div class="col-sm-8">
                        <?php foreach($diff['diff_level'] as $key => $value) : ?>
                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" name="inOverallDiff" id="<?= $key ?>" value="<?= $value ?>" 
                            <?php if(isset($difflvl)) {
                                    if($difflvl == $value) {
                                        echo 'checked';
                                    }
                            }?>/>
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
                            <?php if(isset($spicelvl)) {
                                    if($spicelvl == $key) {
                                        echo 'checked';                                    
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
        <?php //include the Update Ingredient section  (Paul's Modified Lab 6)
     include '../controllers/ingredients/ingredient_update.php';?>
    
        <!-- STEPS -->
            <fieldset class="form-group">
                <div class="form-row">
                    <legend class="col-form-label col-sm-2"><span class="text-danger">*</span>Steps</legend>
                    <div class="col-sm-8">
                        <ol class="list-of-instructions">
                            <?php if(isset($steps)) :
                                $step = explode(";", $steps);
                                foreach($step as $key => $value) :
                            ?>
                            <li><input type="text" class="form-control steps" name="item[<?= $key ?>][step]" value="<?= $value ?>"/></li>
                        <?php endforeach; ?>
                    <?php endif ?>
                        </ol>
                        <p id="moreRows">Add More Rows</p>
                        <!-- <input type="button" id="moreRows" name="moreRows" value="Add More Rows"/> -->
                    </div>
                </div>
            </fieldset>

        <!-- PUB DATE -->
           <div class="form-group">
                <div class="form-row">
                    <label for="pubDate" class="col-sm-2 col-form-label"><span class="text-danger">*</span>Published Date</label>
                    <div class="col-sm-3">
                        <input type="date" class="form-control" id="pubDate" name="inDate" placeholder="15" value="<?php if(isset($date)) {echo $date;} ?>"/>
                        <small class="instructions form-text text-muted">Date of publication</small>
                    </div>
                </div>
            </div>
        <!-- PUB TIME -->
           <div class="form-group">
                <div class="form-row">
                    <label for="pubTime" class="col-sm-2 col-form-label"><span class="text-danger">*</span>Published Time</label>
                    <div class="col-sm-3">
                        <input type="time" class="form-control" id="pubTime" name="inTime" placeholder="15" value="<?php if(isset($time)) {echo $time;} ?>"/>
                        <small class="instructions form-text text-muted">Time of publication</small>
                    </div>
                </div>
            </div>    
            <?php if(isset($user_id)) {

            } ?>
            <input type="submit" id="update" name="update" value="Save" class="btn btn-info"/>
        </form>
        <form enctype="multipart/form-data" method="POST" action="../controllers/makeRecipe/deleteRecipe.php">
            <?php if($userRole['admin'] == 1) : ?>
                <input type="submit" id="delete" name="delete" value="Delete Recipe" class="btn btn-info" />
                <input type="hidden" name="recipe_id" value="<?php if(isset($recipe_id)) {echo $recipe_id;} ?>" />
                <input type="hidden" name="user_role" value="<?php if(isset($userRole)) {echo $userRole[0];} ?>" />
            <?php endif ?>
        </form>
    </div>
</main>