<?php
session_start();
$pageTitle = "Login/Register";
require_once 'partial/_header.php';
require_once '../models/db.php'; //Database Class file
require_once '../models/profile.php'; //Profile Logic file
require_once '../models/validation.php'; //Validation Library File
$db = Database::getDb();
$p = new Profile();

?>
<link rel="stylesheet" type="text/css" href="../assets/css/whatsCooking.css"/>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/css/bootstrap-slider.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/bootstrap-slider.min.js"></script>
</head>

<?php
require_once 'partial/_mainnav.php';
?>
<main class="container ddwrapper  mb-5">

<h2>My Recipes</h2>
            <div class="row">
			<?php
			$yourRecipes = $p->userRecipes($db, $_SESSION['user_id']);
			foreach($yourRecipes as $recipe)
			{

				$totalRecipe = $p->recipeById($db, $recipe->id);
				?>
				<div class="gallery-item col-sm-12 col-lg-12 text-center">
					<div class="row">
						<div class="gallery-item col-sm-6 col-lg-3 text-center">
							<img src="<?php echo $totalRecipe->img_src; ?>" alt="Image of <?php echo $totalRecipe->title; ?>" class="img-fluid rounded"/>
						</div>
						<div class="gallery-item col-sm-6 col-lg-3 text-center">
							<a href="recipes.php?&id=<?php echo $recipe->id ?>"><h3><?php echo $totalRecipe->title; ?></h3></a>
						</div>
					</div>
				</div>
				
			<?php	

			}
			?>
			</div>


</main>

<?php
    require_once 'partial/_footer.php';
?>
</body>
</html>