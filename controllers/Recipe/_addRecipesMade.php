<?php

include '../../validators/validation.php';
include '../../models/recipesMade.php';
include '../../models/db.php';

$validate = new Validation();
$message;

if(isset($_POST['add'])) {
    //CHECK IF EMPTY AND ASSIGN VALUES
    $id = null;
    $rid = $validate->checkAssignProperty('rid');
    $uid = $validate->checkAssignProperty('uid');
    $pDate = $validate->checkAssignProperty('pDate');

    //IF VALUES ARE VALID, ENTER INTO DATABASE
    if($validate->number($rid) && $validate->number($uid)) {
        if(!empty($pDate)) {
            try {
                // $count = $recipesMade->addRecipeMade(Database::getDb(), $id, $rid, $uid, $pDate);
                $recipesMade = new RecipesMade($id, $rid, $uid, $pDate);
                $count = addRecipeMade(Database::getDb(),$recipesMade);
                $message = "$count entry was added";
            } catch (Exception $e) {
                $message = "There was an error: " . $e->getMessage();
            }
        } else {
            $message = "Please enter a valid date";
        }
    } else {
        $message = "Please enter a valid id";
    }
}
?>

<h1>Add Record of When User Made A Recipe</h1>
 <form method="post" action="_addRecipesMade.php">
     <input type="hidden" id="id" name="id" value=""/>
     <div class="field">
         <label for="rid">Recipe Id:</label>
         <input type="number" id="rid" name="rid" value="<?php if(isset($rid)) {
             echo $rid;
         } ?>"/>
     </div>
     <div class="field">
         <label for="uid">User Id:</label>
         <input type="number" id="uid" name="uid" value="<?php if(isset($uid)) {
             echo $uid;
         } ?>"/>
     </div>
     <div class="field">
         <label for="pDate">Date User Made Recipe:</label>
         <input type="date" id="pDate" name="pDate" value="<?php if(isset($pDate)) {
             echo $pDate;
         } ?>"/>
     </div>
     <input type="submit" id="add" name="add" value="Add Record" />
     <div>
         <label><?php if(isset($message)) {
             echo $message;
         } ?>
         </label>
     </div>
 </form>
     <div>
         <a href="_allRecipesMade.php">View All Recipes</a>
    </div>
