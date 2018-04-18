<?php
session_start();
$_SESSION['user_id'] = 1;
/*======================*/

$pageTitle = "Recipes";
require_once 'partial/_header.php';
?>
<script
    type="text/javascript"
    async defer
    src="//assets.pinterest.com/js/pinit.js"></script>
<link rel="stylesheet" href="../assets/css/recipe.css" />
<script src="../assets/js/recipe.js"></script>
</head>
<?php
require_once '../models/recipes.php';
require_once '../models/db.php';
require_once '../models/ingredient.php';
require_once '../models/ingredientDB.php';
require_once '../models/recipeDB.php';
require_once '../models/credentials.php';

//THE ID HERE NEEDS TO BE POPULATED BY SEARCH IN A GET
// $recipe_id = $_SESSION[$recipe_id];

if(isset($_GET['id'])) {
    $recipe_id = $_GET['id'];
} else {
    $recentRecipe = RecipeDb::getRecentPublishedRecipe();
    $recipe_id = $recentRecipe->id;
}
//====================================================
$mainRecipeImg = RecipeDb::mainRecipeImg($recipe_id);
$allRecipeImgs = RecipeDb::allRecipeImgs($recipe_id);
$recipe = RecipeDb::displayById($recipe_id);
$recommDiff = RecipeDb::recommDiff($recipe_id);
$totalTime = RecipeDb::totalRecipeTime($recipe_id);
$recipe_owner_id = RecipeDb::getRecipeOwner($recipe_id);
//====================================================

//SHARE RECIPES
function getAuthCode() {

}
?>
<header class="container ddwrapper">
    <?php require_once 'partial/_mainnav.php' ?>
