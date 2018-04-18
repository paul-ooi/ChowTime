<?php
session_start();
$pageTitle = "User Profile";
require_once 'partial/_header.php';
require_once 'db.php'; //Database Class file
require_once 'profile.php'; //Profile Logic file
require_once 'validation.php'; //Validation Library File

$db = Database::getDb();
$p = new Profile();

$userProfile = $p->getProfileById($db, $_SESSION['user_id']);
?>
<link rel="stylesheet" type="text/css" href="../assets/css/whatsCooking.css"/>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/css/bootstrap-slider.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/bootstrap-slider.min.js"></script>
<script src="../assets/js/whatsCooking.js"></script>
</head>

<?php
require_once 'partial/_mainnav.php';
//require_once 'Whats-cooking.php';
?>
	<main class="container ddwrapper  mb-5">
		<section class="mx-auto text-center text-md-left" id="top-category">
            <div class="row">
            <div class="gallery-item col-sm-6 col-lg-4 text-center">
                <a href="index.php"><img src="../assets/imgs/image1.jpg" alt="User Profile Image from DB" class="img-fluid rounded"/></a>
            </div>
            <div class="gallery-item col-sm-6 col-lg-4 text-left">
				<div class="sm-1 lg-1 text-left">
					<h3><?php echo $userProfile->fname . " " . $userProfile->lname;?></h3>
				</div>
				<div>
					<p><?php echo $userProfile->address1 ?></p>
				</div>
				<div>
					<p>Peferences</p>
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
            <div class="row"> <!--../assets/imgs/eventplaceholder.png-->
            <div class="gallery-item col-sm-6 col-lg-4 text-center">
                <a href="../controllers/events/allEvents.php"><h3>Events</h3><img src="eventplaceholder.png" alt="Placeholder Image of a Calendar need to talk to Sophia on how to show it." class="img-fluid rounded"/></a>
            </div>
            <div class="gallery-item col-sm-6 col-lg-4 text-center">
                <a href="index.php"><h3>Suggested</h3><p>Not sure how I'm going to do the functionality for this. Might get cut</p>
            </div>
            <div class="gallery-item col-sm-12 col-lg-4 text-center">
                <a href="index.php"><h3>My Food</h3></a>
				
					<ul>
						<a href="index.php"><li>Food Item Added: DD/MM/YYYY</li></a>
						<a href="index.php"><li>Food Item Added: DD/MM/YYYY</li></a>
						<a href="index.php"><li>Food Item Added: DD/MM/YYYY</li></a>
						<a href="index.php"><li>Food Item Added: DD/MM/YYYY</li></a>
						<a href="index.php"><li>Food Item Added: DD/MM/YYYY</li></a>
						<a href="index.php"><li>Food Item Added: DD/MM/YYYY</li></a>
						<a href="index.php"><li>Food Item Added: DD/MM/YYYY</li></a>
						<a href="index.php"><li>Food Item Added: DD/MM/YYYY</li></a>
						<p>Coming from my last feature, not fully developed yet</p>
						
					</ul>
					<a href="index.php">Full Fridge List</a>
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