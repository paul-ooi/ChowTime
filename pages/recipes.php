<?php
session_start();
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
}
else {
    $recentRecipe = RecipeDb::getRecentPublishedRecipe();
    $recipe_id = $recentRecipe->id;
}

//IMAGE COUNTER
$count = 0;

//====================================================
$mainRecipeImg = RecipeDb::mainRecipeImg($recipe_id);
$allRecipeImgs = RecipeDb::allRecipeImgs($recipe_id);
$recipe = RecipeDb::displayById($recipe_id);
$recommDiff = RecipeDb::recommDiff($recipe_id);
$totalTime = RecipeDb::totalRecipeTime($recipe_id);
$recipe_owner_id = RecipeDb::getRecipeOwner($recipe_id);
//====================================================
?>

<?php require_once 'partial/_mainnav.php' ?>
<div id="background-image">
    <main>
        <!-- IF USER IS THE SAME AS THE ONE WHO CREATED THE RECIPE, THEY CAN ALSO EDIT. -->
        <?php if(isset($_SESSION['user_id'])) :
            $user_id = $_SESSION['user_id'];
            $userRole = RecipeDb::getUserRole($user_id);
            if($user_id == $recipe_owner_id['user_id'] || $userRole['admin'] == 1) : ?>
                <div class="row container">
                    <p><?php if(isset($_SESSION['recipe_err_mssg']['delete_error'])) {
                        echo $_SESSION['recipe_err_mssg']['delete_error'];
                    } ?></p>
                    <form method="POST" action="/chowtime/pages/updateRecipe.php" class="text-right form-inline col-md-4 mb-4">
                        <input type="submit" id="updateRecipe" name="updateRecipe" class="btn" value="Update"/>
                        <input type="hidden" name="recipe_id" value="<?php if(isset($recipe_id)) {echo $recipe_id;} ?>"/>
                    </form>
                </div>
                <?php endif ?>
        <?php endif ?>

        <!-- CONTAINER LEFT -->
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                <!-- RECIPE NAME AND CAROUSEL CONTAINER -->
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                        <?php foreach ($allRecipeImgs as $recipeImg) : ?>
                            <?php foreach($recipeImg as $key => $value) : ?>
                                <div class="carousel-item <?php if ($count == 0) {echo "active";} ?>">
                                    <img src="<?= $value ?>" alt="<?= $key ?>" class="d-block w-100" name="inImgFiles"/>
                                </div>
                                <?php $count++ ?>
                            <?php endforeach ?>
                        <?php endforeach ?>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>

                    <div class="row mt-4 mb-4 justify-content-center">
                        <!-- ICON CONTAINER -->
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
                        <!-- SHARE ON PINTEREST CONTAINER -->
                        <div class="row">
                            <span>Share on pinterest!</span>
                            <div class="text-center ml-2"><a href="https://www.pinterest.com/pin/create/button/" data-pin-do="buttonBookmark"></a></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 offset-lg-1">
                    <!-- INGREDIENTS -->
                    <h3 class="recipe-title">Ingredients</h3>
                    <span>Prep Time:</span>
                    <span><?=$recipe->prep_time?> min</span>
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

                    <!-- DIRECTIONS -->
                    <h3 class="recipe-title">Directions</h3>
                    <span>Cook Time:</span>
                    <span><?= $recipe->cook_time ?> min</span>
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

                    <!-- EMAIL RECIPE -->
                    <h3 class="recipe-title">Email this recipe:</h3>
                    <form method="post" action="../controllers/Recipe/emailRecipe.php" class="mb-4 mt-4">
                        <input type="hidden" name="recipe_id" value="<?php echo $recipe_id ?>" />
                        <div class="form-row justify-content-center flex-column">
                            <div class="form-group row">
                                <legend class="col-form-label col-sm-2">To Email:</legend>
                                <div class="col-sm-10">
                                    <input type="email" name="toEmail" class="form-control"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-row justify-content-center flex-column">
                            <div class="form-group row">
                                <legend class="col-form-label col-sm-2">To Name:</legend>
                                <div class="col-sm-10">
                                    <input type="text" name="toName" class="form-control"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <input type="submit" name="emailRecipe" value="Send" class="btn">
                        </div>
                        <div class="form-row justify-content-center">
                            <div>
                                <small class="text-muted">
                                <?php if(isset($_SESSION['email_mssg'])) {
                                    echo $_SESSION['email_mssg'];
                                }?>
                                </small>
                            </div>
                        </div>
                    </form>
                </div> <!-- END SECOND CONTAINER SECTION -->
            </div>
        </div>
    </main>
</div>

<!-- FOOTER/CLEAR SESSIONS  -->
<?php include 'partial/_footer.php'; ?>
</body>
<?php 
unset($_SESSION['recipe_err_mssg']);
unset($_SESSION['email_mssg']);
?>
</html>
