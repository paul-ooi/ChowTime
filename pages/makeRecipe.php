<?php
session_start();
$_SESSION['user_id'] = 3;
if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
} else {
    header("Location: http://localhost/chowtime/pages/controllers/login.php");
}

if(isset($_SESSION['recipe_err_mssg'])) {
    $_SESSION['recipe_err_mssg'] = "";
}

$pageTitle = "Make a Recipe";
require_once 'partial/_header.php';
?>
<script src="../assets/js/makeRecipe.js"></script>
<link rel="stylesheet" type="text/css" href="../assets/css/makeRecipe.css" />
</head>
<?php
require_once 'partial/_mainnav.php';
require_once '../models/validation.php';
require_once '../models/db.php';
require_once '../models/recipes.php';
require_once '../models/recipeDB.php';
require_once '../models/recipeImgs.php';
require_once '../models/recipeImgsDB.php';
require_once '../controllers/makeRecipe/addRecipe.php';

/* =====================TESTING ZONE==================== */

 /* =======================TESTING ZONE================== */
 ?>
<main>
    <div class="wrapper">
        <form method="post" enctype="multipart/form-data" action="makeRecipe.php">
            <input type="hidden" id="user_id" value="<?= $user_id ?>" />
            <div class="form-group">
                <div class="form-row">
                    <label for="recipe-title" class="col-sm-2 col-form-label">Title</label>
                    <div class="col-sm-8">
                        <input type="text" id="recipe-title" class="form-control" placeholder="Spaghetti and Meatballs" name="recipe-title" />
                        <small class="instructions form-text text-muted">Give your recipe a title name!</small>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="form-row">
                    <label for="recipe-description" class="col-sm-2 col-form-label">Description</label>
                    <div class=" col-sm-8">
                        <textarea id="recipe-description" class="form-control" rows="3" placeholder="Made with fresh thyme and basil..." name="recipe-description"></textarea>
                        <small class="instructions form-text text-muted">Describe your recipe</small>
                    </div>
                </div>
            </div>
