<?php include '../../pages/partial/_header.php'; ?>

<link rel="stylesheet" href="../../assets/css/events.css">
<body>
    <main>
        <section class="__banner">
            <div class="wrapper">
                <h1>Event Name</h1>
                <p>Host Name Here</p>
                <div class="col-sm text-right">
                    <div class="btn-group" role="group" aria-label="...">
                        <?php // If user is not yet attending ?>
                        <form action="" method="post" name="addMyEvents">
                            <input type="hidden" value="<?php // Event Id ?>" />
                            <input type="submit" class="btn btn-default" value="Attend" />
                        </form>

                        <!-- OR -->

                        <?php // else if the user is already attending and does not wish to attend ?>
                        <form action="" method="post" name="deleteMyEvents">
                            <input type="hidden" value="<?php // Event Id ?>" />
                            <input type="submit" class="btn btn-default" value="Not Attending" />
                        </form>

                        <?php // If user is the admin of the page ?>
                        <form action="" method="post" name="editEvent">
                            <input type="hidden" value="<?php // Event Id ?>" />
                            <input type="submit" class="btn btn-default" value="Edit" />
                        </form>
                        <form action="" method="post" name="deleteEvent">
                                <input type="hidden" value="<?php // Event Id ?>" />
                                <input type="submit" class="btn btn-default" value="Delete" />
                        </form>
                    </div>
                </div>
                    <!-- Buttons: Attend/Not Attending [(for page admins) Edit | Delete] -->
            </div>
        </section>
        <div class="wrapper">
            <div class="__event_details">
                <h2>Details</h2>
                    <!-- Location -->
                    <p><i class="far fa-calendar-alt"></i> Thursday, April #, 2018</p>
                    <!-- Star Time [- End Time] -->
                    </div>

                    <p><i class="far fa-clock"></i> 2:00 PM [- 8:00 PM]</p>
                    <!-- Location -->
                    <p><i class="fas fa-map-marker"></i> 00 Something St.</p>
                    <!-- Description -->
                    <p>Come and enjoy with me the awesomeness of this example event. Don't forget to bring your fav dish because this is a pot-luck! No dish no entry.</p>

            <div class="row">
                <!-- Comment Section (first 10) -->
            </div>
                <?php
                include '../comments/listComment.php';
                include '../comments/commentbox.php'; ?>
        </div>
    </main>

    <?php include '../../pages/partial/_footer.php'; ?>
</body>
