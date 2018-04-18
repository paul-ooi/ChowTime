<?php
require_once '../models/comment.php';
$c = new Comment;

if (isset($_POST['add'])){
    $recipeId = $_POST['recipeIdInput'];
    $userId = $_POST['userIdInput'];
    $comment = $_POST['commentInput'];
    $count = $c->addComment($db, $recipeId, $userId, $comment);
    if (!$count) {
        echo "Problem Adding.";
    }
}

// FOR TESTING PURPOSES
$user_Id = 1;
$recipe_Id = 1;
?>

<section id="commentBox">
        <h2>Add Comment</h2>
        <form action="" method="post">
            <div>
                <textarea class="form-control" name="commentInput" rows="4"></textarea>
            </div>
            <div>
                <input type="hidden" name="userIdInput" value="<?php echo $user_Id; ?>" />
                <input type="hidden" name="recipeIdInput" value="<?php echo $recipe_Id; ?>" />
                <input type="submit" class="btn btn-default" name="add" value="Post" />
            </div>
        </form>
</section>
