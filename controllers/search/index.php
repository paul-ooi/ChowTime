<?php
//if someone accesses this page with out actually searching for something it will redirect to the main home page
// if (!isset($_GET['action'])) {
//     header("Location: ./index.php");
// }

require_once '../../models/recipeDB.php';//use Jessica's RecipeDB model
require_once '../../models/db.php';
$db = Database::getDb();

var_dump($_GET);
switch($_GET['action']) {
    case ('searchKey'):
        $searchParam = $_GET['phrase'];
        echo "inside searchKey";
        $results = RecipeDb::getRecipeDetailsByTitle($searchParam);
        print_r($results);
        break;
}


 ?>

<ul>
    <?php foreach ($results as $key => $r) {?>
    <li class="recipe-item row col-12">
        <div class="timer-name col-3"><?php echo $t->t_name ?></div>
        <?php if (empty($t->remainder)) {
            $tValue = TimerDB::getTimerValues($t->set_time);
        } else if ($t->set_time >= $t->remainder) {
            $tValue = TimerDB::getTimerValues($t->remainder);
        } ?>
        <div class="timer-value col-3">
            <h4>
                <span class="hours"><?php echo $tValue['hh'] ?></span><sub>H</sub>:
                <span class="minutes"><?php echo $tValue['mm'] ?></span><sub>M</sub>:
                <span class="seconds"><?php echo $tValue['ss'] ?></span><sub>S</sub>
            </h4>
        </div>
        <div class="col-6">
            <button name="startTimer" class="start-time btn timer-btn col-3">Start</button>
            <button name="stopTimer" class="hidden stop-time timer-btn btn col-3">Stop</button>
            <button name="deleteTimer" class="del-time btn timer-btn col-3">Remove</button>
        </div>
    </li>
<?php }//End of FOREACH to list Timers?>
</ul>
