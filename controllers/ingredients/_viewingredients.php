<?php
require_once '../models/db.php';
require_once '../models/ingredient.php';


$errorRecipeId = "";
$r_id = 0;
$db = Database::getDb();
$ing = new Ingredient();
$rList = $ing->getRecipeTitles($db);



if (!isset($_POST['recIngred'])) {
    $showIngredients = "";
} else {

    $r_id = intval($_POST['recipe_id']);
    if ($r_id == 0) {
        $errorRecipeId = "Invalid Recipe Selection";
    } else {

        $iList = $ing->getRecipeIngredients($db, $r_id);

        //Check if the recipe is empty, without ingredients
        if (!$iList) {
            $showIngredients = "<p>Receipe currently has no ingredients</p>";
            $recipeName = 'this';
        } else {
            $showIngredients = '<h2>Ingredients for '. $iList[0]->title . '</h2>';

            //Build List of ingredients
            $ingredList = '<ul>';
            foreach ($iList as $key => $item) {
                $ingredList .= '<li class="i_item">';

                // Add Edit and Remove buttons to the Ingredient Item
                $editForm = '<form class="form_button" action="_editingredient.php" method="post">
                <input type="hidden" name="update_ing_id" value="'.$item->ing_id.'"/>'.
                '<input type="submit" name="updateIngred" value="Edit"/></form>';

                $deleteForm = '<form class="form_button" action="_deleteingredient.php" method="post">
                <input type="hidden" name="del_ing_id" value="'.$item->ing_id.'"/>'.
                '<input type="submit" name="deleteIngred" value="Remove"/></form>';

                $ingredList .= $editForm . $deleteForm;

                //Add Optional tag if the ingredient is Optional
                if ($item->required == 0) {
                    $ingredList .= '<small>Optional</small>' . ' ';
                }
                $ingredList .=  $item->quantity . ' ' . $item->unit . ' ' . $item->prep . ' ' . $item->food_name;
                $ingredList .= '</li>';
            }
            $ingredList .= '</ul>';

            //Assign ingredients to variable for output
            $showIngredients .= $ingredList;
            $recipeName = $iList[0]->title;
        }

    }
}

// Build Drop down Recipe options with the post value selected
$ddRecipeOptions = "";
foreach ($rList as $key => $recipe) {
    $ddRecipeOptions .= '<option value="' . $recipe->id . '"';
    if ($recipe->id == $r_id) {
        $ddRecipeOptions .= ' selected ';
        $ing->setRecipeRef($recipe->id);
    }
    $ddRecipeOptions .= '>' . $recipe->title . '</option>';
}

if (isset($_POST['recIngred'])) {
    //Add New Ingredient to this recipe - Button
    $addToRecipe = '<form class="form_button" action="_addingredient.php" method="post">
    <input type="hidden" name="add_ing_rec_id" value="'.$ing->getRecipeRef().'"/>'.
    '<input type="submit" name="addIngred" value="Add Ingredient to '. $recipeName . ' Recipe"/></form>';

    $showIngredients .= $addToRecipe;
}


$pageTitle = "Show Ingredients";
require_once '_header.php';
?>
<header>
    <h1>Ingredients Function</h1>
    <nav>
        <ul>
            <li><a href="_viewingredients.php">View</a></li>
            <li><a href="_addingredient.php">Add New Ingredient</a></li>
        </ul>
    </nav>
</header>
<main>
    <form action="_viewingredients.php" method="post" name="viewRecIng">
            <label class="ingred_form_label ingred_form_label_small" for="recipe_id">Show Ingredients for: </label>
            <select type="text" name="recipe_id" id="recipe_id">
                <option value="">--Select Recipe--</option>
                <?php echo $ddRecipeOptions ?>
            </select>
            <input class="form_button" type="submit" name="recIngred" for="viewRecIng" value="Show Ingredients" />
            <label class="error" for="name" name="recipe_id"><?php echo htmlspecialchars($errorRecipeId); ?></label>
    </form>
    <section id="ingredients">
        <?php echo $showIngredients ?>
    </section>
</main>
<footer>
    &copy; Paul Ooi - Lab 6
</footer>
</body>
</html>
