<?php
$pageTitle = "Recipes";
include '_header.php';
require_once '../models/recipes.php';
require_once '../models/db.php';
require_once '../models/ingredient.php';
require_once '../models/recipesDb.php';

//THE ID HERE NEEDS TO BE POPULATED BY SEARCH IN A GET
//====================================================
$mainRecipeImg = RecipeDb::mainRecipeImg(1);
$allRecipeImgs = RecipeDb::allRecipeImgs(1);
$recipe = RecipeDb::displayById(1);
$recommDiff = RecipeDb::recommDiff(1);
$totalTime = RecipeDb::totalRecipeTime(1);
//====================================================
require_once '_mainnav.php';
?>
<link rel="stylesheet" href="../assets/css/recipe.css" />
<script src="../assets/js/recipe.js"></script>
<main>
    <div class="row aside-left">
        <h2 id="title"><?= $recipe->title ?></h2>
        <div class="col-lg-6 main-image-thumbnail-container">
            <div class="main-img-container">
                <img src="<?= $mainRecipeImg->img_src ?>" alt="image" id="main"/>
            </div>
            <div class="row thumbnail-images-container">
                <?php foreach ($allRecipeImgs as $recipeImg) : ?>
                    <?php foreach($recipeImg as $key => $value) : ?>
                        <div class="thumbnail-container">
                            <img src="<?= $value ?>" alt="<?= $key ?>" class="col-sm-4 thumbnail" />
                        </div>
                    <?php endforeach ?>
                <?php endforeach ?>
            </div>
        </div>
        <!-- End image container -->
        <div class="col-lg-6 title-icon-descr-container">
            <div class="row icon-container">
                <div class="text-center col-xs-3 icon-text-container">
                    <div class="icon-img-container">
                        <img src="../icons/frying-pan.svg" alt="Recommended Difficulty" class="icon" class="icon"/>
                    </div>
                    <p>
                        <!-- CAPTION -->
                        <div class="caption hidden">Recommended Difficulty</div>
                        <!-- <span>Recommended Difficulty:</span> -->
                        <span><?= $recommDiff->recomm_diff ?></span>
                    </p>
                </div>
                <div class="text-center col-xs-3 icon-text-container">
                    <div class="icon-img-container">
                        <img src="../icons/hourglass.svg" alt="Total Time" class="icon" />
                    </div>
                    <p>
                        <!-- <span>Total Time:</span> -->
                        <span><?= $totalTime->total_time ?></span>
                    </p>
                </div>
                <div class="text-center col-xs-3 icon-text-container">
                    <div class="icon-img-container">
                        <img src="../icons/fork.svg" alt="Community Rating" class="icon" />
                    </div>
                    <p>
                        <!-- <span>Community Rating:</span> -->
                        <span><?= $recipe->diff_lvl?></span>
                    </p>
                </div>
                <div class="text-center col-xs-3 icon-text-container">
                    <div class="icon-img-container">
                        <img src="../icons/pepper.svg" alt="Spicy Level" class="icon" />
                    </div>
                    <p>
                        <!-- <span>Spicy Level:</span> -->
                        <span><?= $recipe->spicy_lvl ?></span>
                    </p>
                </div>
            </div>
            <h4><?= $recipe->description ?></h4>
        </div>
        <!-- End title-icon-descr-container -->
    </div>
    <!-- End aside left -->
    <div class="row aside-right">
        <div class="col-md-12 ingredients-container">
            <h2>Ingredients</h2>
            <span>Prep Time:</span>
            <span><?=$recipe->prep_time?></span>
            <div class="ingredient-container">
                <span>Quantity</span>
                <span>Unit</span>
                <span>food item id</span>
            </div> <!-- Repeat this ingredient-container block for each ingredient in the list -->
        </div>

        <div class="col-md-12 directions-container">
            <h2>Directions</h2>
            <span>Cook Time:</span>
            <span><?= $recipe->cook_time ?></span>
            <div class="direction-container">
                <ol>
                   <?php
                   $recipeArr = explode(";",$recipe->steps);
                   foreach ($recipeArr as $key => $value) {
                       echo "<li>" . $value . "</li>";
                   }
                    ?>
                </ol>
            </div>
        </div>
    </div> <!-- End aside right -->
    <div class="row">
        <div class="col-md-12 comment-container">
            <h2>Comments</h2>
            <form action="Recipes.php" method="post" name="commentBox" id="commentBox">
                <div class="form-group">
                    <label for="comments">Leave a comment:</label>
                    <textarea name="comments" id="comments" class="form-control" rows="5"></textarea>
                </div>
                <input type="submit" id="addComment" name="addComment" class="btn btn-info"/>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="comments-display-container">
            <div class="row user-comment-container">
                <img src="#" alt="profile-photo"/>
                <span class="username"><strong>Username:</strong></span><span>jwong</span>
                <span class="date"><strong>Date:</strong></span><span>March 30, 2018</span>
                <p class="user_comment">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse hendrerit accumsan dignissim. Phasellus lacinia tincidunt ex, in accumsan eros luctus nec. Nulla luctus dignissim augue, non auctor metus tempor ut. Duis eros justo, fringilla sed massa et, ullamcorper vulputate diam. Vivamus posuere, erat sollicitudin egestas pellentesque, diam felis tempus dolor, eu rhoncus neque nulla ut orci. Maecenas blandit tortor non orci volutpat condimentum. Phasellus lorem dui, dignissim a ex vitae, placerat eleifend risus. Ut porttitor eros turpis, sed posuere neque faucibus eu. Quisque aliquet sit amet nunc at condimentum. Fusce ornare magna lobortis enim maximus, ac consectetur sem volutpat. Etiam id pharetra metus, sit amet mattis eros. Pellentesque accumsan nulla id blandit euismod.</p>
            </div>
            <!-- Repeate user-comment-container for each user comment on this recipe -->
        </div>
    </div>
</main>
<?php include '_footer.php'; ?>
</body>
</html>
