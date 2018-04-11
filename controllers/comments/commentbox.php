<?php include '../../pages/partial/_header.php'; ?>
</head>

<?php
    require_once '../../models/db.php';
    require_once '../../models/comment.php';

    if (isset($_POST['add'])){
        $recipeId = $_POST['recipeIdInput'];
        $userId = $_POST['userIdInput'];
        $comment = $_POST['commentInput'];
        $db = Database::getDb();
        $c = new Comment();
        $count = $c->addComment($db, $recipeId, $userId, $comment);
        if (!$count) {
            echo "Problem Adding.";
        }
    }
?>

<section id="commentBox">
        <h3>Add Comment</h3>
        <form action="" method="post" id="addComment">
            <div>
                <textarea class="form-control" rows="4"></textarea>
            </div>
            <div>
                <input type="hidden" value="<?php // Event Id ?>" />
                <input type="hidden" value="<?php // User Id ?>" />
                <input type="submit" class="btn btn-default" name="add" value="Post" />
            </div>
        </form>
</section>
