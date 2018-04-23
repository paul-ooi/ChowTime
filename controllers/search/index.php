<?php
session_start();
// $_SESSION['user_id'] = 68;
//if someone accesses this page with out actually searching for something it will redirect to the main home page
if (!isset($_GET['action'])) {
    header("Location: index.php");
}

require_once '../../models/recipeDB.php';//use Jessica's RecipeDB model
require_once '../../models/db.php';
$db = Database::getDb();

// var_dump($_GET);
switch($_GET['action']) {
    case ('searchKey'):
        $searchParam = $_GET['phrase'];
        // echo "inside searchKey";
        $results = RecipeDb::getRecipeDetailsByTitle($searchParam);

        // var_dump($results);
        break;
}
// echo "<pre>";
// print_r($results);
// // var_dump($_SERVER);
// // var_dump($_ENV);
// echo "</pre>";

 ?>
 <h2>Search Results &lpar;<?php echo count($results) ?> Recipes&rpar;</h2>
<ul>
    <?php foreach ($results as $key => $r) {?>
    <li class="recipe-item row mb-5">
        <div class="row mb-3">
            <figure class="col-4 mb-2 px-0">
                <img class="recipe-img img-fluid" src="chowtime/<?php echo $r->img_src?>" alt=""/>
            </figure>
            <div class="recipe-header col-8">
                <h3 class="recipe-name col-12"><?php echo $r->title ?></h3>
                <span class="prep-time col-4">Prep Time: <?php echo $r->prep_time?></span>
                <span class="cook-time col-4">Cook Time: <?php echo $r->cook_time ?></span>
                <span class="diff-lvl col-4">Difficulty Level: <?php echo $r->diff_lvl ?></span>
                <div class="recipe-desc col-12">
                    <?php echo $r->description?>
                </div>
            </div>
        </div>
        <div class="col-lg-4 d-flex flex-wrap justify-content-start px-0   ">
            <a href="<?php echo 'pages/recipes.php?&id='. $r->recipe_id ?>" class="btn btn-default col-md-5 mx-2">View Recipe</a>
            <!-- <input type="button" name="viewRecipe" class="btn btn-default col-md-5 mx-2" value="View Recipe" /> -->
            <!-- Button for I Made it is only for ractive users -->
            <?php if (isset($_SESSION['user_id'])) { ?>
                <form action="controllers/Recipe/_i-made-it.php" method="post" name="iMadeIt" class="col-md-6">
                    <input type="hidden" name="recipe_id" value="<?php echo $r->recipe_id ?>"/>
                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'] ?>"/>   
                    <input type="submit" name="madeIt" class="btn btn-default col-12" value="I Made it" />
                </form>
            <?php }?>
        </div>

    </li>
<?php }//End of FOREACH to list Timers?>
</ul>
