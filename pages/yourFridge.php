<?php
session_start();
require_once '../models/db.php'; //Database Class file
require_once '../models/profile.php'; //Profile Logic file
require_once '../models/fridge.php'; //Profile Logic file
require_once '../models/event.php';
require_once '../models/validation.php'; //Validation Library File
$db = Database::getDb();
$f = new Fridge();
$p = new Profile();

$userProfile = $p->getProfileById($db, $_SESSION['user_id']);

$pageTitle = "$userProfile->fname 's Fridge";
require_once 'partial/_header.php';

if(isset($_POST['addFridge']))
{
	$ing = $_POST['ingredient'];
	$ingTest = Validation::validateDD($ing);
	if($ingTest != 0)
	{
		$count = $f->addFridgeItemById($db, $_SESSION['user_id'], $ing);
		if($count)
		{
			header('Location: yourFridge.php');
		}
		else
		{
			echo "Ingredient was not added";
		}
	}
}

if(isset($_POST['cleanFridge']))
{
	$passedId = $_POST['fridge_id'];
	$ing_id = $_POST['ing_id'];
	$user_id = $_POST['user_id'];
	$count = $f->deleteFridgeItemById($db, $passedId, $user_id, $ing_id);
	if($count)
	{
		header('Location: yourFridge.php');
	}
	else
	{
		echo "Ingredient was not deleted";
	}
}
?>
<link rel="stylesheet" type="text/css" href="../assets/css/profile.css"/>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/css/bootstrap-slider.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/bootstrap-slider.min.js"></script>
</head>

<?php
require_once 'partial/_mainnav.php';
?>
	<main class="container ddwrapper  mb-5">
	
	<form action="yourFridge.php" method="post" name="login">
		<div class="form-group col-lg-6 offset-lg-3">
			<h2>Add item to Fridge</h2>
			<div class="form-group">
				<label name="ingredient" for="ingredient">Select Ingredient:</label>
				<select type="text" name="ingredient" id="ingredient" class="form-control">
				<option value="">Please Select An Ingredient</option>
				<?php
					$allIngredients = $f->getIngredients($db);
					foreach($allIngredients as $ingredient)
					{
						echo "<option value='" . $ingredient->id . "'>" . $ingredient->food_name . "</option>";
					}
				?>
				</select>
				<label name="err_ingredient" for="ingredient" id="err_ingredient"></label>
			</div>
			<div class="form-group">
				<button type="submit" name="addFridge" for="fridge" class="form-control">Add Ingredient</button>
			</div>
		</div>
	</form>
		<div class="form-group col-lg-6 offset-lg-3">
			<h2>All your fridge items</h2>
			<div class="form-group">
				<table>
					<tr>
						<th>Ingredient</th>
						<th></th>
					</tr>
				<?php
					$allFridgeItems = $f->getAllFridgeById($db, $_SESSION['user_id']);
					
					foreach($allFridgeItems as $fitems)
					{
						echo "<tr><td>" . $fitems['food_name'] . "</td><td><form action='yourFridge.php' method='post' name='cleanFridge'><input type='hidden' name='fridge_id' value='" . $fitems['0'] . "'><input type='hidden' name='user_id' value='" . $_SESSION['user_id'] . "'><input type='hidden' name='ing_id' value='" . $fitems['ing_id'] . "'><input type='submit' class='btn btn-default' name='cleanFridge' value='Remove' /></form></td></tr>";
					}
				?>
				</table>
				<label name="err_ingredient" for="ingredient" id="err_ingredient"></label>
			</div>
		</div>
	
		<div class="form-group col-lg-6 offset-lg-3">
			<h2>Fridge history</h2>
			<div class="form-group">
				<table>
					<tr>
						<th>Ingredient</th>
						<th>Date</th>
						<th>Status</th>
					</tr>
				<?php
					$allHistoryItems = $f->getAllFridgeHistoryById($db, $_SESSION['user_id']);

					foreach($allHistoryItems as $histitems)
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
				?>
				</table>
			</div>
		</div>
	</main>

<?php
require_once 'partial/_footer.php';
?>
</body>
</html>