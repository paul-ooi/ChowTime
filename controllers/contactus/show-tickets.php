<?php
session_start();
require_once '../../models/db.php';
require_once '../../models/ticketDB.php';
//include user Class from Brad
$db = Database::getDb();
// if (!isset($_SESSION['role'])) {
//     header('Location: ../../index.php');
// } else {
//
//
//     //On First login, and no tickets exist in file, create the file
//     //User is logged in (assign user details to use in Database)
//         // load support request page (omit names and email)
//         // navigation should include viewing current user tickets etc.
//
//     //If user clicks on specific ticket to view details, show details
//
//     //get all tickets for this user
//     $ticketArray = TicketDB::getAllTickets($db);
//     $ticketDisplay;
//     foreach ($ticketArray as $key => $ticket) {
//         $ticketDisplay .= '<div class="ticket">';
//
//         $ticketDisplay .= '</div>';
//     }
//
//     //Populate Tickets from that User
//     $xml = simplexml_load_file('./xml/support-ticket.xml');
//     if ($_SESSION['role'] == "customer") {
//         $id = $_SESSION['user'];
//         $myTickets = getTicketsByUserId($xml, $id);
//     } else {
//         $myTickets = getAllTickets($xml);
//     }
//
// }
$moreDetailsBtn = '<form action="moreDetails.php" method="post"><input type="hidden" name="ticketId" value="' . '1' . '"/><input class="btn btn-default" type="submit" name="detailsBtn" value="See Details"/></form>';
$pageTitle = "My Tickets";
require_once '../../pages/partial/_header.php';
 ?>
</head>
    <body class="container">
        <header>
        <?php require_once '../../pages/partial/_mainnav.php' ?>
        </header>
        <main class="container">
         <h1>My Support Tickets</h1>
         <!-- Insert data from DB -->
        <div class="ddwrapper">
            <table class="table table-striped table-sm text-center">
                <thead>
                    <th>Ticket&num;</th>
                    <th>Category</th>
                    <th>Created</th>
                    <th>Closed</th>
                    <th>Status</th>
                    <th>Actions</th>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Login</td>
                        <td>2018-03-15 10:35:03</td>
                        <td>&horbar; &horbar;</td>
                        <td>Open</td>
                        <td><?php echo $moreDetailsBtn ?></td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Login</td>
                        <td>2018-03-15 10:35:03</td>
                        <td>&horbar; &horbar;</td>
                        <td>Open</td>
                        <td><?php echo $moreDetailsBtn ?></td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Login</td>
                        <td>2018-03-15 10:35:03</td>
                        <td>&horbar; &horbar;</td>
                        <td>Open</td>
                        <td><?php echo $moreDetailsBtn ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        </main>
    <?php require_once '../../pages/partial/_footer.php' ?>
    </body>
</html>
