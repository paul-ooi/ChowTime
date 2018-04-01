<?php
$pageTitle = "Make a Recipe";
require_once 'partial/_header.php';
?>
<script src="../assets/js/makeRecipe.js"></script>
<link rel="stylesheet" type="text/css" href="../assets/css/makeRecipe.css" />
</head>
<?php
require_once 'partial/_mainnav.php';
require_once '../models/validation.php';

// VALIDATE FIELDS AREN'T EMPTY ON SUBMIT
$v = new Validation();
if(isset($_POST["addRecipe"])) {
    $inTitle = $v->checkAssignProperty("recipe-title");
    $inDescr = $v->checkAssignProperty("recipe-description");
    $inFileName = $v->checkAssignProperty("upFile");
    $inPrepTime = $v->checkAssignProperty("prep-time");
    $inCookTime = $v->checkAssignProperty("cook-time");
    $spiceLevel = $v->checkAssignProperty("spicy");
    // $ingredients = checkAssignProperty("")
    $diffLevel = $v->checkAssignProperty("diffLvl");
    $stepsArr = array_map("allSteps", $_POST['item']);

    function allSteps($e){
        return $e["step"];
    }

    if($inTitle == null || $inDescr == null || $inFileName == null || $inPrepTime == null || $inCookTime == null || $spiceLevel == null || $diffLevel == null || $stepsArr == null) {
        $errMssg = "Please fill out all fields to add a recipe!";
    }
}
 ?>
<main>
    <div class="wrapper">
        <form method="post" enctype="multipart/form-data" action="makeRecipe.php">
            <div class="form-group">
                <div class="form-row">
                    <label for="recipe-title" class="col-sm-2 col-form-label">Title</label>
                    <div class="col-sm-8">
                        <input type="text" id="recipe-title" class="form-control" placeholder="Spaghetti and Meatballs" name="recipe-title" />
                        <small class="instructions form-text, text-muted">Give your recipe a title name!</small>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="form-row">
                    <label for="recipe-description" class="col-sm-2 col-form-label">Description</label>
                    <div class=" col-sm-8">
                        <textarea id="recipe-description" class="form-control" rows="3" placeholder="Made with fresh thyme and basil..." name="recipe-description"></textarea>
                        <small class="instructions form-text, text-muted">Describe your recipe</small>
                    </div>
                </div>
            </div>
<!-- PHOTO UPLOAD - OPTION TO ADD MORE PHOTOS -->
            <div class="form-group">
                <div class="form-row">
                    <label for="photos" class="col-sm-2 col-form-label">Upload Photos</label>
                    <div class="col-sm-8">
                        <input type="hidden" value="100000" name="MAX_FILE_SIZE" />
                        <input type="file" name="upFile" id="photos" />
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="form-row">
                    <label for="prep-time" class="col-sm-2 col-form-label">Prep Time</label>
                    <div class="col-sm-3">
                        <input type="time" class="form-control" id="prep-time" name="prep-time" />
                        <small class="instructions, form-text, text-muted">How long will it take to prep?</small>
                    </div>
                </div>
            </div>
    <!-- COOK/DIFF LEVELS -->
            <div class="form-group">
                <div class="form-row">
                    <label for="cook-time" class="col-sm-2 col-form-label">Cook Time</label>
                    <div class="col-sm-3">
                        <input type="time" class="form-control" id="cook-time" name="cook-time" />
                        <small class="instructions, form-text, text-muted">How long will it take to cook?</small>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="form-row">
                    <label for="diff-level" class="col-sm-2 col-form-label">Difficulty Level</label>
                    <div class="col-sm-3">
                        <div class="form-row d-flex diff-container">
                            <input type="hidden" value="" name="diffLvl"
                            <div class="diff col-sm-2">1</div>
                            <div class="diff col-sm-2">2</div>
                            <div class="diff col-sm-2">3</div>
                            <div class="diff col-sm-2">4</div>
                            <div class="diff col-sm-2">5</div>
                        </div>
                        <small class="instructions, form-text, text-muted">From piece of cake to rocket science</small>
                    </div>
                </div>
            <!-- </div> -->
    <!-- SPICY LEVEL -->
            <fieldset class="form-group">
                <div class="form-row">
                    <legend class="col-form-label col-sm-2">Spicy Level</legend>
                    <div class="col-sm-10">
                        <div class="form-group">
                            <input type="radio" class="form-check-input" name="spicy" id="l0" value="0" />
                            <label for="l0" class="form-check-label">None, thank you.</label>
                        </div>

                        <div class="form-group">
                            <input type="radio" class="form-check-input" name="spicy" id="l1" value="1" />
                            <label for="l1" class="form-check-label">Barely taste it.</label>
                        </div>

                        <div class="form-group">
                            <input type="radio" class="form-check-input" name="spicy" id="l2" value="3" />
                            <label for="l2" class="form-check-label">Ok, I feel some heat.</label>
                        </div>

                        <div class="form-group">
                            <input type="radio" class="form-check-input" name="spicy" id="l3" value="4" />
                            <label for="l3" class="form-check-label">That's spicy!</label>
                        </div>

                        <div class="form-group">
                            <input type="radio" class="form-check-input" name="spicy" id="l4" value="4" />
                            <label for="l4" class="form-check-label">I can't feel my tongue anymore.</label>
                        </div>

                        <div class="form-group">
                            <input type="radio" class="form-check-input" name="spicy" id="l5" value="5" />
                            <label for="l5" class="form-check-label">Is my face melting?</label>
                        </div>
                    </div>
                </div>
            </fieldset>

    <!-- INGREDIENTS -->
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
            <input type="text" readonly class="form-control-plaintext" name="errMssg" value="<?php if(isset($errMssg)) {
                echo $errMssg;
            }?>">
        </form>
    </div>
</main>
<?php
require_once 'partial/_footer.php';
?>
