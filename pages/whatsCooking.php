<?php
$pageTitle = "What's Cooking";
require_once '_header.php';
require_once '_mainnav.php';
require_once '../models/apiKeys.php';

?>
<link rel="stylesheet" type="text/css" href="../assets/css/whatsCooking.css"/>
<script src="../assets/js/whatsCooking.js"></script>
<main>
    <h1>What's Cooking</h1>
    <div id="map">word</div>

    <script src="https://maps.googleapis.com/maps/api/js?key=<?= $googleKey ?>&callback=initializeMap"
        async defer></script>
</main>
<?php
require_once '_footer.php';
?>
</body>
</html>
