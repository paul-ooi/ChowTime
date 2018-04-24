<?php
require_once '../../models/event.php';
require_once '../../models/db.php';
require_once '../../models/profile.php';
$p = new Profile;
$e = new Event;
$db = Database::getDb();
session_start();
$event_id = $_SESSION['event_id'];

if (isset($_POST['details'])){
    $_SESSION['event_id'] = $_POST['event_id'];
}
if(isset($_GET['event_id'])) {
    $_SESSION['event_id'] = $_GET['event_id'];
}

// FOR BUTTON GROUP (Attend/Not Attend/Edit/Delete)
if (isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}

// EDIT EVENT
if (isset($_POST['update_event'])){
    $id = $_SESSION['event_id'];
    $event_name = $_POST['eName'];
    $event_location = $_POST['eLoc'];
    $date = $_POST['eDate'];
    $start_time = $_POST['eStartTime'];
    $end_time = $_POST['eEndTime'];
    $description = $_POST['eDescription'];
    $theme =$_POST['eTheme'];
    $e->updateEvent($db, $id, $event_name, $event_location, $date, $start_time, $end_time, $description, $theme);
}

// DELETE EVENT
if (isset($_POST['delete_event'])){
    $id = $_POST['event_id'];
    $e->deleteEvent($db, $id);
    header('Location: allEvents.php');
}

// FOR ATTENDANCE
if (isset($_POST['Attend'])){
    $e->addAttendance($db, $_SESSION['user_id'], $_SESSION['event_id']);
}

if (isset($_POST['NotAttend'])){
    $user_id = $_SESSION['user_id'];
    $event_id = $_SESSION['event_id'];
    $e->deleteAttendance($db, $user_id, $event_id);
}



include '../../pages/partial/_header.php';
?>