</header>
    <main>
        <!-- IF USER IS THE SAME AS THE ONE WHO CREATED THE RECIPE, THEY CAN ALSO EDIT. -->
        <?php if(isset($_SESSION['user_id'])) :
            $user_id = $_SESSION['user_id'];
            if($user_id == $recipe_owner_id['user_id']) : ?>
            <form method="POST" action="/chowtime/pages/updateRecipe.php" class="text-right">
                <input type="submit" id="updateRecipe" name="updateRecipe" class="btn" value="Update"/>
                <input type="hidden" name="recipe_id" value="<?= $recipe_id ?>"/>
            </form>
            <?php endif ?>
        <?php endif?>
        <meta property="og:https://www.jesscwong.ca" content="letthebakingbeginblog.com" />
        <div itemscope itemtype="http://schema.org/Recipe">
        <h2 itemprop="name"><?= $recipe->title ?></h2>
            <div class="row aside-left">
                <div class="col-sm-6 main-image-thumbnail-container">
                    <div class="main-img-container">
                        <img src="<?= $mainRecipeImg->img_src ?>" alt="image" id="main"/>
                    </div>
                    <div class="d-flex justify-content-between thumbnail-images-container">
                        <?php foreach ($allRecipeImgs as $recipeImg) : ?>
                            <?php foreach($recipeImg as $key => $value) : ?>
                                <div class="thumbnail-container">
                                    <img src="<?= $value ?>" alt="<?= $key ?>" class="thumbnail" name="inImgFiles"/>
                                </div>
                            <?php endforeach ?>
                        <?php endforeach ?>
                    </div>
                </div>
                <!-- End image container -->
                <div class="col-sm-6 icon-descr-container">
                    <div class="container icon-container">
                        <div class="row row-container">
                            <div class="text-center col-xs-6 col-sm-3 icon-text-container">
                                <div class="icon-img-container">
                                    <img src="../assets/icons/frying-pan.svg" alt="frying pan icon" class="icon" class="icon"/>
                                </div>
                                <p>
                                    <!-- <span>Recommended Difficulty:</span> -->
                                    <span><?= $recommDiff->recomm_diff ?></span>
                                </p>
                            </div>
                            <div class="text-center col-xs-6 col-sm-3 icon-text-container">
                                <div class="icon-img-container">
                                    <img src="../assets/icons/hourglass.svg" alt="hourglass icon" class="icon" />
                                </div>
                                <p>
                                    <!-- <span>Total Time:</span> -->
                                    <span itemprop="totalTime"><?= $totalTime->total_time ?></span>
                                </p>
                            </div>
                            <div class="text-center col-xs-6 col-sm-3 icon-text-container">
                                <div class="icon-img-container">
                                    <img src="../assets/icons/fork.svg" alt="fork icon" class="icon" />
                                </div>
                                <p>
                                    <!-- <span>Community Rating:</span> -->
                                    <span><?= $recipe->diff_lvl?></span>
                                </p>
                            </div>
                            <div class="text-center col-xs-6 col-sm-3 icon-text-container">
                                <div class="icon-img-container">
                                    <img src="../assets/icons/pepper.svg" alt="Chili pepper icon" class="icon" />
                                </div>
                                <p>
                                    <!-- <span>Spicy Level:</span> -->
                                    <span><?= $recipe->spicy_lvl ?></span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <h3 class="text-center" id="recipe_descr"><?= $recipe->description ?></h3>
                    <div class="text-center"><a href="https://www.pinterest.com/pin/create/button/" data-pin-do="buttonBookmark"></a></div>
                </div>
                <!-- End title-icon-descr-container -->
            </div>
            <!-- End aside left -->
            <div class="row aside-right">
                <div class="col-md-12 ingredients-container">
                    <h2>Ingredients</h2>
                    <span>Prep Time:</span>
                    <span><?=$recipe->prep_time?></span>
                    <div>
                        <!-- Use Recipe Id, Call for all ingredients from same recipe -->
                        <ul class="m-4 pl-2">
                            <?php 
                                $db = Database::getDb();
                                $ingredients = IngredientDB::getRecipeIngredients($db, $recipe->id);
                                foreach ($ingredients as $key => $i) {
                            ?>
                            <li class="row justify-content-start text-left">
                                 <span class="mx-1"><?php echo ($i->quantity) ? $i->quantity : '' ?></span>
                                 <span class="mx-1"><?php echo ($i->measurement) ? $i->measurement : '' ?></span>
                                 <span class="mx-1"><?php echo ($i->prep) ? $i->prep : '' ?></span>   
                                 <span class="mx-1"><?php echo $i->food_name?></span>
                                 <?php if ($i->required == 0){
                                     ?>
                                     <span class="mx-3">&lpar;Optional&rpar;</span>
                                     <?php
                                 } ?>  
                            </li>
                            <?php }?>
                        </ul>
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
                     <div class="user-comment-container">
                         <img src="#" alt="profile-photo"/>
                         <span class="username"><strong>Username:</strong></span><span>jwong</span>
                         <span class="date"><strong>Date:</strong></span><span>March 30, 2018</span>
                         <p class="user_comment">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse hendrerit accumsan dignissim. Phasellus lacinia tincidunt ex, in accumsan eros luctus nec. Nulla luctus dignissim augue, non auctor metus tempor ut. Duis eros justo, fringilla sed massa et, ullamcorper vulputate diam. Vivamus posuere, erat sollicitudin egestas pellentesque, diam felis tempus dolor, eu rhoncus neque nulla ut orci. Maecenas blandit tortor non orci volutpat condimentum. Phasellus lorem dui, dignissim a ex vitae, placerat eleifend risus. Ut porttitor eros turpis, sed posuere neque faucibus eu. Quisque aliquet sit amet nunc at condimentum. Fusce ornare magna lobortis enim maximus, ac consectetur sem volutpat. Etiam id pharetra metus, sit amet mattis eros. Pellentesque accumsan nulla id blandit euismod.</p>
                     </div>
                     <!-- Repeate user-comment-container for each user comment on this recipe -->
                 </div>
             </div>
        </div>
    </main>
<?php include 'partial/_footer.php'; ?>
</body>
</html>
