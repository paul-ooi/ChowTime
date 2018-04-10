<?php
require_once '../../models/db.php';
require_once '../../models/comment.php';

$c = new Comment;
$db = Database::getDb();

$recipes = $c->getUniqueRecipe($db);


// Update Comments
if (isset($_POST['update'])){
    // Form tag stuff
    $class = 'hidden';
    $input_type = 'textarea';
    // db stuff
    $id = $_POST['id'];

    $com = $c->getCommentById($db, $id);
    var_dump($com);
}

if (isset($_POST['upd'])){
    // Form tag stuff
    $class = '';
    $input_type = 'hidden';
    // db stuff
    $id = $_POST['id'];
    $comment = $_POST['comment'];
    $count = $c->updateComment($db, $id, $comment);

    if ($count){
        header('Location: listComments.php');
    } else {
        echo "Problem Updating.";
    }
}
?>

<h2>Comments</h2>
<form action="" method="post">
    <?php
    //if(isset($_POST['sub'])){
        //$recipeId = $_POST['recipes'];
        $recipe_event = 'recipe';
        $recipe_event_id = 1;
        
        $comments = $c->getRecipeEventComments($db, $recipe_event, $recipe_event_id);
        foreach ($comments as $cm) {
            echo '<div class="media">
                    <img class="align-self-start mr-3" src="..." alt="THIS NEEDS TO CHANGE TO DATABASE STUFF">
                    <div class="media-body">
                        <p><b>' . $cm->user_id . '</b></p>';
            if ($_SESSION['user_id'] == $cm->user_id){
                echo '<form action="updateComment.php" method="post">
                        <p class="' . $class . '">' . $cm->comment . '</p>
                        <input type="' . $input_type . '" name="id" value="' . $cm->id . '" rows="3"/>
                        <input type="submit" name="update" value="Update"/>
                    </form>
                    <form action="deleteComment.php" method="post">
                      <input type="hidden" name="id" value="' . $cm->id . '"/>
                      <input type="submit" name="delete" value="Delete"/>
                    </form>';
            } else {
                echo ;
            }
            echo '<p class="comment_date"><i>' . $cm->date . '</i></p></div></div>';
    //}
    ?>
</form>
