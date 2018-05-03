<?php
$user_id = $_SESSION['user_id'];
$today = date('Y-m-d H:i:s');
$category = $_POST['cIssue'];

$db = Database::getDb();
        
//VALIDATE TICKET VALUES

//CHECK USER_ID EXISTS IN DB
$p = new Profile();
$profile = $p::getProfileById($db, $user_id);

$categories = TicketDB::getTicketCatgetories($db);
//LOOP THROUGH ARRAY OF CATEGORIES FROM DB TO CHECK INCOMING IS VALID
foreach ($categories as $cat) {
    if ($cat->category === $category) {
        $valid_category = true;
        $category = $cat->id;
        break;
    } else {
        $valid_category = false;
    }
}

if ($profile != false && $valid_category) {
//user_id exists in DB, Create a new ticket and validate Ticket
    $t = new Ticket($user_id, $today, $category);
    $new_id = TicketDB::addTicket($db, $t);
    if ($new_id > 0) {
        //ADD TICKET MESSAGE TO MESSAGES TABLE
        $t->setId($new_id);
        $t->setMessage($_POST['cMsg']);
        $count = TicketDB::addMessage($db, $t);
        if ($count > 0) {
            echo $count . " message added";
        } else {
            echo $count . " message added";
        }
        
    }
}


?>