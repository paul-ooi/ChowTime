<?php
require_once '../models/db.php';
require_once '../models/event.php';
$e = new Event;
$db = Database::getDb();

// FOR TESTING PURPOSES
$userIdInput = 1;

// ADDING EVENT
if (isset($_POST['add_event'])){
    $user_id = $_POST['eUserId'];
    $event_name = $_POST['eName'];
    $event_location = $_POST['eLoc'];
    $date = $_POST['eDate'];
    $start_time = $_POST['eStartTime'];
    $end_time = $_POST['eEndTime'];


    $description = $_POST['eDescription'];
    $privacy = $_POST['ePrivacy'];
    $theme =$_POST['eTheme'];
    echo $end_time;
    echo $start_time;
    $e->addEvent($db, $user_id, $event_name, $event_location, $date, $start_time, $end_time, $description, $privacy, $theme);

}

// ADD ATTENDANCE
if (isset($_POST['Attend'])){
    $e->addAttendance($db, $_POST['user_id'], $_POST['event_id']);
}

?>

<?php include 'partial/_header.php'; ?>
<link rel="stylesheet" href="../assets/css/events.css">
<link rel="stylesheet" href="../assets/js/jqueryui/jquery-ui.css">

</head>
<body>
    <div class="wrapper">
    <?php include_once 'partial/_mainnav.php'; ?>
