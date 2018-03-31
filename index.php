<?php
$pageTitle = "It&apos;s Chow Time Application";
require_once 'pages/partial/_header.php';

 ?>
    <link href="assets/css/index.css" type="text/css" rel="stylesheet" />
</head>
<body class="container ddwrapper">
    <header class="container ddwrapper">
        <?php require_once 'pages/partial/_mainnav.php' ?>
    </header>
    <main class="container ddwrapper  mb-5">
        <!-- YOUR CONTENT HERE -->
        <section class="mx-auto text-center mb-5" id="search">
            <h1 class="sr-only">Chow Time</h1>
            <h2>Find your Next recipe</h2>
            <form class="form-inline" action="controllers/recipes/_allrecipes.php" method="post" id="searchAll" name="searchAll">
                <div class="input-group d-inline-md justify-content-center">
                    <label class="form-control-label sr-only" for="form_search">Search Recipes</label>
                    <input class="form-control form-control-lg" type="text" name="form_search" id="form_search" placeholder="Start cooking..."/>
                    <span class="input-group-btn">
                    <input class="btn btn-lg" type="submit" for="searchAll" name="searchRecipesBtn" id="searchRecipesBtn" value="Search Recipes"/>
                </span>
                </div>
            </form>
            <!-- <span class="bkg">
                <img src="assets/imgs/image1.jpg" alt="plate of spaghetti"/>
            </span> -->
        </section>
        <section class="mx-auto mb-3" id="searchResults">
        </section>
        <section class="mx-auto" id="top-category">
            <h2>Top searched categories</h2>
            <div class="row">
            <div class="gallery-item col-sm-6 col-lg-4 text-center">
                <a href="index.php"><h3>Category name</h3><img src="assets/imgs/image1.jpg" alt="plate of spaghetti" class=" img-thumbnail"/></a>
            </div>
            <div class="gallery-item col-sm-6 col-lg-4 text-center">
                <a href="index.php"><h3>Category name</h3><img src="assets/imgs/image1.jpg" alt="plate of spaghetti" class=" img-thumbnail"/></a>
            </div>
            <div class="gallery-item col-sm-6 col-lg-4 text-center">
                <a href="index.php"><h3>Category name</h3><img src="assets/imgs/image1.jpg" alt="plate of spaghetti" class=" img-thumbnail"/></a>
            </div>
            <div class="gallery-item col-sm-6 col-lg-4 text-center">
                <a href="index.php"><h3>Category name</h3><img src="assets/imgs/image1.jpg" alt="plate of spaghetti" class=" img-thumbnail"/></a>
            </div>
            <div class="gallery-item col-sm-6 col-lg-4 text-center">
                <a href="index.php"><h3>Category name</h3><img src="assets/imgs/image1.jpg" alt="plate of spaghetti" class=" img-thumbnail"/></a>
            </div>
            <div class="gallery-item col-sm-6 col-lg-4 text-center">
                <a href="index.php"><h3>Category name</h3><img src="assets/imgs/image1.jpg" alt="plate of spaghetti" class=" img-thumbnail"/></a>
            </div>
        </div>
        </section>
    </main>
    <?php require_once 'pages/partial/_footer.php' ?>
</body>
</html>
