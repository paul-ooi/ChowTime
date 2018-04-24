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

$likes = $l->getLikesByRecipe($db, $recipe_id);
$dislikes = $l->getDislikesByRecipe($db, $recipe_id);

// COMMENTS
// Default Form Tag stuff
$class = "";
$input_type = 'hidden';
$upd = 'update';
$edit = '<i class="fas fa-edit"></i>';

if (isset($_POST['add'])){
    $recipeId = $recipe_id;
    $userId = $_SESSION['user_id'];
    $comment = $_POST['commentInput'];
    $count = $c->addRecipeComment($db, $recipeId, $userId, $comment);
    if (!$count) {
        echo "Problem Adding.";
    }
}

// Update Comments
if (isset($_POST['update'])){
    // Hide <p> tag and reveal textarea input
    $class = 'd-none';
    $input_type = 'textarea';
    $upd = 'upd'; // Alter the button for updating the comment
    $edit = 'Save Changes';
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

if (isset($_SESSION['user_id'])){
    // Checking for Likes/Dislikes
    $check_e_like = $l->checkUserLikeRecipe($db, $recipe_id, $_SESSION['user_id']);
    $check_e_dislike = $l->checkUserDislikeRecipe($db, $recipe_id, $_SESSION['user_id']);

    // When User clicks on Like button
    if (isset($_POST['like'])){
        $check_e_like = $l->checkUserLikeRecipe($db, $recipe_id, $_SESSION['user_id']);
        $check_e_dislike = $l->checkUserDislikeRecipe($db, $recipe_id, $_SESSION['user_id']);

        // if user liked the comment already
        if ($check_e_like != null) {
            $l->deleteLikeRecipe($db, $recipe_id, $_SESSION['user_id']);
        } else if ($check_e_like == null && $check_e_dislike == null) {
            $l->addLikeRecipe($db, $recipe_id, $_SESSION['user_id']);
        } else if($check_e_like == null && $check_e_dislike != null) {
            $l->deleteDislikeRecipe($db, $recipe_id, $_SESSION['user_id']);
            $l->addLikeRecipe($db, $recipe_id, $_SESSION['user_id']);
        }

        $likes = $l->getLikesByRecipe($db, $recipe_id);
        $dislikes = $l->getDislikesByRecipe($db, $recipe_id);
    }

    if (isset($_POST['dislike'])){
        $check_e_like = $l->checkUserLikeRecipe($db, $recipe_id, $_SESSION['user_id']);
        $check_e_dislike = $l->checkUserDislikeRecipe($db, $recipe_id, $_SESSION['user_id']);

        if ($check_e_dislike != null) {
            $l->deleteDisikRecipe($db, $recipe_id, $_SESSION['user_id']);
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
<section id="communityRate">
    <div class="wrapper">
        <form action="" method="post">
            <div class="btn-group btn-group-lg" role="group" aria-label="...">
                <!-- Like -->
                <button class="btn btn-default" type="submit" name="like"><i class="fas fa-thumbs-up"></i> <?php echo $likes[0]->count; ?></button>
                <!-- Dislike -->
                <button class="btn btn-default" type="submit" name="dislike"><i class="fas fa-thumbs-down"></i> <?php echo $dislikes[0]->count; ?></button>
            </div>
        </form>
    </div>
</section>
<section id="commentBox">
    <div class="wrapper">
        <h3>Add Comment</h3>
        <form action="details.php" method="post">
            <div>
                <textarea class="form-control" name="commentInput" rows="4"></textarea>
            </div>
            <div>
                <input type="submit" class="btn btn-default" name="add" value="Post" />
            </div>
        </form>
    </div>
</section>
<section>
<?php
}
$comments = $c->getRecipeComments($db, $recipe_id);
echo '<h3>Comments</h3>';
if ($comments == null){
    echo '<p> There are no comments yet. </p>';
}
foreach ($comments as $cm) {
    $user = $p->getProfileById($db, $cm->user_id);
    echo '<div class="media">';
    echo '<a href="userProfile.php?id=' . $user->id . '">';
        echo '<div class="media-left rounded-circle" style="height: 75px; width: 75px;background-image: url(../' . $user->pimage .'); background-size: cover; background-position:center;">';
        echo '</div>'; // End of media-left
    echo '</a>';

    echo '<div class="media-body">';

    echo '<a href="userProfile.php?id='. $cm->user_id .'"><u>' . $user->fname . ' ' . $user->lname . '</u></a>';
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
</section>
