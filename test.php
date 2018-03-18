<?php
require 'models/db.php';
require 'models/ingredient.php';

<<<<<<< HEAD
// $ing = new Ingredient();
=======
>>>>>>> eada38bfeb28d957422e0b539fc4ba9718b83e00
$result = Ingredient::displayAllIngredients(Database::getDb());

echo '<pre>';
print_r($result);
echo '</pre>';

<<<<<<< HEAD

 ?>

<!DOCTYPE html>
<html>
  <head>
    <title>Test Page</title>
  </head>
  <body>
=======
 ?>


<?php $pageTitle = "Intro Test";//Page title value used by the included _header.php file
include 'pages/_header.php'?>
>>>>>>> eada38bfeb28d957422e0b539fc4ba9718b83e00
    <main>
      <h1>Hello World</h1>
      <h2>Hello Paul</h2>
      <h3>Paul is my hero</h3>
    </main>
<<<<<<< HEAD
    <footer></footer>
  </body>
=======
<?php include 'pages/_footer.php'?>
</body>
>>>>>>> eada38bfeb28d957422e0b539fc4ba9718b83e00
</html>
