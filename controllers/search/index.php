<?php
//if someone accesses this page with out actually searching for something it will redirect to the main home page
// if (!isset($_GET['action'])) {
//     header("Location: ./index.php");
// }

require_once '../../models/recipeDB.php';//use Jessica's RecipeDB model
require_once '../../models/db.php';
$db = Database::getDb();

var_dump($_GET);
switch($_GET['action']) {
    case ('searchKey'):
        $searchParam = $_GET['phrase'];
        echo "inside searchKey";
        $results = RecipeDb::getRecipeDetailsByTitle($searchParam);
        break;
}
// echo "<pre>";
// // print_r($results);
// var_dump($_SERVER);
// var_dump($_ENV);
// echo "</pre>";

 ?>
<ul>
    <?php foreach ($results as $key => $r) {?>
    <li class="recipe-item row col-12">
        <figure class="col-3">
            <img class="recipe-img" src="chowtime/<?php echo $r->img_src?>" alt=""/>
        </figure>
        <div class="recipe-header col-9">
            <h3 class="recipe-name col-9"><?php echo $r->title ?></h3>
            <span class="prep-time col-3">Prep Time: <?php echo $r->prep_time ?></span>
            <span class="cook-time col-3">Cook Time: <?php echo $r->cook_time ?></span>
            <span class="diff-lvl col-3">Difficulty Level: <?php echo $r->diff_lvl ?></span>
        </div>
        <div class="recipe-header col-9">
            <?php echo $r->description?>
        </div>
        <input type="button" name="viewRecipe" class="btn btn-default" value="View Recipe" />
        <input type="button" name="madeIt" class="btn btn-default" value="I Made it" />
    </li>
<?php }//End of FOREACH to list Timers?>
</ul>
