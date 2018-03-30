<?php
$pageTitle = "What's Cooking";
require_once '_header.php';
require_once '_mainnav.php';
require_once '../models/apiKeys.php';

?>
<link rel="stylesheet" type="text/css" href="../assets/css/whatsCooking.css"/>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/css/bootstrap-slider.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/bootstrap-slider.min.js"></script>
<script src="../assets/js/whatsCooking.js"></script>
<main>
    <h1 id="title">What's Cooking?</h1>
    <div class="filter-icon-container">
        <img src="../icons/horizontal-filter.svg" alt="filter-icon" id="filter-btn"/>
    </div>
    <div class="row">
        <div class="col-sm-4 filter-bar-container">
            <h2>Filters</h2>
            <form method="post" action="whatsCooking.php">
                <div class="col-sm-12 filter-group">
                    <h3>Dietary Rescrictions</h3>
                    <div class="checkbox">
                        <label for="a">
                            <input type="checkbox" id="a" name="a" value="vegetarian">Vegetarian
                        </label>
                    </div>
                    <div class="checkbox">
                        <label for="b">
                            <input type="checkbox" id="b" name="b" value="gluten free" />Gluten Free
                        </label>
                    </div>
                    <div class="checkbox">
                        <label for="c">
                            <input type="checkbox" id="c" name="c" value="dairy free" />Dairy Free
                        </label>
                    </div>
                    <div class="checkbox">
                        <label for="d">
                            <input type="checkbox" id="d" name="d" value="vegan" />Vegan
                        </label>
                    </div>
                    <div class="checkbox">
                        <label for="e">
                            <input type="checkbox" id="e" name="e" value="nut free" />Nut Free
                        </label>
                    </div>
                </div>
                <div class="col-sm-12 distances-container">
                    <h3>Distance</h3>
                    <p><strong>Select your distance:</strong></p>
                    <div class="slide-container">
                        <strong>0km</strong>
                        <input type="text" data-slider-min="0" data-slider-max="100" value="0" data-slider-step="10" data-slider-value="[40, 60]" class="span2" id="distance" />
                        <strong>100km</strong>
                    </div>
                    <div class="hidden input-container">
                        <input type="text" id="in_distance" name="in_distance" class="form-control"/>
                        <strong>km</strong>
                    </div>
                    <input type="submit" id="filter" name="filter" class="btn btn-info"/>
                </div>
            </form>
        </div>
        <!-- END FILTER BAR CONTAINER -->
        <div class="col-sm-8" id="map"></div>
    </div>
    <!-- END ROW -->

    <script src="https://maps.googleapis.com/maps/api/js?key=<?= $googleKey ?>&callback=initializeMap"
        async defer></script>
</main>
<?php
require_once '_footer.php';
?>
</body>
</html>
