<?php include 'partial/_header.php'; ?>
<link rel="stylesheet" href="../assets/css/events.css">
</head>
<body>
    <div class="row __banner">
        <div class="wrapper">
            <h1>Events</h1>
            <p>Explore various cooking and home dining events around you or be adventurous and create one of your own!</p>
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
                <div class="ml-auto">
                    <a href="#" class="btn btn-default">Create Event</a>
                </div>
            </div>
            <section>
                <h3 class="row">This Month</h3>
                <!-- Foreach event, grouped by unique dates within ## kms of users current location -->
                <article>
                    <div class="row __event_date">
                        <!-- Date of Event -->
                        <p>Thursday, April #, 2018</p>
                    </div>
                    <!-- foreach event with the date mentioned above -->
                        <div class="media row">
                            <div class="media-left">
                                <a href="#">
                                    <img class="media-object __event_image" src="..." alt="...">
                                </a>
                            </div>
                            <!-- Single post -->
                            <div class="media-body">
                                <div class="col-sm">
                                    <h4 class="media-heading">Media heading</h4>
                                    <div>00 Something St. @ 2:00PM</div>
                                </div>
                                <div class="col-sm text-right">
                                    <div class="btn-group" role="group" aria-label="...">
                                        <form action="" method="post" name="details">
                                            <input type="hidden" value="<?php // Event Id ?>" />
                                            <a href="__details.php"><input type="submit" class="btn btn-default" value="Details"/></a>
                                        </form>

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

                                        <form action="" method="post" name="ignoreMyEvents">
                                            <input type="hidden" value="<?php // Event Id ?>" />
                                            <input type="submit" class="btn btn-default" value="Ignore" />
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                </article>
            </section>
            <section class="row">
                <h3>Next Month</h3>
                <!-- Same as above -->
                <!-- If no events during this month -> section shows (+ Create an Event) -->
            </section>
            <section class="row">
                <h3>Next Next Month</h3>
                <!-- Same as above -->
                <!-- If no events during this month -> section shows (+ Create an Event) -->
            </section>
            <div class="row">
                <a href="#" class="ml-auto">Show All Events</a>
            </div>
        </div>
    </main>
    <?php include 'partial/_footer.php'; ?>
</body>
