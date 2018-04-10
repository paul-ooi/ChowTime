<?php

// $serverRoot = $_SERVER['HTTP_HOST'];
// $appRoot = '/' . 'chowtime' . '/';
// set_include_path($serverRoot . $appRoot);
// echo get_include_path();
require_once '../../models/timer.php';
require_once '../../models/timerDB.php';
// require_once '../../models/timerDB.php';
// print_r($_POST);

// if (!isset($_POST)) {
//     header("Location: ". $serverRoot . $appRoot . "pages/timers.php");
// }

function createTimerObj() {
    $t = new Timer();
    $t->setTime($_POST['hours'], $_POST['minutes'], $_POST['seconds'], $_POST['name']);
    echo "<pre>";
    var_dump($t);
    echo "</pre>";
}//end createTimerObj

createTimerObj();



 ?>
