<?php
?>

    <!-- MAIN NAVIGATION -->
        <nav class="navbar navbar-expand-lg navbar-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <div class="nav-container">
                    <a class="nav-item nav-link" href="/chowtime/pages/recipes.php">Recipes</a>
                    <a class="nav-item nav-link invisible" href="/chowtime/pages/recipes.php">Recipes</a>
                </div>
                <div class="nav-container">
                    <a class="nav-item nav-link" href="/chowtime/pages/whatsCooking.php">What's Cooking</a>
                    <a class="nav-item nav-link invisible" href="/chowtime/pages/whatsCooking.php">What's Cooking</a>
                </div>
                <div class="nav-container">
                    <a class="nav-item nav-link" href="/chowtime/pages/events.php">Events</a>
                    <a class="nav-item nav-link invisible" href="/chowtime/pages/events.php">Events</a>
                </div>
                <?php if (isset($_SESSION['user_id'])) : ?>
                    <div class="nav-container">
                        <a class="nav-item nav-link" href="/chowtime/pages/yourProfile.php">Profile</a>
                        <a class="nav-item nav-link invisible" href="/chowtime/pages/yourProfile.php">Profile</a>
                    </div>
                <?php endif ?>
            </div>
        </div>
        <?php if (!isset($_SESSION['user_id'])) { ?>
            <form class="form-inline my-2 my-lg-0" action="/chowtime/pages/login.php" method="post">
                <button class="btn my-2 my-sm-0" type="submit">Login</button>
            </form>
        <?php } else { ?>
            <form class="form-inline my-2 my-lg-0" action="/chowtime/pages/login.php" method="post">
                <button class="btn my-2 my-sm-0" type="submit">Lougout</button>
            </form>
        <?php } ?>
    </nav>
<div  class="container ddwrapper">
    <!-- LOGO && SIGNATURE -->
    <div class="text-center mx-auto" id="title">
        <div class="logo-container">
            <a href="/chowtime/index.php"><img class="mx-auto" id="logo" src="/chowtime/assets/imgs/ct-logo.png" alt="Chow Time logo - Plate with fork and knife arranged like locator marker"/></a>
        </div>
    </div>
</div>
