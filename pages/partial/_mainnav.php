<?php
?>
<div  class="container ddwrapper">
    <nav id="main-nav">
        <ul class="nav nav-pills">
            <li><a class="nav-link px-2" href="/chowtime/pages/events.php">Events</a></li>
            <li><a class="nav-link px-2" href="/chowtime/pages/whatsCooking.php">What&apos;s Cooking</a></li>
            <li><a class="nav-link" href="/chowtime/pages/recipes.php" title="Show me all the recipes">Recipes</a></li>
            <li><a class="nav-link px-2" href="/chowtime/pages/contactus.php">Contact Us</a></li>
            <?php if (!isset($_SESSION['user_id'])) { ?>
            <li><a class="nav-link px-2 " href="/chowtime/pages/login.php">Login</a></li>
            <?php } else { ?>
            <li><a class="nav-link px-2 " href="/chowtime/pages/yourProfile.php">My Profile</a></li>
            <li><a class="nav-link px-2 " href="/chowtime/pages/login.php">Logout</a></li>
            <?php } ?>
        </ul>
    </nav>
    <div class="text-center mx-auto" id="title">
        <h2><a href="/chowtime/index.php">Chow <img class="mx-auto" id="logo" src="/chowtime/assets/imgs/ct-logo.png" alt="Chow Time logo - Plate with fork and knife arranged like locator marker"/> Time</a></h2>
    </div>
</div>
