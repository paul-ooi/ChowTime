<?php
session_start();
$user_id = $_SESSION['user_id'];
$pageTitle = "Timers";//Rename this to be the title in the Tab
include 'partial/_header.php';//Head with CSS and CDNs, Title o page
require_once '../models/db.php';//Connects to DB
require_once '../models/timer.php';//Timer Class
require_once '../models/timerDB.php';//Timer DB functions
require_once '../models/validation.php';//Timer DB functions

$db = Database::getDb();

if(isset($_POST["saveTimer"]) || isset($_POST["startTimer"]) ) {
    $v = new Validation();

    $hours = $_POST["hours"];
    $minutes = $_POST["minutes"];
    $seconds = $_POST["seconds"];
    $name = $_POST["name"];

    $t = new Timer($hours, $minutes, $seconds, $name);

    $timer = (object)[
        'user' => $user_id, //Need to get the User id from the Session variable.
        'timer' => $t
    ];

    $feedbackMsg = TimerDB::addTimer($db, $timer);
}

$userTimers = TimerDB::getAllTimersByUser($db, $user_id);

 ?>
<link href="../assets/css/timers.css" type="text/css" rel="stylesheet"/>
<script src="../assets/js/timers.js" type="text/javascript"></script>
</head>
<body class="container ddwrapper">
    <header class="container ddwrapper">
        <?php require_once 'partial/_mainnav.php' ?>
    </header>
    <aside class="col-12 order-1">
        <!-- add instructions -->
        <h2>Using Timers</h2>
        <p>Sometimes you will be cooking multiple things in the kitchen, and you need help keeping track of all the timed tasks. Save timers so you can use multiple timers at once.</p>
    </aside>
    <main class="col-12 order-2">
        <!-- TIMER FORM -->
        <h1>Set New Timer</h1>
        <form action="" method="post" name="timerForm" class="">
            <div class="row mb-3  justify-content-end">
                <div class="col-2">
                    <label for="hours" class="control-label">Hours</label>
                    <input min="0" class="col-10 form-control" type="number" id="hours" name="hours" value="<?php //echo $hours?>"/>
                </div>
                <div class="col-2">
                    <label for="minutes" class="control-label">Minutes</label>
                    <input min="0" class="col-10 form-control" type="number" id="minutes" name="minutes" value="<?php //echo $minutes?>"/>
                </div>
                <div class="col-2">
                    <label for="seconds" class="control-label">Seconds</label>
                    <input min="0" class="col-10 form-control" type="number" id="seconds" name="seconds" value="<?php //echo $seconds?>"/>
                </div>
                <div class="col-4">
                    <label for="name" class="control-label">Timer Name</label>
                    <input class="col-12 form-control" type="text" id="name" name="name" value="<?php //echo $name?>" placeholder="Optional"/>
                </div>
            </div>
            <div class="row px-1 justify-content-end">
                <!-- <button type="button" name="startTimer" id="startTimerBtn" class="btn timer-btn col-md-2 mx-3" for="timerForm">Start Timer</button> -->
                <button type="submit" name="saveTimer" id="saveTimerBtn" class="btn timer-btn col-md-2 mx-3" for="timerForm">Save Timer</button>
            </div>
            <div>
                <label for="timerForm" id="feedbackMsg"><?php echo (empty($feedbackMsg) ? "" : $feedbackMsg) ?></label>
            </div>
        </form>
        <div>
            <!-- TOGGLE VISIBILITY OF SAVED TIMERS -->
            <span id="timers-tg">View saved Timers</span>
        </div>
        <div id="storedTimers" class="hidden container col-12">
            <!-- LIST OF SAVED TIMERS -->
            <h2>Your Timers</h2>
            <div id=storedTimerFeedback></div>
            <!-- HEADINGS -->
            <div class="row col-12">
                <div class="col-3"><h3>Name</h3></div>
                <div class="col-3"><h3>Length</h3></div>
                <div class="col-6"><h3>Actions</h3></div>
            </div>
            <!-- GET TIMERS FROM DATABASE AND LIST -->
            <ul>

                <?php foreach ($userTimers as $key => $t) {?>
                <li class="timer row col-12">
                    <div class="timer-name col-3"><?php echo $t->t_name ?></div>
                    <?php if (empty($t->remainder)) {
                        $tValue = TimerDB::getTimerValues($t->set_time);
                    } else if ($t->set_time >= $t->remainder) {
                        $tValue = TimerDB::getTimerValues($t->remainder);
                    } ?>
                    <div class="timer-value col-3">
                        <h4>
                            <span class="hours"><?php echo $tValue['hh'] ?></span><sub>H</sub>:
                            <span class="minutes"><?php echo $tValue['mm'] ?></span><sub>M</sub>:
                            <span class="seconds"><?php echo $tValue['ss'] ?></span><sub>S</sub>
                        </h4>
                    </div>
                    <div class="col-6">
                        <button name="startTimer" class="start-time btn timer-btn col-3">Start</button>
                        <button name="stopTimer" class="stop-time timer-btn btn col-3">Stop</button>
                        <button name="deleteTimer" class="del-time btn timer-btn col-3">Remove</button>
                    </div>
                </li>
            <?php }//End of FOREACH to list Timers?>
            </ul>
        </div>
    </main>

    <?php require_once 'partial/_footer.php' ?>
</body>
</html>
