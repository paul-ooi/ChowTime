<?php
require_once '../../models/timerDB.php';
require_once '../../models/db.php';
$db = Database::getDb();

switch ($_GET['action']) {
    case ("getTimers"):
        $timerList = TimerDB::getAllTimersByUser($db, 1);
        print_r(json_encode($timerList));
        break;
    case ("getSomething"):
        echo "Got something";
}






 ?>
