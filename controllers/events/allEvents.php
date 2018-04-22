<?php
require_once '../../models/db.php';
require_once '../../models/comment.php';
require_once '../../models/event.php';
$c = new Comment;
$e = new Event;
$db = Database::getDb();
session_start();

// FOR TESTING
// $userIdInput = 1;
// $_SESSION['user_id'] = $userIdInput;


// For Attendance
if (isset($_POST['Attend'])){
    $e->addAttendance($db, $_SESSION['user_id'], $_POST['event_id']);
}

if (isset($_POST['NotAttend'])){
    $e->deleteAttendance($db, $_SESSION['user_id'], $_POST['event_id']);
}

include '../../pages/partial/_header.php';
?>
<link rel="stylesheet" href="../../assets/css/events.css">
<link rel="stylesheet" href="../../assets/js/jqueryui/jquery-ui.css">

</head>
<body>
    <div class="wrapper">
        <?php include_once '../../pages/partial/_mainnav.php'; ?>
    </div>
    <div class="row __banner">
        <div class="wrapper">
            <h1>Events</h1>
        </div>
    </div>
    <section id="myEvents">
        <div class="wrapper">
        <?php
        if (isset($_SESSION['user_id'])){
            echo '<h2 class="row">My Events</h2>';
            $events = $e->myEvents($db, $_SESSION['user_id']);
            foreach ($events as $event){
                echo '<div class="media row">';
                    echo '<div class="media-left">';
                        echo '<a href="#">'; // TO BE CHANGED TO DETAILS PAGE (submit)
                            echo '<img class="media-object __event_image" src="' . $event->theme . '" alt="' . $event->theme . '" >';
                        echo '</a>'; // TO BE CHANGED
                    echo '</div>'; // End of media-left

                    echo '<div class="media-body">';
                        echo '<div class="col-sm">';
                            echo '<h4 class="media-heading">' . $event->event_name . '</h4>';
                            echo '<div>' .  date("l, F j, Y", strtotime($event->date)) . '</div>';
                            echo '<div>' . $event->event_location . ' @ ' . date("g:i A", strtotime($event->start_time)) . '</div>';
                        echo '</div>';
                        echo '<div class="col-sm text-right">';
                            echo '<div class="btn-group" role="group" aria-label="...">';
                                echo '<form action="details.php" method="post" name="details">';
                                    echo '<input type="hidden" name="event_id" value="' . $event->id . '" />';
                                    echo '<input type="submit" class="btn btn-default" name="details" value="Details"/>';
                                echo '</form>';
                            echo '</div>'; // End of btn-group
                        echo '</div>'; // End of col-sm text-right
                    echo '</div>'; // End of Media-body
                echo '</div>'; // End of Media
            } // End of foreach
        } // End of if isset($_SESSION[''])
            ?>
        </div>
    </section>
    <section id="eventsAttending">
        <div class="wrapper">
        <?php
        if (isset($_SESSION['user_id'])){
            echo '<h2 class="row">Attending</h2>';
            $attending = $e->eventsAttending($db, $_SESSION['user_id']);
            if($attending == null){
                echo '<p>You are currently not attending any events.</p>';
            }
            foreach ($attending as $a){
                $events = $e->getEvent($db, $a->event_id);
                foreach ($events as $event){
                echo '<div class="media row">';
                    echo '<div class="media-left">';
                        echo '<a href="#">'; // TO BE CHANGED TO DETAILS PAGE (submit)
                            echo '<img class="media-object __event_image" src="' . $event->theme . '" alt="' . $event->theme . '" >';
                        echo '</a>'; // TO BE CHANGED
                    echo '</div>'; // End of media-left

                    echo '<div class="media-body">';
                        echo '<div class="col-sm">';
                            echo '<h4 class="media-heading">' . $event->event_name . '</h4>';
                            echo '<div>' .  date("l, F j, Y", strtotime($event->date)) . '</div>';
                            echo '<div>' . $event->event_location . ' @ ' . date("g:i A", strtotime($event->start_time)) . '</div>';
                        echo '</div>';
                        echo '<div class="col-sm text-right">';
                            echo '<div class="btn-group" role="group" aria-label="...">';
                                echo '<form action="details.php" method="post" name="details">';
                                    echo '<input type="hidden" name="event_id" value="' . $event->id . '" />';
                                    echo '<input type="submit" class="btn btn-default" name="details" value="Details"/>';
                                echo '</form>';
                                echo '<form action="" method="post" name="deleteMyEvents">';
                                    echo '<input type="hidden" name="event_id" value="' . $event->id . '" />';
                                    echo '<button type="submit" class="btn btn-default" name="NotAttend"><i class="fas fa-calendar-minus"></i> Not Attending</button>';
                                echo '</form>';
                            echo '</div>'; // End of btn-group
                        echo '</div>'; // End of col-sm text-right
                    echo '</div>'; // End of Media-body
                echo '</div>'; // End of Media
                } // End of foreach - event
            } // End of foreach - attending
        } // End of if isset($_SESSION[''])
            ?>
        </div> <!-- End of Wrapper -->
    </section> <!-- End of eventsAttending Section -->
    <section id="allEvents">
        <div class="wrapper">
            <h2 class="row">All Events</h2>
            <?php
            $events = $e->getAllEvents($db);
            foreach ($events as $event){
                echo '<div class="media row">';
                    echo '<div class="media-left">';
                        echo '<a href="#">'; // TO BE CHANGED TO DETAILS PAGE (submit)
                            echo '<img class="media-object __event_image" src="' . $event->theme . '" alt="' . $event->theme . '" >';
                        echo '</a>'; // TO BE CHANGED
                    echo '</div>'; // End of media-left

                    echo '<div class="media-body">';
                        echo '<div class="col-sm">';
                            echo '<h4 class="media-heading">' . $event->event_name . '</h4>';
                            echo '<div>' .  date("l, F j, Y", strtotime($event->date)) . '</div>';
                            echo '<div>' . $event->event_location . ' @ ' . date("g:i A", strtotime($event->start_time)) . '</div>';
                        echo '</div>';
                        echo '<div class="col-sm text-right">';
                            echo '<div class="btn-group" role="group" aria-label="...">';
                                echo '<form action="details.php" method="post" name="details">';
                                    echo '<input type="hidden" name="event_id" value="' . $event->id . '" />';
                                    echo '<input type="submit" class="btn btn-default" name="details" value="Details"/>';
                                echo '</form>';
                        if (isset($_SESSION['user_id'])){
                            if ($_SESSION['user_id'] != $event->user_id) {
                            $count = $e->checkAttendance($db, $_SESSION['user_id'], $event->id);
                            if ($count == null){
                                echo '<form action="" method="post" name="addMyEvents">';
                                    echo '<input type="hidden" name="event_id" value="' . $event->id . '" />';
                                    echo '<button type="submit" class="btn btn-default" name="Attend"><i class="fas fa-calendar-check"></i> Attend</button>';
                                echo '</form>';
                            } else {
                                echo '<form action="" method="post" name="deleteMyEvents">';
                                    echo '<input type="hidden" name="event_id" value="' . $event->id . '" />';
                                    echo '<button type="submit" class="btn btn-default" name="NotAttend"><i class="fas fa-calendar-minus"></i> Not Attending</button>';
                                echo '</form>';
                            }
                        }
                        }
                            echo '</div>'; // End of btn-group
                        echo '</div>'; // End of col-sm text-right
                    echo '</div>'; // End of Media-body
                echo '</div>'; // End of Media
            } // End of events foreach loops
        ?>

    </div>
</section>
</main>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="../../assets/js/jqueryui/external/jquery/jquery.js"></script>
    <script src="../../assets/js/jqueryui/jquery-ui.js"></script>
    <script type="text/javascript" src="../../assets/js/jquery-timepicker/jquery.timepicker.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="../../assets/js/events.js"></script>
    <?php include '../../pages/partial/_footer.php'; ?>
</body>
</html>
