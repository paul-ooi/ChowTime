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
<svg version="1.1" id="chow" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 width="193.3px" height="91px" viewBox="0 0 193.3 91" style="enable-background:new 0 0 193.3 91;" xml:space="preserve">
<path id="chow" class="chowtime" d="M44.1,32.3c0,0,9-7,10-16s-3.7-11.2-9-10c-18,4-29.4,23.7-34,38c-8,25,16,40,24,39s18-10,22-15s27-46,27-48
	s-4-1-9,13s-9,30-8,34s5,3,8-4s13-26,16-26s-4,20-3,29s-1,10,4,10s19-32,23-33s-4,8-7,18c-1.7,5.7-1,16,6,16s14-8,16-17s6-23-5-25
	s-19,15,10,7s11.4-9.3,9,10c-1,8-3,20,2,24c3.1,2.5,11-12,17-23s10-20,5-18s-12,41-1,41s20-28,19-38s-1-13-1-13"/>
</svg>

<svg version="1.1" id="time" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 width="176px" height="92.5px" viewBox="0 0 176 92.5" style="enable-background:new 0 0 176 92.5;" xml:space="preserve">
<path id="topt" class="chowtime" d="M88,4c-10,13-26,7-37,5S5-2,4,21"/>
<path id="bottomt" class="chowtime" d="M55,9C39,23,29,42,27,84"/>
<path id="ime" class="chowtime" d="M57,42c-9,15-17.1,34.1-10,42c9.3,10.3,30-35,28-38s-15,43-12,38c5-8,14.5-35.9,29-37c13-1-6,29-4,32
	c1.8,2.8,16.9-36.2,32-35c13,1-24.6,45-7,45c22,0,49.1-35,44-42c-5.5-7.5-23,0-26.5,21.5c-3.3,20.5,25.5,29.5,42-4"/>
<line id="dot" class="chowtime" x1="66" y1="27" x2="65" y2="29"/>
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
