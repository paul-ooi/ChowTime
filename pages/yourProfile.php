<?php
session_start();
require_once '../models/db.php'; //Database Class file
require_once '../models/profile.php'; //Profile Logic file
require_once '../models/recipesMade.php'; //Profile Logic file
require_once '../models/recipeDB.php'; //Profile Logic file
require_once '../models/validation.php'; //Validation Library File
$db = Database::getDb();
$p = new Profile();


$userProfile = $p->getProfileById($db, $_SESSION['user_id']);

$pageTitle = "$userProfile->fname 's Profile";
require_once 'partial/_header.php';
?>
<link rel="stylesheet" type="text/css" href="../assets/css/profile.css"/>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/css/bootstrap-slider.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/bootstrap-slider.min.js"></script>
</head>

<?php
require_once 'partial/_mainnav.php';
?>
	<main class="container ddwrapper  mb-5">
		<section class="mx-auto text-center text-md-left" id="top-category">
            <div class="row">
            <div class="gallery-item col-sm-6 col-lg-4 text-center">
                <img src="<?php echo $userProfile->pimage ?>" alt="<?php echo $userProfile->fname ?>'s profile picture" class="img-fluid rounded" id="profilePicture"/>
            </div>
            <div class="gallery-item col-sm-6 col-lg-4 text-left">
				<div class="sm-1 lg-1 text-left">
					<h3><?php echo $userProfile->fname . " " . $userProfile->lname;?></h3>
				</div>
				<div>
					<p><?php echo $userProfile->address1 ?></p>
				</div>
				<div>
					<a href="editProfile.php"><p>Edit Profile</p></a>
				</div>
            </div>
			<div class="gallery-item col-sm-6 col-lg-4 text-left">
				Google Maps inc.
            </div>
		</section>
		<hr/>
        <section class="mx-auto text-center text-md-left" id="top-category">
            <h2>My Recipes</h2>
            <div class="row">
			<?php
			$yourRecipes = $p->userRecipes($db, $_SESSION['user_id']);
			$amountOfYourRecipes = count($yourRecipes);
			$diff = $amountOfYourRecipes - 4;
			$count = 0;
			foreach($yourRecipes as $recipe)
			{
				$totalRecipe = $p->recipeById($db, $recipe->id);
				?>
				<div class="gallery-item col-sm-6 col-lg-3 text-center">
					<a href="recipes.php?&id=<?php echo $recipe->id ?>"><h3><?php echo $totalRecipe->title; ?></h3><img src="<?php echo $totalRecipe->img_src; ?>" alt="Image of <?php echo $totalRecipe->title; ?>" class="img-fluid rounded"/></a>
				</div>
			<?php	
			}
			?>
			</div>
			<?php
			if($amountOfYourRecipes > 4)
			{
			?>
			<div class="row">
				<div class="form-group col-lg-6 offset-lg-6 text-right">
					<a href="">See all of your recent recipes</a>
				</div>				
			</div>
			<?php
			}
			?>
		</section>
		<hr/>
		<section class="mx-auto text-center text-md-left" id="top-category">
            <div class="row"> <!--../assets/imgs/eventplaceholder.png-->
            <div class="gallery-item col-sm-6 col-lg-4 text-center">
                <a href="../controllers/events/allEvents.php"><h3>Upcoming Events</h3><p>Events that you are registered to attend</p>
            </div>
            <div class="gallery-item col-sm-6 col-lg-4 text-center">
                <a href="index.php"><h3>Your Events</h3><p>Events that you are hosting</p>
            </div>
            <div class="gallery-item col-sm-12 col-lg-4 text-center">
                <a href="index.php"><h3>My Food</h3></a>
				Fridge feature
            </div>
		</section>
		<hr/>
		<section class="mx-auto text-center text-md-left" id="top-category">
            <h2>Recent Recipes</h2>
            <div class="row">
            <?php
			$userRecipes = $p->usersRecipeMade($db, $_SESSION['user_id']);
			$amountOfRecipes = count($userRecipes);
			$diff = $amountOfRecipes - 4;
			$count = 0;
			foreach($userRecipes as $recipe)
			{
				if($count >= $diff)
				{
					$totalRecipe = $p->recipeById($db, $recipe->recipe_id);
					?>
					<div class="gallery-item col-sm-6 col-lg-3 text-center">
						<a href="recipes.php?&id=<?php echo $recipe->recipe_id ?>"><h3><?php echo $totalRecipe->title; ?></h3><img src="<?php echo $totalRecipe->img_src; ?>" alt="plate of spaghetti" class="img-fluid rounded"/></a>
					</div>
				<?php
				}
				$count++;
			}
			?>
            </div>
			<?php
			if($amountOfRecipes > 4)
			{
			?>
			<div class="row">
				<div class="form-group col-lg-6 offset-lg-6 text-right">
					<a href="">See all of your recent recipes</a>
				</div>				
			</div>
			<?php
			}
			?>
		</section>
	</main>

<?php
    require_once 'partial/_footer.php';
?>
</body>
</html>