<!-- PHOTO UPLOAD - OPTION TO ADD MORE PHOTOS -->
            <div class="form-group">
                <div class="form-row">
                    <label for="photos" class="col-sm-2 col-form-label">Upload Photos</label>
                    <div class="col-sm-8">
                        <input type="hidden" value="100000" name="MAX_FILE_SIZE" />
                        <input type="file" name="upfile" id="photos" />
                    </div>
                    <p><?php if(isset($_SESSION['recipe_err_mssg']['file_error'])) {echo $_SESSION['recipe_err_mssg']['file_error'];} ?></p>
                </div>
            </div>
            <div class="form-group">
                <div class="form-row">
                    <label for="prep-time" class="col-sm-2 col-form-label">Prep Time</label>
                    <div class="col-sm-3">
                        <input type="time" class="form-control" id="prep-time" name="prep-time" />
                        <small class="instructions form-text text-muted">How long will it take to prep?</small>
                    </div>
                </div>
            </div>
    <!-- COOK/DIFF LEVELS -->
            <div class="form-group">
                <div class="form-row">
                    <label for="cook-time" class="col-sm-2 col-form-label">Cook Time</label>
                    <div class="col-sm-3">
                        <input type="time" class="form-control" id="cook-time" name="cook-time" />
                        <small class="instructions form-text text-muted">How long will it take to cook?</small>
                    </div>
                </div>
            </div>
            <!-- DIFF LEVEL -->
            <fieldset class="form-group">
                <div class="form-row">
                    <div class="col-sm-2">
                        <legend class="col-form-label">Overall Difficulty Level</legend>
                    </div>
                    <div class="col-sm-8">
                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" name="overallDiff" id="O1" value="1"/>
                            <label for="01" class="form-check-label">1</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" name="overallDiff" id="O2" value="2"/>
                            <label for="02" class="form-check-label">2</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" name="overallDiff" id="O3" value="3"/>
                            <label for="03" class="form-check-label">3</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" name="overallDiff" id="04" value="4"/>
                            <label for="04" class="form-check-label">4</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" name="overallDiff" id="05" value="5"/>
                            <label for="05" class="form-check-label">5</label>
                        </div>
                        <small class="form-text text-muted">From household essentials to i've never heard of it.</small>

                    </div>
                </div>
            </fieldset>
    <!-- SPICY LEVEL -->
            <fieldset class="form-group">
                <div class="form-row">
                    <legend class="col-form-label col-sm-2">Spicy Level</legend>
                    <div class="col-sm-10">
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="spicy" id="l0" value="1" />
                            <label for="l0" class="form-check-label">None, Zero.</label>
                        </div>

                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="spicy" id="l1" value="2" />
                            <label for="l1" class="form-check-label">Barely taste it.</label>
                        </div>

                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="spicy" id="l2" value="3" />
                            <label for="l2" class="form-check-label">Ok, I feel some heat.</label>
                        </div>

                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="spicy" id="l3" value="4" />
                            <label for="l3" class="form-check-label">That's spicy!</label>
                        </div>

                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="spicy" id="l4" value="5" />
                            <label for="l4" class="form-check-label">I can't feel my tongue anymore.</label>
                        </div>

                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="spicy" id="l5" value="6" />
                            <label for="l5" class="form-check-label">Is my face melting?</label>
                        </div>
                    </div>
                </div>
            </fieldset>

    <!-- INGREDIENTS -->
    <?php
    //include the Add Ingredient section  (Paul's Lab 6) -needs some formatting still
    //include '../controllers/ingredients/_addingredient.php' ?>
            <fieldset class="form-group">
                <div class="form-row">
                    <legend class="col-form-label col-sm-3 col-md-2">Ingredients</legend>
                    <div class="col-sm-2">
                        <!-- THIS FORM GROUP WILL BE REPEATED AND POPULATED WITH PHP -->
                        <div class="form-group">
                            <input type="checkbox" name="ingred" id="ingred" class="form-check-input" value=""/>
                            <label for="ingred" class="form-check-label">Ingred</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="ingred" id="ingred" class="form-check-input" value=""/>
                            <label for="ingred" class="form-check-label">Ingred</label>
                        </div>
                        <!-- END FOREACH FROM PHP -->
                    </div>
                    <div class="col-sm-2">
                        <!-- THIS FORM GROUP WILL BE REPEATED AND POPULATED WITH PHP -->
                        <div class="form-group">
                            <input type="checkbox" name="ingred" id="ingred" class="form-check-input" value=""/>
                            <label for="ingred" class="form-check-label">Ingred</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="ingred" id="ingred" class="form-check-input" value=""/>
                            <label for="ingred" class="form-check-label">Ingred</label>
                        </div>
                        <!-- END FOREACH FROM PHP -->
                    </div>
                    <div class="col-sm-2">
                        <!-- THIS FORM GROUP WILL BE REPEATED AND POPULATED WITH PHP -->
                        <div class="form-group">
                            <input type="checkbox" name="ingred" id="ingred" class="form-check-input" value=""/>
                            <label for="ingred" class="form-check-label">Ingred</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="ingred" id="ingred" class="form-check-input" value=""/>
                            <label for="ingred" class="form-check-label">Ingred</label>
                        </div>
                        <!-- END FOREACH FROM PHP -->
                    </div>
                    <div class="col-sm-2">
                        <!-- THIS FORM GROUP WILL BE REPEATED AND POPULATED WITH PHP -->
                        <div class="form-group">
                            <input type="checkbox" name="ingred" id="ingred" class="form-check-input" />
                            <label for="ingred" class="form-check-label">Ingred</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="ingred" id="ingred" class="form-check-input" />
                            <label for="ingred" class="form-check-label">Ingred</label>
                        </div>
                        <!-- END FOREACH FROM PHP -->
                    </div>
                </div>
            </fieldset>
            <!-- INGREDIENT RATING -->
            <fieldset class="form-group">
                <div class="form-row">
                    <div class="col-sm-2">
                        <legend class="col-form-label">Ingredient Difficulty</legend>
                    </div>
                    <div class="col-sm-8">
                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" name="ingredDiff" id="1" value="1"/>
                            <label for="1" class="form-check-label">1</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" name="ingredDiff" id="2" value="2"/>
                            <label for="2" class="form-check-label">2</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" name="ingredDiff" id="3" value="3"/>
                            <label for="3" class="form-check-label">3</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" name="ingredDiff" id="4" value="4"/>
                            <label for="4" class="form-check-label">4</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" name="ingredDiff" id="5" value="5"/>
                            <label for="5" class="form-check-label">5</label>
                        </div>
                        <small class="form-text text-muted">From household essentials to i've never heard of it.</small>

                    </div>
                </div>
            </fieldset>
            <!-- STEPS TO MAKE THE RECIPE -->
            <fieldset class="form-group">
                <div class="form-row">
                    <legend class="col-form-label col-sm-2">Steps</legend>
                    <div class="col-sm-8">
                        <ol class="list-of-instructions">
                            <!-- REPEAT PHP HERE -->
                            <li><input type="text" class="form-control steps" name="item[0][step]" value=""/></li>
                            <li><input type="text" class="form-control steps" name="item[1][step]" value=""/></li>
                            <li><input type="text" class="form-control steps" name="item[2][step]" value=""/></li>
                            <li><input type="text" class="form-control steps" name="item[3][step]" value=""/></li>
                            <!-- END PHP REPEAT HERE -->
                        </ol>
                        <p id="moreRows">Add More Rows</p>
                        <!-- <input type="button" id="moreRows" name="moreRows" value="Add More Rows"/> -->
                    </div>
                </div>
            </fieldset>
            <input type="submit" id="addRecipe" name="addRecipe" class="btn" value="Add"/>
            <input type="submit" id="updateRecipe" name="updateRecipe" class="btn" value="Update"/>
            <input type="submit" id="deleteRecipe" name="deleteRecipe" class="btn" value="Delete"/>
            <!-- <input type="text" readonly class="form-control-plaintext" name="errMssg" value=""> -->
            <p>
            <?php if(isset($_SESSION['recipe_err_mssg']['input_field_error'])) {
                echo $_SESSION['recipe_err_mssg']['input_field_error'];
            }?>
            </p>
        </form>
    </div>
</main>
<?php
require_once 'partial/_footer.php';
?>