</div>
    <div class="row __banner">
        <div class="wrapper">
            <h1>Events</h1>
            <p>Explore various cooking and home dining events around you or be adventurous and create one of your own!</p>

            <button type="button" class="btn btn-default" data-toggle="modal" data-target=".bd-example-modal-lg">Create Event</button>
            <!-- CREATE EVENT FORM -->
            <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="createTitle">New Event</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="" method="post">
                            <input type="hidden" name="eUserId" value="<?php echo $userIdInput; ?>" />
                            <div class="modal-body">
                                <div class="form-group row">
                                    <label for="eName" class="col-sm-2 text-right control-label">Event Name*</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="eName" id="eName" class="form-control" placeholder="What is this event called?" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="eLoc" class="col-sm-2 text-right control-label"><i class="fas fa-map-marker"></i> Location*</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="eLoc" id="eLoc" class="form-control" placeholder="Include place or address." />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="eDate" class="col-sm-2 text-right control-label"><i class="far fa-calendar-alt"></i> Date*</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="eDate" id="datepicker" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="eStartTime" class="col-sm-2 text-right control-label"><i class="far fa-clock"></i> Start Time*</label>
                                    <div class="col-sm-10">
                                        <select class="timeSelect form-control" name="eStartTime">
                                            <option value="none">Choose a time...</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="eEndTime" class="col-sm-2 text-right control-label"><i class="far fa-clock"></i> End Time</label>
                                    <div class="col-sm-10">
                                        <select class="timeSelect form-control" name="eEndTime">
                                            <option value="none">Choose a time...</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="eDescription" class="col-sm-2 text-right control-label">Description*</label>
                                    <div class="col-sm-10">
                                        <textarea name="eDescription" class="form-control" rows="3" placeholder="A little something about your event."></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="ePrivacy" class="col-sm-2 text-right control-label"><i class="fas fa-unlock"></i> Privacy*</label>
                                    <div class="col-sm-10">
                                        <input type="radio" name="ePrivacy" value="1" id="privatePrivacy" /><label for="privatePrivacy"> Private </label>
                                        <input type="radio" name="ePrivacy" value="0" id="publicPrivacy" /><label for="publicPrivacy"> Public </label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="eTheme" class="col-sm-2 text-right control-label">Theme</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="eTheme" class="form-control" placeholder="Is there a theme?"/>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <input type="submit" class="btn btn-primary" name="add_event" value="Create" />
                            </div>
                        </form>
                    </div>
                </div>
            </div><!-- END OF CREATE FORM -->
        </div>
    </div>
    <section id="suggested">
        <div class="wrapper">
            <h2>Suggested</h2>
            <!-- LINK NEEDS TO BE ADDED -->
            <div class="row">
                <article class="col">
                    <div class="__suggested_thumb"></div>
                    <div>Event 1</div>
                </article>
                <article class="col">
                    <div class="__suggested_thumb"></div>
                    <div>Event 2</div>
                </article>
                <article class="col">
                    <div class="__suggested_thumb"></div>
                    <div>Event 3</div>
                </article>
                <article class="col">
                    <div class="__suggested_thumb"></div>
                    <div>Event 4</div>
                </article>
            </div>
            <div class="text-right"><a href="#">View All Suggestions...</a></div>
        </div>
    </section>
    <main id="events">
        <div class="wrapper">
            <div class="row">
                <h2>Upcoming</h2>
            </div>
            <?php
            for ($i = 1; $i <= 3; $i++){
                // Start Day of the Month
                $firstDayOfMonth = date('Y-m-d', mktime(0,0,0, date('m')+$i-1, 1));
                if ($i == 1){
                    $firstDayOfMonth = date('Y-m-d');
                }
                // Last Day of the Month
                $lastDayOfMonth = date('Y-m-d', mktime(0, 0, 0, date('m')+$i, 0));

                echo '<section>';
                echo '<h3 class="row">' . date('F', mktime(0,0,0, date('m')+$i, 0)) . '</h3>';

                $dates = $e->getUniqueDatesByMonth($db, $firstDayOfMonth, $lastDayOfMonth);

                foreach ($dates as $date){
                    echo '<article>';
                        echo '<div class="row __event_date">';
                            echo '<p>' . $date.date . '</p>';
                        echo '</div>';

                        $events = $e->getPublicEventsByDate($db, $date.date);
                        foreach ($events as $event){
                            echo '<div class="media row">';
                                echo '<div class="media-left">';
                                    echo '<a href="#">'; // TO BE CHANGED TO DETAILS PAGE (submit)
                                        echo '<img class="media-object __event_image" src="' . $event.theme . '" alt="' . $event.theme . '" >';
                                    echo '</a>'; // TO BE CHANGED
                                echo '</div>'; // End of media-left

                                echo '<div class="media-body">';
                                    echo '<div class="col-sm">';
                                        echo '<h4 class="media-heading">' . $event.event_name . '</h4>';
                                        echo '<div>' . $event.event_location . ' @ ' . date('g:iA', $event.start_time) . '</div>';
                                    echo '</div>';
                                    echo '<div class="col-sm text-right">';
                                        echo '<div class="btn-group" role="group" aria-label="...">';
                                            echo '<form action="../controllers/events/details.php" method="post">';
                                                echo '<input type="hidden" name="event_id" value="' . $event.id . '" />';
                                                echo '<input type="submit" class="btn btn-default" name="details" value="Details"/>';
                                            echo '</form>';

                                        if ($e->checkAttendance($db, $userIdInput, $event.id) == 1){
                                            echo '<form action="" method="post" name="addMyEvents">';
                                                echo '<input type="hidden" name="event_id" value="' . $event.id . '" />';
                                                echo '<input type="hidden" name="user_id" value="' . $userIdInput . '"/>';
                                                echo '<input type="submit" class="btn btn-default" name="Attend" value="Attend" />';
                                            echo '</form>';
                                        } else {
                                            echo '<form action="" method="post" name="deleteMyEvents">';
                                                echo '<input type="hidden" value="' . $event.id . '" />';
                                                echo '<input type="hidden" value="' . $userIdInput . '"/>';
                                                echo '<input type="submit" class="btn btn-default" name="NowAttend" value="Not Attending" />';
                                            echo '</form>';
                                        }
                                        echo '</div>'; // End of btn-group
                                    echo '</div>'; // End of col-sm text-right
                                echo '</div>'; // End of Media-body
                            echo '</div>'; // End of Media
                        } // End of events foreach loops
                    echo '</artircle>';
                } // End of dates foreach loop
                echo '</section>';
            }
            ?>

            <div class="row">
                <a href="../controllers/events/allEvents.php" class="ml-auto">Show All Events</a>
            </div>
        </div>
    </main>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="../assets/js/jqueryui/external/jquery/jquery.js"></script>
    <script src="../assets/js/jqueryui/jquery-ui.js"></script>
    <script type="text/javascript" src="../assets/js/jquery-timepicker/jquery.timepicker.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="../assets/js/events.js"></script>
    <?php include 'partial/_footer.php'; ?>
</body>
</html>
