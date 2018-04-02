<?php
$pageTitle = "Timers";//Rename this to be the title in the Tab
include 'partial/_header.php';//Head with CSS and CDNs, Title o page
require_once '../models/db.php';//Connects to DB
require_once '../models/timer.php';//Timer Class


 ?>
<link href="../assets/css/timers.css" type="text/css" rel="stylesheet"/>
<script src="../assets/js/timers.js" type="text/javascript"></script>
</head>
<body class="container ddwrapper">
    <header class="container ddwrapper">
        <?php require_once 'partial/_mainnav.php' ?>
    </header>
    <main class="col-12">
        <!-- TIMER FORM -->
        <h1>Timer</h1>
        <form action="timers.php" method="post">
            <div>
                <label for="hours">Hours: </label>
                <input type="number" id="hours" name="hours" value="<?php //echo $hours?>"/>
            </div>
            <div>
                <label for="minutes">Minutes: </label>
                <input type="number" id="minutes" name="minutes" value="<?php //echo $minutes?>"/>
            </div>
            <div>
                <label for="seconds">Seconds: </label>
                <input type="number" id="seconds" name="seconds" value="<?php //echo $seconds?>"/>
            </div>
            <div>
                <label for="name">Timer Name: </label>
                <input type="text" id="name" name="name" value="<?php //echo $name?>" placeholder="Optional"/>
            </div>
            <div>
                <button type="submit" name="startTimer" class="btn timer-btn">Start Timer</button>
                <button type="submit" name="saveTimer" class="btn timer-btn">Save Timer for later</button>
            </div>
            <div>
                <span id="timers-tg">View saved Timers</span>
                <!-- <button class="btn timer-btn" id="timers-tg">View saved Timers</button> -->
                <!-- <a href="" ></a> -->
            </div>
        </form>
        <div id="storedTimers" class="hidden container col-12">
            <h2>Your Timers</h2>
            <!-- HEADINGS -->
            <div class="row col-12">
                <div class="col-3"><h3>Name</h3></div>
                <div class="col-3"><h3>Length</h3></div>
                <div class="col-6"><h3>Actions</h3></div>
            </div>
            <!-- GET TIMERS FROM DATABASE AND LIST -->
            <div class="timer row col-12">
                <div class="col-3">Timer Name</div>
                <div class="col-3"><h4>00<sub>H</sub>:00<sub>M</sub>:00<sub>S</sub></h4></div>
                <div class="col-6">
                    <button name="startTimer" class="start-time btn timer-btn col-3">Start</button>
                    <!-- <button name="stopTimer" class="stop-time timer-btn btn col-3">Stop</button> -->
                    <button name="deleteTimer" class="del-time btn timer-btn col-3">Remove</button>
                </div>
            </div>
            <div class="timer row col-12">
                <div class="col-3">Timer Name</div>
                <div class="col-3"><h4>00<sub>H</sub>:00<sub>M</sub>:00<sub>S</sub></h4></div>
                <div class="col-6">
                    <!-- When timer is active, hide start button and reveal stop -->
                    <!-- <button name="startTimer" class="start-time timer-btn btn col-3">Start</button> -->
                    <button name="stopTimer" class="stop-time timer-btn btn col-3">Stop</button>
                    <button name="deleteTimer" class="del-time timer-btn btn col-3">Remove</button>
                </div>
            </div>
        </div>
    </main>
    <aside class="col-12">
        <!-- add instructions -->
        <h2>Using Timers</h2>
        <p>Sometimes you will be cooking multiple things in the kitchen, and you need help keeping track of all the timed tasks. Save timers so you can use multiple timers at once. Or set your timer values and click start to start a single timer</p>
    </aside>
    <?php require_once 'partial/_footer.php' ?>
</body>
</html>
