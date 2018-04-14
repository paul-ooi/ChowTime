<?php
session_start();
if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
} else {
    header("Location: http://localhost/chowtime/pages/controllers/login.php");
}

require_once '../../models/recipeDB.php';
require_once '../../models/db.php';
require_once '../../models/recipes.php';
$r = new RecipeDb();

if(isset($_POST['updateRecipe'])) {
    $recipe_id = $_POST['recipe_id'];

    $allRecipes = $r->displayById($recipe_id);
    $recipeImgs = $r->allRecipeImgs($recipe_id);

    $title = $allRecipes->title;
    $description = $allRecipes->description;
    $preptime = $allRecipes->prep_time;
    $cooktime = $allRecipes->cook_time;
    $dishlvl = $allRecipes->dishes_lvl;
    $ingredlvl = $allRecipes->ingred_lvl;
    $difflvl = $allRecipes->diff_lvl;
    $spicelvl = $allRecipes->spicy_lvl;
    $pubdate = $allRecipes->pub_date;
    $steps = $allRecipes->steps;

    $step = explode(";", $steps);
    echo "<pre>";
    var_dump($step);
    echo "</pre>";
    

/* =======================ARRAYS TO DISPLAY ================== */
 // DIFF LEVEL ARRAY
 $diff['diff_level'] = array (
     "01" => '1',
     "02" => '2',
     "03" => '3',
     "04" => '4',
     "05" => '5'
 );

 //NUM DISH LEVEL
 $dish['dish_lvl'] = array (
     "001" => '1',
     "002" => '2',
     "003" => '3',
     "004" => '4',
     "005" => '5'
 );


 //INGRED DIFF
 $ingred['ingred_diff'] = array (
     "1" => '1',
     "2" => '2',
     "3" => '3',
     "4" => '4',
     "5" => '5'
 );
 /* =======================END ARRAYS TO DISPLAY ================== */
}
 ?>

<main>
    <div class="wrapper">
        <form method="post" enctype="multipart/form-data" action="updateRecipe.php">
        <!-- RECIPE TITLE -->
            <div class="form-group">
                <div class="form-row">
                    <label for="recipe_title" class="col-sm-2 col-form-label">
                    <span class="text-danger">*</span>Title</span>
                    <input type="text" value="<?php if(isset($title)) {echo $title;} ?>" class="form-control" id="recipe_title" />
                    <small class="instructions form-text text-muted">Give your recipe a title name!</small>
                </div>
            </div>
        <!-- RECIPE DESCRIPTION -->
            <div class="form-group">
                <div class="form-row">
                    <label for="recipe-description" class="col-sm-2 col-form-label"><span class="text-danger">*</span>Description</label>
                    <div class=" col-sm-8">
                        <textarea id="recipe-description" class="form-control" rows="3" placeholder="Made with fresh thyme and basil..." name="recipe-description"><?php if(isset($description)) {echo $description;}?></textarea>
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
                        <input type="number" class="form-control" id="prep-time" name="prep-time" placeholder="60" value="<?php if(isset($preptime)) {echo $preptime;}?>"/>
                        <small class="instructions form-text text-muted">How long will it take to prep? (minutes)</small>
                    </div>
                </div>
            </div>        
        <!-- COOK TIME -->
           <div class="form-group">
                <div class="form-row">
                    <label for="cook-time" class="col-sm-2 col-form-label"><span class="text-danger">*</span>Cook Time</label>
                    <div class="col-sm-3">
                        <input type="number" class="form-control" id="cook-time" name="cook-time" placeholder="15" value="<?php if(isset($cooktime)) {echo $cooktime;} ?>"/>
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
                            <input type="radio" class="form-check-input" name="dishLevel" id="<?= $key ?>" value="<?= $value ?>" <?php if(isset($dishlvl)) {echo 'checked';} ?>/>
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
                            <input type="radio" class="form-check-input" name="ingredDiff" id="<?= $key ?>" value="<?= $value ?>" <?php if(isset($ingredlvl)) {echo 'checked';} ?>/>
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
                            <input type="radio" class="form-check-input" name="overallDiff" id="<?= $key ?>" value="<?= $value ?>" <?php if(isset($difflvl)) {echo 'checked';} ?>/>
                            <label for="<?= $key ?>" class="form-check-label"><?= $value ?></label>
                        </div>
                        <?php endforeach ?>
                        <small class="form-text text-muted">From household essentials to i've never heard of it.</small>

                    </div>
                </div>
            </fieldset>        
        <!-- SPICY LEVEL -->
        <!-- PUB DATE -->
        <!-- STEPS -->
        </form>
    </div>
</main>