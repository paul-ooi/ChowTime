<?php
require_once '../../models/db.php';
require_once '../../models/comment.php';

var_dump($_POST);
if (isset($_POST['delete'])){
    $id = $_POST['id'];
    $db = Database::getDb();
    $c = new Comment();
    $count = $c->deleteComment($db, $id);

    if ($count){
        header('Location: listComments.php');
    } else {
        echo "Problem Deleting";
    }
} else {
    echo "Problem Deleting";
}
