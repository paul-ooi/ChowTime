<?php
require_once '../models/comment.php';
//require_once '../../models/profile.php';
$c = new Comment;


// FOR TESTING PURPOSES
$recipe_id = 1;

// Default Form Tag stuff
$class = '';
$input_type = 'hidden';
$upd = 'update';

// Update Comments
if (isset($_POST['update'])){
    // Hide <p> tag and reveal textarea input
    $class = 'hidden';
    $input_type = 'textarea';
    $upd = 'upd'; // Alter the button for updating the comment

    $id = $_POST['id'];
    $com = $c->getCommentById($db, $id);
}

if (isset($_POST['upd'])){
    // Change the tags back to original upon save
    $class = '';
    $input_type = 'hidden';
    $upd = 'update';

    $id = $_POST['id'];
    $comment = $_POST['comment'];
    $count = $c->updateComment($db, $id, $comment);

    // If there's a problem with the update, display error message
    if (!$count){
        echo "Problem Updating.";
    }
}

// Delete Comment
if (isset($_POST['delete'])){
    $id = $_POST['id'];
    $count = $c->deleteComment($db, $id);

    if (!$count){
        echo "Problem Deleting";
    }
}
?>

<h3>Comments</h3>
    <?php
    $comments = $c->getRecipeComments($db, $recipe_id);

    foreach ($comments as $cm) {
        //$user = getProfileById($db, $cm->user_id);

        echo '<div class="media">
        <img class="align-self-start mr-3" src="..." alt="">
        <div class="media-body">';
        // TO BE ALTERED TO OUTPUT THE USER'S FIRST AND LAST NAME
        echo '<p><b>' . /*$user->fname . ' ' . $user->lname .*/ '</b></p>';
        // For users who are logged in to edit and delete these comments
        // if (isset($_SESSION['user_id'])){
            // if ($_SESSION['user_id'] == $cm->user_id){
                echo '<form action="" method="post">
                <p class="' . $class . '">' . $cm->comment . '</p>
                <input type="hidden" name="id" value="' . $cm->id . '" />
                <input type="' . $input_type . '" name="comment" value="' . $cm->comment . '" rows="3"/>
                <input type="submit" name="' . $upd . '" value="Update"/>
                </form>
                <form action="" method="post">
                <input type="hidden" name="id" value="' . $cm->id . '"/>
                <input type="submit" name="delete" value="Delete"/>
                </form>';
            // } // End of Current User Check
            // else {
                // echo '<p>' . $cm->comment . '</p>';
            // }
        // } else {
            echo '<p>' . $cm->comment . '</p>';
        // }
        echo '<p class="comment_date"><i>' . $cm->date . '</i></p></div></div>';
    }
?>
