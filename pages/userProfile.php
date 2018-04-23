<?php
$pageTitle = "User Profile";
require_once 'partial/_header.php';
require_once 'db.php'; //Database Class file
require_once 'profile.php'; //Profile Logic file
require_once 'validation.php'; //Validation Library File

$db = Database::getDb();
$p = new Profile();

//an ID will be passed from the previous page
//$aUsersId = xxxxxx;

$testID = 11;

?>
<link rel="stylesheet" type="text/css" href="../assets/css/whatsCooking.css"/>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/css/bootstrap-slider.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/bootstrap-slider.min.js"></script>
<script src="../assets/js/whatsCooking.js"></script>
</head>

<?php
require_once 'partial/_mainnav.php';
require_once 'Whats-cooking.php';
?>
	<main class="container ddwrapper  mb-5">
		<section class="mx-auto text-center text-md-left" id="top-category">
            <div class="row">
            <div class="gallery-item col-sm-6 col-lg-4 text-center">
                <img src="../assets/imgs/image1.jpg" alt="plate of spaghetti" class="img-fluid rounded"/>
            </div>
            <div class="gallery-item col-sm-6 col-lg-4 text-left">
				<div class="sm-1 lg-1 text-left">
					<h3>Person Name</h3>
				</div>
				<div>
					<p>Address</p>
					<p>Address</p>
				</div>
				<div>
					<p>Peferences</p>
				</div>
            </div>
            <div class="gallery-item col-sm-6 col-lg-4 text-center">
                <div class="sm-1 lg-1 text-left">
					<h3>Cooking Equipment</h3>
				</div>
            </div>
		</section>
		<hr/>
        <section class="mx-auto text-center text-md-left" id="top-category">
            <h2>My Recipes</h2>
            <div class="row">
            <div class="gallery-item col-sm-6 col-lg-3 text-center">
                <a href="index.php"><h3>Recipe Name</h3><img src="../assets/imgs/image1.jpg" alt="plate of spaghetti" class="img-fluid rounded"/></a>
            </div>
            <div class="gallery-item col-sm-6 col-lg-3 text-center">
                <a href="index.php"><h3>Recipe Name</h3><img src="../assets/imgs/image1.jpg" alt="plate of spaghetti" class="img-fluid rounded"/></a>
            </div>
            <div class="gallery-item col-sm-6 col-lg-3 text-center">
                <a href="index.php"><h3>Recipe Name</h3><img src="../assets/imgs/image1.jpg" alt="plate of spaghetti" class="img-fluid rounded"/></a>
            </div>
			<div class="gallery-item col-sm-6 col-lg-3 text-center">
                <a href="index.php"><h3>Recipe Name</h3><img src="../assets/imgs/image1.jpg" alt="plate of spaghetti" class="img-fluid rounded"/></a>
            </div>
			</div>
		</section>
		<hr/>
		<section class="mx-auto text-center text-md-left" id="top-category">
            <h2>Recent Recipes</h2>
            <div class="row">
            <div class="gallery-item col-sm-6 col-lg-3 text-center">
                <a href="index.php"><h3>Recipe Name</h3><img src="../assets/imgs/image1.jpg" alt="plate of spaghetti" class="img-fluid rounded"/></a>
            </div>
            <div class="gallery-item col-sm-6 col-lg-3 text-center">
                <a href="index.php"><h3>Recipe Name</h3><img src="../assets/imgs/image1.jpg" alt="plate of spaghetti" class="img-fluid rounded"/></a>
            </div>
            <div class="gallery-item col-sm-6 col-lg-3 text-center">
                <a href="index.php"><h3>Recipe Name</h3><img src="../assets/imgs/image1.jpg" alt="plate of spaghetti" class="img-fluid rounded"/></a>
            </div>
			<div class="gallery-item col-sm-6 col-lg-3 text-center">
                <a href="index.php"><h3>Recipe Name</h3><img src="../assets/imgs/image1.jpg" alt="plate of spaghetti" class="img-fluid rounded"/></a>
            </div>
		</section>
	</main>

<?php
    require_once 'partial/_footer.php';
?>
</body>
</html>