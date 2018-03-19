<?php
require 'models/db.php';
// require 'models/ingredient.php';
require 'models/populateRecipes.php';

$r = new Recipes("Chicken Wings","Crispy deep fried chicken wings with over 10 different sauce recipes to toss in.", "images/photo3", "00:35:00", "2", "2", "2");
$insert = $r->addRecipe(Database::getDb());
$result = $r->displayAllRecipes(Database::getDb());


echo '<pre>';
print_r($result);
echo '</pre>';
 ?>


<?php $pageTitle = "Intro Test";//Page title value used by the included _header.php file
include 'pages/_header.php'?>
    <main>
      <h1>Hello World</h1>
      <h2>Hello Paul</h2>
      <h3>Paul is my hero</h3>
    </main>
<?php include 'pages/_footer.php'?>
</body>
</html>
