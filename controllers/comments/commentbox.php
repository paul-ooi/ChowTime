<?php
require_once '../models/comment.php';
require_once '../models/profile.php';
require_once '../models/likesDislikes.php';
$c = new Comment;
$p = new Profile;
$l = new LikesDislikes;

// COMMUNITY RATING SYSTEM
$like_class = "";
$dislike_class = "";
// Checking # of likes/dislikes
$likes = $l->getLikesByRecipe($db, $recipe_id);
$dislikes = $l->getDislikesByRecipe($db, $recipe_id);

// COMMENTS
// Default Form Tag stuff
$class = "";
$input_type = 'hidden';
$upd = 'update';
$edit = '<i class="fas fa-edit"></i>';


// Adding a comment
if (isset($_POST['add'])){
    $recipeId = $_POST['recipeIdInput'];
    $userId = $_SESSION['user_id'];
    $comment = $_POST['commentInput'];
    $count = $c->addComment($db, $recipeId, $userId, $comment);
    if (!$count) {
        echo "Problem Adding.";
    }
}

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

// Only Show if user is logged in
if (isset($_SESSION['user_id'])) {

    // Checking for Likes/Dislikes
    $check_e_like = $l->checkUserLikeRecipe($db, $recipe_id, $_SESSION['user_id']);
    $check_e_dislike = $l->checkUserDisLikeRecipe($db, $recipe_id, $_SESSION['user_id']);

    // When User clicks on Like button
    if (isset($_POST['like'])){
        $check_e_like = $l->checkUserLikeRecipe($db, $recipe_id, $_SESSION['user_id']);
        $check_e_dislike = $l->checkUserDisLikeRecipe($db, $recipe_id, $_SESSION['user_id']);

        // if user liked the comment already
        if ($check_e_like != null) {
            $l->deleteLikeRecipe($db, $recipe_id, $_SESSION['user_id']);
        } else if ($check_e_like == null && $check_e_dislike == null) {
            $l->addLikeRecipe($db, $recipe_id, $_SESSION['user_id']);
        } else if($check_e_like == null && $check_e_dislike != null) {
            $l->deleteDisikeRecipe($db, $recipe_id, $_SESSION['user_id']);
            $l->addLikeRecipe($db, $recipe_id, $_SESSION['user_id']);
        }

        $likes = $l->getLikesByRecipe($db, $recipe_id);
        $dislikes = $l->getDislikesByRecipe($db, $recipe_id);
    }

    if (isset($_POST['dislike'])){
        $check_e_like = $l->checkUserLikeRecipe($db, $recipe_id, $_SESSION['user_id']);
        $check_e_dislike = $l->checkUserDisLikeRecipe($db, $recipe_id, $_SESSION['user_id']);

        if ($check_e_dislike != null) {
            $l->deleteDisikeRecipe($db, $recipe_id, $_SESSION['user_id']);
        } else if ($check_e_dislike == null && $check_e_like == null) {
            $l->addDislikeRecipe($db, $recipe_id, $_SESSION['user_id']);
        } else if ($check_e_dislike == null && $check_e_like != null) {
            $l->deleteLikeRecipe($db, $recipe_id, $_SESSION['user_id']);
            $l->addDislikeRecipe($db, $recipe_id, $_SESSION['user_id']);
        }

        $likes = $l->getLikesByRecipe($db, $recipe_id);
        $dislikes = $l->getDislikesByRecipe($db, $recipe_id);
    }
?>

<section id="commentBox">
        <h2>Add Comment</h2>
        <form action="" method="post">
            <div>
                <textarea class="form-control" name="commentInput" rows="4"></textarea>
            </div>
            <div>
                <input type="hidden" name="recipeIdInput" value="<?php echo $recipe_id; ?>" />
                <input type="submit" class="btn btn-default" name="add" value="Post" />
            </div>
        </form>
</section>
<?php }

 echo '<h3>Comments</h3>';
    $comments = $c->getRecipeComments($db, $recipe_id);
    if ($comments == null) {
        echo '<p> There are no comments yet. </p>';
    }
    foreach ($comments as $cm) {
        $user = $p->getProfileById($db, $cm->user_id);

        echo '<div class="media">';
        echo '<div class="media-left">';
            echo '<form action="../../pages/yourProfile.php">';
                echo '<img class="media-object rounded-circle" src="" alt="" >'; // src="to be added" alt ="' . $user->fname . ' ' . $user->lname . 'profile picture"
            echo '</form>';
        echo '</div>'; // End of media-left

        echo  '<div class="media-body">';

        echo '<button class="comProfile" name="user_id" value="'. $cm->user_id .'"><span><u>' . $user->fname . ' ' . $user->lname . '</u></span></button>';
        // For users who are logged in to edit and delete these comments
        if (isset($_SESSION['user_id'])){
             if ($_SESSION['user_id'] == $cm->user_id){
                echo '<form action="" method="post">
                <div class="row">
                <div class="col">
                    <span class="' . $class . '">' . $cm->comment . '</span>
                    <input type="hidden" name="id" value="' . $cm->id . '" />
                    <input type="' . $input_type . '" class="form-control" name="comment" value="' . $cm->comment . '" rows="3"/>
                </div>
                <div class="col-md-auto col-sm-auto">
                    <button type="submit" class="btn btn-outline-info" name="' . $upd . '">' . $edit . '</button>
                    <button type="submit" class="btn btn-outline-danger" name="delete"><i class="fas fa-trash-alt"></i></button>
                </div>
                </div>
                </form>';
             } // End of Current User Check
             else {
                 echo '<div><span>' . $cm->comment . '</span></div>';
             }
         } else {
            echo '<div><span>' . $cm->comment . '</span></div>';
         }
        echo '<div><span><i>Posted on ' . $cm->date . '</i></span></div></div></div>';
        }
?>