<link rel="stylesheet" href="../../assets/js/jqueryui/jquery-ui.css">
<link rel="stylesheet" href="../../assets/css/events.css">
</head>
<body>
    <header>
        <div class="wrapper">
            <?php include_once '../../pages/partial/_mainnav.php'; ?>
        </div>
    </header>
    <main>
        <?php
        if (isset($_SESSION['event_id'])){
            $event_id = $_SESSION['event_id'];
            $events = $e->getEvent($db, $event_id);
            $admin = $events[0]->user_id;

            // GETTING IMAGES FOR BANNERS
            $banners = $e->getBanner($db);
            $current = "";

            foreach ($events as $event) {
                if ($event->theme == "breakfast") {
                    $current = $banners[0];
                } else if ($event->theme == "lunch") {
                    $current = $banners[1];
                } else if ($event->theme == "dinner") {
                    $current = $banners[2];
                } else if ($event->theme == "dessert") {
                    $current = $banners[3];
                } else if ($event->theme == "holiday") {
                    $current = $banners[4];
                } else if ($event->theme == "birthday") {
                    $current = $banners[5];
                } else if ($event->theme == "gathering") {
                    $current = $banners[6];
                } else {
                    $current = $banners[7];
                }

                $user = $p->getProfileById($db, $event->user_id);
                ?>
                <section class="__banner mx-auto" style="background-image: url('<?php echo '../' . $current->file_location . $current->file_name; ?>'); background-size: cover; background-position:center;">
                    <div class="wrapper">
                        <div class="_content">
                        <h1><?php echo $event->event_name; ?></h1>

                        <p>Hosted by <?php echo $user->fname . ' ' . $user->lname;?>.</p>
                        <?php
                        if (isset($_SESSION['user_id'])){
                        echo '<div class="col-sm text-right">
                                <div class="btn-group" role="group" aria-label="...">';

                                // Check if user is the owner of this post
                                if ($user_id != $admin) {
                                    $attending = $e->checkAttendance($db, $user_id, $event->id);
                                    // If they do not own this post and are not attending show the following
                                    if ($attending == null){
                                        echo '<form action="" method="post" name="addMyEvents">';
                                            echo'<input type="hidden" value="' . $_SESSION['event_id'] . '" />';
                                            echo '<button type="submit" class="btn btn-default" name="Attend"><i class="fas fa-calendar-check"></i> Attend</button>';
                                        echo '</form>';
                                    } else { // ELSE if they do not own the post and are attending, show this
                                        echo '<form action="" method="post" name="deleteMyEvents">';
                                            echo '<input type="hidden" value="' . $_SESSION['event_id'] . '" />';
                                            echo '<button type="submit" class="btn btn-default" name="NotAttend"><i class="fas fa-calendar-minus"></i> Not Attending</button>';
                                        echo '</form>';
                                    }
                                }
                                if($user_id == $admin) { // If user is the admin of the page
                                    echo '<button type="button" class="btn btn-default" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fas fa-edit"></i> Edit</button>';

                                    echo '<form action="" method="post" name="deleteEvent">';
                                        echo '<input type="hidden" name="event_id" value="' . $event->id . '" />';
                                        echo '<button type="submit" class="btn btn-default" name="delete_event"><i class="fas fa-calendar-times"></i> Delete</button>';                                    echo '</form>';
                                }

                            echo '</div>
                            </div>';
                        }?>
                        <!-- Buttons: Attend/Not Attending [(for page admins) Edit | Delete] -->
                    </div>
                </div>
                </section>
                <section>
                    <div class="wrapper">
                        <div class="__event_details">
                            <h2>Details</h2>
                            <!-- Location -->
                            <p><i class="far fa-calendar-alt"></i> <?php echo date("D, F d, Y", strtotime($event->date)); ?></p>

                            <!-- Star Time [- End Time] -->
                        </div>

                        <p><i class="far fa-clock"></i>
                            <?php
                                echo date("g:i A", strtotime($event->start_time));
                                if ($event->end_time != null) {
                                    echo ' - ' . date("g:i A", strtotime($event->end_time));
                                }
                            ?>
                        </p>
                        <!-- Location -->
                        <p><i class="fas fa-map-marker"></i> <?php echo  $event->event_location;?></p>
                        <!-- Description -->
                        <p><?php echo $event->description; ?></p>

                        <!-- EDIT EVENT FORM -->
                        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title">Edit Event</h3>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="" method="post">
                                        <input type="hidden" name="eId" value="<?php echo $event->id; ?>"/>
                                        <div class="modal-body">
                                            <div class="form-group row">
                                                <label for="eName" class="col-sm-2 text-right control-label">Event Name*</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="eName" id="eName" class="form-control" value="<?php echo $event->event_name; ?>" />
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="eLoc" class="col-sm-2 text-right control-label"><i class="fas fa-map-marker"></i> Location*</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="eLoc" id="eLoc" class="form-control" value="<?php echo $event->event_location; ?>" />
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="eDate" class="col-sm-2 text-right control-label"><i class="far fa-calendar-alt"></i> Date*</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" name="eDate" id="datepicker" value="<?php echo date("Y-m-d", strtotime($event->date)); ?>" />
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
                                                    <textarea name="eDescription" class="form-control" rows="3"><?php echo $event->description; ?></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="eTheme" class="col-sm-2 text-right control-label">Theme</label>
                                                <div class="col-sm-10">
                                                    <select class="form-control" name="eTheme">
                                                        <option value="none">Is there a theme?</option>
                                                        <option value="breakfast">Breakfast</option>
                                                        <option value="lunch">Lunch</option>
                                                        <option value="dinner">Dinner</option>
                                                        <option value="dessert">Dessert</option>
                                                        <option value="holiday">Holiday</option>
                                                        <option value="birthday">Birthday</option>
                                                        <option value="gathering">Gathering</option>
                                                        <option value="other">Other</option>
                                                    </select>                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                            <input type="submit" class="btn btn-primary" name="update_event" value="Update" />
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                        <a href="allEvents.php">See All Events...</a>
                    </div>
                    <?php
                } // End of foreach ?>
                <?php
                    include_once '../comments/commentboxEvent.php';
                }
                ?>

    </main>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="../../assets/js/jqueryui/external/jquery/jquery.js"></script>
    <script src="../../assets/js/jqueryui/jquery-ui.js"></script>
    <script type="text/javascript" src="../../assets/js/jquery-timepicker/jquery.timepicker.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="../../assets/js/events.js"></script>
        <?php include '../../pages/partial/_footer.php'; ?>
</body>
