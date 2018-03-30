<?php
require '../../models/db.php';
require '../../models/recipesMade.php';
require '_deleteRecipeMade.php';

$rm = new RecipesMade();

$allRecipesMade = $rm->displayAllRecipesMade(Database::getDb());

// echo "<pre>";
// print_r($allRecipesMade);
// echo "</pre>";

 ?>

 <h1>Recipes Made</h1>

<?php foreach($allRecipesMade as $arm) : ?>
    <div class="field">
        <label>id:</label>
        <?= $arm->id ?>
    </div>
    <div class="field">
        <label>recipe id:</label>
        <?= $arm->recipe_id ?>
    </div>
    <div class="field">
        <label>user id:</label>
        <?= $arm->user_id ?>
    </div>
    <div class="field">
        <label>date user made recipe:</label>
        <?= $arm->pub_date ?>
    </div>
    <form method="post" action="_addRecipesMade.php">
        <input type="submit" id="addRM" name="addRM" value="Add Recipe Made Record" />
    </form>

    <form method="post" action="_updateRecipesMade.php">
        <input type="hidden" id="upId" name="upId" value="<?= $arm->id ?>"/>
        <input type="submit" id="updateRM" name="updateRM" value="Update Recipe Made Record" />
    </form>

    <form method="post" action="">
        <input type="hidden" id="upId" name="upId" value="<?= $arm->id ?>"/>
        <input type="submit" id="deleteRM" name="deleteRM" value="Delete Recipe Made Record" />
        <label type="text" id="delMssg" name="delMssg" value="<?php if(isset($count)) {
            echo "$count . entry deleted.";
        }?>"></label>
    </form>
    <br />
<?php endforeach ?>
