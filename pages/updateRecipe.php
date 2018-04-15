<?php
session_start();
$_SESSION['user_id'] = 1;
/*======================*/

$pageTitle = "Recipes";
require_once 'partial/_header.php';
?>
<script src="../assets/js/makeRecipe.js"></script>
<script src="../assets/js/recipe.js"></script>
<link rel="stylesheet" href="../assets/css/recipe.css" />
<link rel="stylesheet" type="text/css" href="../assets/css/makeRecipe.css" />
</head>

<?php
require_once 'partial/_mainnav.php';
require_once '../models/recipeDB.php';
require_once '../models/db.php';
require_once '../models/recipes.php';
require_once '../controllers/makeRecipe/updateRecipe.php';
require_once '../models/validation.php';
/*********************TESTING***********************/

/************************TESTING********************/ 

if(isset($_SESSION['user_id']) && (isset($_SESSION["recipe_owner"])) && (isset($recipe_id))){
    $user_id = $_SESSION['user_id'];
} else {
    header("Location: http://localhost/chowtime/pages/controllers/login.php");
}
?>

<header class="container ddwrapper">
    <?php require_once 'partial/_mainnav.php' ?>
</header>
<main>
    <div class="wrapper">
        <form method="post" enctype="multipart/form-data" action="../controllers/makeRecipe/updateRecipe.php">
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
        <!-- DISPLAY ALL PHOTOS -->
        <!-- UPLOAD PHOTOS OPTION -->
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
            <input type="submit" id="update" name="update" value="Save" class="btn btn-info"/>
        </form>
    </div>
</main>
