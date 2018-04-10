<?php
require_once 'database.php';
require_once 'comment.php';
    if (isset($_POST['add'])){
        $recipeId = $_POST['recipeIdInput'];
        $userId = $_POST['userIdInput'];
        $comment = $_POST['commentInput'];
        $db = Database::getDb();
        $c = new Comment();
        $count = $c->addComment($db, $recipeId, $userId, $comment);
        if ($count) {
            header('Location: listComments.php');
        } else {
            echo "Problem Adding.";
        }
    }
?>

<h2>Add Comment</h2>
<form action="" method="post">
    recipe id: <input type="number" name="recipeIdInput" /></br>
    user id: <input type="number" name="userIdInput" /></br>
    comment: <input type="text" name="commentInput" /> </br>
    <input type="submit" name="add" value="Add Comment"/>
</form>
