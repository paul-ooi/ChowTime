<?php
require 'models/db.php';
require 'models/ingredient.php';

// $ing = new Ingredient();
$result = Ingredient::displayAllIngredients(Database::getDb());

echo '<pre>';
print_r($result);
echo '</pre>';


 ?>

<!DOCTYPE html>
<html>
  <head>
    <title>Test Page</title>
  </head>
  <body>
    <main>
      <h1>Hello World</h1>
      <h2>Hello Paul</h2>
      <h3>Paul is my hero</h3>
    </main>
    <footer></footer>
  </body>
</html>
