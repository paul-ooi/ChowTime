<?php
session_start();
$pageTitle = "What's Cooking";
require_once 'partial/_header.php';
?>
<link rel="stylesheet" type="text/css" href="../assets/css/whatsCooking.css"/>
<!-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/css/bootstrap-slider.min.css" /> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/bootstrap-slider.min.js"></script>
<script src="../assets/js/whatsCooking.js"></script>
</head>
<?php
require_once 'Whats-cooking.php';
?>

<?php require_once 'partial/_mainnav.php' ?>
<main>
    <div class="title-blurb-container">
        <h1>What's Cooking?</h1>
        <p>Take a look around to see what other people are cooking in the neighbourhood! Click on the icon to see.</p>
    </div>
        <!-- END FILTER BAR CONTAINER -->
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div id="map"></div>
                </div>
            </div>
        </div>
    <!-- END ROW -->

    <script src="https://maps.googleapis.com/maps/api/js?key=<?= $googleKey ?>&callback=initializeMap"
        async defer></script>
</main>
<?php
    require_once 'partial/_footer.php';
?>
</body>
</html>
