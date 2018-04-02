<?php
// //Need solution for relative navigation
// $siteRoot = filter_input(INPUT_SERVER, 'DOCUMENT_ROOT');
// $appRoot = filter_input(INPUT_SERVER, 'REQUEST_URI');
// $rootSec = explode('/', $appRoot);
// $homeRoot = $rootSec[1];
//
// echo $homeRoot.'<br/>';
// echo $siteRoot.'<br/>';
// set_include_path($siteRoot . '/' . $homeRoot);
// echo get_include_path().'<br/>';


$pageTitle = 'Contact Us';
require_once '../pages/partial/_header.php';

?>
<link href="../assets/css/contactus.css" type="text/css" rel="stylesheet"/>
</head>
<body class="container ddwrapper">
<header>
<?php require_once '../pages/partial/_mainnav.php' ?>
</header>
<?php
//if not logged in, display request page for anonymous user (require names and email)
if (!isset($_SESSION['user'])) {
        include '../controllers/contactus/ticket-request.php';
    } else {
        echo "user logged in";
    };
    require_once '../pages/partial/_footer.php'; ?>
</body>
</html>
