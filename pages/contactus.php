<?php
session_start();
// //FUTURE SOLUTION NEEDED FOR ONLINE HOST ROOT
// echo "<pre>";
// echo $_SERVER['HTTP_HOST'];
// $serverRoot = $_SERVER['HTTP_HOST'];
// $appRoot = '/' . 'chowtime' . '/';
// echo $appRoot;

// set_include_path($serverRoot . $appRoot);
// echo get_include_path().'<br/>';
// print_r($_SERVER);
// echo "</pre>";
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
// IF USER IS LOGGED IN, PRE-POPULATE THE NAME AND EMAIL
if (isset($_SESSION['user_id'])) {
        include '../controllers/contactus/ticket-request.php';
    } else {
        header("Location: login.php");
    };
    require_once '../pages/partial/_footer.php'; ?>
</body>
</html>
