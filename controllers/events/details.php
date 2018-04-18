<?php
require_once '../../models/event.php';
require_once '../../models/db.php';
//require_once '../../models/profile.php';
//$p = new Profile;
$e = new Event;
$db = Database::getDb();
session_start();

// FOR TESTING
$_SESSION['user_id'] = 1;

// FOR BUTTON GROUP (Attend/Not Attend/Edit/Delete)
$user_id = $_SESSION['user_id'];

if (isset($_POST['details'])){
    $event_id = $_POST['event_id'];
    $events = $e->getEvent($db, $event_id);
    $admin = $events[0]->user_id;


    include '../../pages/partial/_header.php';
    ?>

    <link rel="stylesheet" href="../../assets/css/events.css">
    <body>
        <header>
            <div class="wrapper">
                <?php include_once '../../pages/partial/_mainnav.php'; ?>
            </div>
        </header>
        <main>

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
            </div>

            <?php

            foreach ($events as $event) { ?>
                <section class="__banner">
                    <div class="wrapper">
                        <h1><?php echo $event->event_name; ?></h1>
                        <p>Hosted by <?php //echo $p->getUserName($event->user_id); // Display The Hosts Name ?>.</p>
                        <div class="col-sm text-right">
                            <div class="btn-group" role="group" aria-label="...">
                                <?php
                                // Check if user is the owner of this post
                                if ($user_id != $admin) {
                                    $attending = $e->checkAttendance($db, $user_id, $event->id);
                                    // If they do not own this post and are not attending show the following
                                    if ($attending == null){
                                        echo '<form action="" method="post" name="addMyEvents">';
                                            echo'<input type="hidden" value="' . $event->id . '" />';
                                            echo '<input type="submit" class="btn btn-default" value="Attend" />';
                                        echo '</form>';
                                    } else { // ELSE if they do not own the post and are attending, show this
                                        echo '<form action="" method="post" name="deleteMyEvents">';
                                            echo '<input type="hidden" value="' . $event->id . '" />';
                                            echo '<input type="submit" class="btn btn-default" value="Not Attending" />';
                                        echo '</form>';
                                    }
                                } else if($user_id == $admin) { // If user is the admin of the page
                                    echo '<button type="button" class="btn btn-default" data-toggle="modal" data-target=".bd-example-modal-lg">Edit</button>';

                                    echo '<form action="" method="post" name="deleteEvent">';
                                        echo '<input type="hidden" value="' . $event->id . '" />';
                                        echo '<input type="submit" class="btn btn-default" value="Delete" />';
                                    echo '</form>';
                                }
                                ?>
                            </div>
                        </div>
                        <!-- Buttons: Attend/Not Attending [(for page admins) Edit | Delete] -->
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

                        <?php
                    } // End of foreach
                } // End of if
                ?>


                <div class="row">
                <!-- Comment Section (first 10) -->
                </div>
                <?php
                include_once '../comments/listComments.php';
                include_once '../comments/commentbox.php';
                ?>
            </div>
        </section>
    </main>

    <?php include '../../pages/partial/_footer.php'; ?>
</body>
