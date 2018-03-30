<?php
require '../../models/db.php';
require '../../models/recipes.php';

// TESTING GROUND
$r = new Recipes();
$allRecipes = $r->displayAllRecipes(Database::getDb());
$recipe = $r->displayById(Database::getDb(), 1);

?>

<!-- =========================PROPER CODE========================== -->

<?php
include '../pages/_header.php';
?>
<main>
    <h1>All Recipes</h1>
    <?php foreach ($allRecipes as $r) : ?>
        <div>
            id: <?= $r->id ?><br />
            user id: <?= $r->user_id ?><br />
            img id: <?= $r->img_id ?><br />
            title: <?= $r->title ?><br />
            description: <?= $r->description ?><br />
            prep time: <?= $r->prep_time ?><br />
            cook time: <?= $r->cook_time ?><br />
            dish Level: <?= $r->dishes_lvl ?><br />
            ingredients Level: <?= $r->ingred_lvl ?><br />
            difficulty Level: <?= $r->diff_lvl ?><br />
            spicy level: <?= $r->spicy_lvl ?><br />
            published date: <?= $r->pub_date ?><br />
            steps: <ol>
                <?php
                $step = preg_split("/,/", $r->steps);
                foreach($step as $key => $value) {
                    echo "<li>" . $value . "</li>";
                }
                 ?>
             </ol>
        </div>
        <form method="post" action="_addRecipe.php" />
            <input type="submit" id="add" name="add" value="Add Recipe" />
        </form>
        <br />
    <?php endforeach ?>
</main>





<?php
include '../pages/_footer.php';
?>
