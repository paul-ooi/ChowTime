<?php
require_once '../../models/timerDB.php';
require_once '../../models/db.php';
$db = Database::getDb();

switch ($_GET['action']) {
    case ("getTimers"):
        $timerList = TimerDB::getAllTimersByUser($db, 1);
        print_r(json_encode($timerList));
        break;
    case ("delTimer"):
        $timerName = $_GET['timerName'];
        $origTime = $_GET['origTime'];
        $result = TimerDB::delTimer($db, $timerName, $origTime);
        echo $result;
        break;
    case ("saveTimer"):
        var_dump($_GET);
        break;
    case ("origTimer"):
        //get the original time to reset the timer
        break;
}






 ?>
