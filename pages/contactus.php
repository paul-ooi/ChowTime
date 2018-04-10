<?php
// //Need solution for relative navigation
echo "<pre>";
echo $_SERVER['HTTP_HOST'];
$serverRoot = $_SERVER['HTTP_HOST'];
$appRoot = '/' . 'chowtime' . '/';
echo $appRoot;

set_include_path($serverRoot . $appRoot);
echo get_include_path().'<br/>';
print_r($_SERVER);
echo "</pre>";


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
