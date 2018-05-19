<?php
session_start();
$pageTitle = "It&apos;s Chow Time Application";
require_once 'pages/partial/_header.php';

 ?>
    <link href="assets/css/index.css" type="text/css" rel="stylesheet" />
    <link href="assets/css/search.css" type="text/css" rel="stylesheet"/>
    <link href="assets/css/general.css" type="text/css" rel="stylesheet" />
    <script src="assets/js/advanced-search.js" type="text/javascript"></script>
</head>
<body>
    <div id="bg-img">
    <header>
        <?php require_once 'pages/partial/_mainnav.php' ?>
        <!-- CHOWTIME SVG -->
        <div  class="container ddwrapper text-center">
        <svg version="1.1" id="chowtime" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                width="300px" height="120px" viewBox="0 0 328 177.3" style="enable-background:new 0 0 328 177.3;" xml:space="preserve">
            <path class="st0" id="ch" d="M43.9,96.2c-7-9.3-26.4-1-35.8,20c-7.5,16.9-9.8,34.8,5,49c18,17.3,37.8,5.5,39.2,4.6
                c19-12.8,21.9-29.1,25.6-46.4C91.5,60.8,91,2.5,84.7,2.6C79.6,2.7,78.1,42.3,77,74c-1.4,41.3-0.3,70.5,1.3,92.1"/>
            <path class="st0" id="time" d="M185.4,115.3c11.2-14.3,9.8-58.4,8.2-58.3c-2.2,0.2-6.6,111,3.9,111.7c4.7,0.3,6.8-7.1,9.3-21.2
                c2.4-13.5,2.2-25.7,2.7-25.7s-1,13.1,2.3,28.7c3.2,15.1,2.9,19.9,6.9,19.2c6-1.1,2.5-35,6.6-35.4c2.4-0.2,2.4,27.4,5.1,27
                c2.7-0.3,1.6-27.7,4.2-28c2.6-0.3,4.3,28.8,6,28.5c1.6-0.3-0.7-27.8,1.8-28.7c2.2-0.8,5.7,10.2,6.8,17.8c2,14,2.9,17.3,6,17.8
                c2.6,0.4,5.9-2.2,7.6-10.4c2.3-10.9,2.4-10.3,2.4-21.9c0-3.6-1.8-7.8-4.4-7.5c-3.2,0.3-4.1,7.4-3.8,13.1c0.6,11,3.5,19.4,15,22.2
                c8.7,2.1,16.7-4,23.3-9c5.2-3.9,9.3-9.1,17.3-19.3c4.7-6,8.4-11.1,11-14.7"/>
            <path class="st0" id="ow" d="M78.1,124.2c8.5-5.8,16.4-4.7,19.7,0.3c5.8,8.9-0.6,23.9,4.5,35.1c2.5,5.4,7.4,8.3,12.8,8.5
                c4.5,0.1,9-1.4,13.2-5c8.3-7.2,7.6-17.6,0.5-27.2c-4.4-5.9-5.8-7.3-12.9-9.5c-6.9-2.1-9.4,2.1-6.6,6.4c1.9,3,8,5.2,10,5.7
                c12.9,3.1,19.2-1.1,26-12.5c3.9-6.5,2.2-14,2.7-14c1.2,0,3.1,54.2,7,54.3c2.2,0.1,5.2-25.2,9.6-25.5c4.2-0.3,6.4,24.3,10.1,24.2
                c6.7-0.1,12.7-50.1,3.2-53.8c-2.5-1-5.8,0.3-6.8,2.8c-1.2,2.8-0.5,4.2,0.8,5.4c3.3,3,12.2-2.2,14.1-4.9"/>
            <line class="st1" x1="175.2" y1="90.7" x2="216.2" y2="75.2"/>
            <path class="st2" d="M208,111.2c0.6,0.9,1.2,1.9,1.8,2.8"/>
        </svg>
        </div>
    </header>
    <main class="container ddwrapper mb-4">
        <!-- YOUR CONTENT HERE -->
        <section class="mx-auto text-center mb-4" id="search">
            <h1 class="sr-only">Chow Time</h1>
            <h2>Find your Next recipe</h2>
            <form action="index.php" method="post" id="searchAll" name="searchAll" class="justify-content-around">
                    <label class="form-control-label sr-only" for="form_search">Search Recipes</label>
                    <input class="form-control form-control-lg col-sm-12 col-md-10" type="text" name="form_search" id="form_search" placeholder="Spaghetti, Soup, Salmon, etc..."/>
                    <button type="submit" name="searchRecipe" class="sr-only btn btn-default">Search</button>
            </form>
        </section>
    </main>
</div>
<div class="container ddwrapper">
        <section class="mx-auto" id="searchResults">
        </section>
</div>
    <?php require_once 'pages/partial/_footer.php' ?>
</body>
</html>
