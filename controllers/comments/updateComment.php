<?php
require_once '../../db.php';
require_once '../../models/comment.php';

$c = new Comment;
$db = Database::getDb();


?>

<h1>Update Comment</h1>
<form action="" method="post">
    <input type="hidden" name="id" value="<?php echo $com->id; ?>"/>
    Comment: <input type="text" name="comment" value="<?php echo $com->comment; ?>" /></br>
    <input type="submit" name="upd" value="Update">
</form>
