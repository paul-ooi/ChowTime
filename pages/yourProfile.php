<?php
session_start();
require_once '../models/db.php'; //Database Class file
require_once '../models/profile.php'; //Profile Logic file
require_once '../models/fridge.php'; //Profile Logic file
require_once '../models/event.php';
require_once '../models/validation.php'; //Validation Library File
$db = Database::getDb();
$p = new Profile();
$e = new Event();
$f = new Fridge();

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
					<a href="timers.php"><p>View your timers</p></a>
				</div>
				<div>
					<a href="editProfile.php"><p>Edit Profile</p></a>
				</div>
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
                if($count >= $diff)
				{
                    $totalRecipe = $p->recipeById($db, $recipe->id);
                    ?>
                    <div class="gallery-item col-sm-6 col-lg-3 text-center">
                        <a href="recipes.php?&id=<?php echo $recipe->id ?>"><h3><?php echo $totalRecipe->title; ?></h3><img src="<?php echo $totalRecipe->img_src; ?>" alt="Image of <?php echo $totalRecipe->title; ?>" class="img-fluid rounded"/></a>
                    </div>
			<?php	
                }
                $count++;
			}
			?>
			</div>
			<div class="row">
				<div class="form-group col-lg-6">
					<a href="../pages/makeRecipe.php">Create new recipe</a>
				</div>
			<?php
			if($amountOfYourRecipes > 4)
			{
			?>
			
				<div class="form-group col-lg-6 offset-lg-6 text-right">
					<a href="allYourRecipes.php">See all of your recipes</a>
				</div>				
			</div>
			<?php
			}
			?>
		</section>
		<hr/>
		<?php 
			$attendingEvents = $e->eventsAttending($db, $_SESSION['user_id']);
			
			$howManyAttending = count($attendingEvents);
		?>
		<section class="mx-auto text-center text-md-left" id="top-category">
            <div class="row">
            <div class="gallery-item col-sm-6 col-lg-4 text-center">
                <h3>Upcoming Events</h3>
				<?php
					if($howManyAttending == 0)
					{
						echo "<a href='../controllers/events/allEvents.php'><p>You aren't currently attending any events, click here to find some upcoming events</p></a>";
					}
					else
					{
						$count = 0;
						foreach($attendingEvents as $event)
						{
							$attendEventInfo = $e->getEventByStartDate($db, $event->event_id);
							foreach($attendEventInfo as $atevent)
							{
								if($count < 1)
								{
									echo '<a href="../controllers/events/details.php?event_id=' . $atevent->id . '">';
									echo "<h4>" . $atevent->event_name . "</h4>";
									echo $atevent->event_location . '<br/>';
									echo date("D, F d, Y", strtotime($atevent->date)) . '<br/>';
									echo 'at ' . date("g:i A", strtotime($atevent->start_time)) . '<br/>';
									echo "</a>";
								}
								$count++;
							}
							
						}
						?>
						<a href="../controllers/events/allEvents.php">View all events</a>
						<?php
					}
				?>
            </div>
			<?php 
			$allMyEvents = $e->myEventsByStartDate($db, $_SESSION['user_id']);
			
			$howManyEvents = count($allMyEvents);
			?>
            <div class="gallery-item col-sm-6 col-lg-4 text-center">
                <h3>Your Events</h3>
				<?php
					if($howManyEvents == 0)
					{
						echo "<a href='../pages/events.php'><p>You aren't currently hosting any events, click here to create some upcoming events</p></a>";
					}
					else
					{
						$count = 0;
						foreach($allMyEvents as $event)
						{
							if($count < 1)
							{
								echo '<a href="../controllers/events/details.php?event_id=' . $event->id . '">';
								echo "<h4>" . $event->event_name . "</h4>";
								echo $event->event_location . '<br/>';
								echo date("D, F d, Y", strtotime($event->date)) . '<br/>';
								echo 'at ' . date("g:i A", strtotime($event->start_time)) . '<br/>';
								echo "</a>";
							}
							$count++;							
						}
						?>
						<a href="../controllers/events/allEvents.php">View your events</a>
						<?php
					}
				?>
            </div>
			<?php 
				$allHistoryItems = $f->getAllFridgeHistoryById($db, $_SESSION['user_id']);
					
				$howManyHistory = count($allHistoryItems);
			?>
            <div class="gallery-item col-sm-12 col-lg-4 text-center">
                <a href="yourFridge.php"><h3>My Food</h3></a>
				<?php
				if($howManyHistory == 0)
				{
					echo "<a href='../pages/yourFridge.php'><p>You don't currently have any items in your fridge, clear here to add some!</p></a>";
				}
				else
				{
				?>
				<table>
					<tr>
						<th>Ingredient</th>
						<th>Date</th>
						<th>Status</th>
					</tr>
				<?php
					
					$diff = $howManyEvents - 4;
					foreach($allHistoryItems as $histitems)
					{
						if($count >= $diff)
						{
							if($histitems['last_trans'] == 1)
							{
								echo "<tr><td>" . $histitems['food_name'] . "</td><td>" . date("D, F d, Y", strtotime($histitems['pubdate'])) . "</td><td style='color:green;'>Added</td></tr>";
							}
							else
							{
								echo "<tr><td>" . $histitems['food_name'] . "</td><td>" . date("D, F d, Y", strtotime($histitems['pubdate'])) . "</td><td style='color:red;'>Removed</td></tr>";
							}
						}
						$count++;
					}
				?>
				</table>
				<?php
				}
				?>
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
					<a href="allMadeRecipes.php">See all of your recent recipes</a>
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