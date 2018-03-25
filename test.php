<?php
require 'models/db.php';
// require 'models/ingredient.php';
require 'models/recipes.php';
// require 'models/recipesMade.php';

$r = new Recipes();

$totalTime = $r->totalRecipeTime(Database::getDb(), 1);


echo "<pre>";
print_r($totalTime);
echo "</pre>";

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
