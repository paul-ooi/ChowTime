<?php
$pageTitle = "Recipes";
include '_header.php';
require_once '../models/recipes.php';
require_once '../models/db.php';
require_once '../models/ingredient.php';

// INSTANCES
$r = new Recipes();
$i = new ingredient();

//THE ID HERE NEEDS TO BE POPULATED BY SEARCH IN A GET
//====================================================
$recipe = $r->displayById(Database::getDb(), 1);
$totalTime = $r->totalRecipeTime(Database::getDb(), 1);
$recommDiff = $r->recommDiff(Database::getDb(), 1);
$mainRecipeImg = $r->mainRecipeImg(Database::getDb(), 1);
$allRecipeImgs = $r->allRecipeImgs(Database::getDb(), 1);
//====================================================

?>
<link rel="stylesheet" href="../assets/css/recipe.css" />
</header>
    <main>
        <div class="aside-left">
            <div class="main-image-thumbnail-container">
                <div class="main-img-container">
                    <img src="<?= $mainRecipeImg->img_src ?>" alt="image" id="main"/>
                </div>
                <div class="thumbnail-images-container">
                    <?php foreach ($allRecipeImgs as $recipeImg) : ?>
                        <?php foreach($recipeImg as $key => $value) : ?>
                            <div class="thumbnail-container">
                                <img src="<?= $value ?>" alt="<?= $key ?>" class="thumbnail" />
                            </div>
                        <?php endforeach ?>
                    <?php endforeach ?>
                </div>
            </div>
            <!-- End image container -->
            <div class="title-icon-descr-container">
                <h2><?= $recipe->title ?></h2>
                <div class="icon-container">
                    <div class="icon-text-container">
                        <div class="icon-img-container">
                            <img src="../icons/frying-pan.svg" alt="frying pan icon" class="icon" class="icon"/>
                        </div>
                        <p>
                            <span>Recommended Difficulty:</span>
                            <span><?= $recommDiff->recomm_diff ?></span>
                        </p>
                    </div>
                    <div class="icon-text-container">
                        <div class="icon-img-container">
                            <img src="../icons/hourglass.svg" alt="hourglass icon" class="icon" />
                        </div>
                        <p>
                            <span>Total Time:</span>
                            <span><?= $totalTime->total_time ?></span>
                        </p>
                    </div>
                    <div class="icon-text-container">
                        <div class="icon-img-container">
                            <img src="../icons/fork.svg" alt="fork icon" class="icon" />
                        </div>
                        <p>
                            <span>Community Rating:</span>
                            <span><?= $recipe->diff_lvl?></span>
                        </p>
                    </div>
                    <div class="icon-text-container">
                        <div class="icon-img-container">
                            <img src="../icons/pepper.svg" alt="Chili pepper icon" class="icon" />
                        </div>
                        <p>
                            <span>Spicy Level:</span>
                            <span><?= $recipe->spicy_lvl ?></span>
                        </p>
                    </div>
                </div>
                <h3><?= $recipe->description ?></h3>
            </div>
            <!-- End title-icon-descr-container -->
        </div>
        <!-- End aside left -->
        <div class="aside-right">
            <div class="ingredients-container">
                <h2>Ingredients</h2>
                <span>Prep Time:</span>
                <span><?=$recipe->prep_time?></span>
                <div class="ingredient-container">
                    <span>Quantity</span>
                    <span>Unit</span>
                    <span>food item id</span>
                </div> <!-- Repeat this ingredient-container block for each ingredient in the list -->
            </div>

            <div class="directions-container">
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
        <div class="comment-container">
            <h2>Comments</h2>
            <form action="Recipes.php" method="post" name="commentBox" id="commentBox">
                <label for="comments">Leave a comment:</label>
                <textarea name="comments" id="comments"></textarea>
                <input type="submit" id="addComment" name="addComment" />
            </form>
        </div>
        <div class="comments-display-container">
            <div class="user-comment-container">
                <p>Username</p>
                <p>Date</p>
                <p>Comment</p>
            </div>
            <!-- Repeate user-comment-container for each user comment on this recipe -->
        </div>
    </main>
<?php include '_footer.php'; ?>
</body>
</html>
