<?php
date_default_timezone_set('America/New_York');

class TicketDB {

    public function __construct() {
        //singleton class
    }
    //GET ALL TICKET CATEGORIES
    public static function getTicketCatgetories($db) {
        $query = "SELECT * FROM ticket_category";
        $pdostm = $db->prepare($query);

        $pdostm->setFetchMode(PDO::FETCH_OBJ);
        $pdostm->execute();
        $categories = $pdostm->fetchAll();

        return $categories; //array of categories and Id's
    }

    //CREATE TICKET IN TICKET TABLE
    public static function addTicket($db, $ticket) {
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO tickets (user_id, date_open, category_id) VALUES (:user, :date_open, :category)";

        $pdostm = $db->prepare($sql);
        $pdostm->bindValue(':user', $ticket->getUserId(), PDO::PARAM_INT);
        $pdostm->bindValue(':date_open', $ticket->getOpenDate(), PDO::PARAM_STR);
        $pdostm->bindValue(':category', $ticket->getCategory(), PDO::PARAM_INT);

        if ($pdostm->execute()) {
            return $db->lastInsertId();
        } else {
            return 0;
        }
    }

    //ADD TICKET MESSAGE TO TICKET TABLE
    public static function addMessage ($db, $message) {
        $count = 0;

        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO messages (ticket_id, sender_id, date_sent, message) VALUES (:ticket_id, :sender_id, :date_sent, :message)";

        $pdostm = $db->prepare($sql);
        $pdostm->bindValue(":ticket_id", $message->getId(), PDO::PARAM_INT);
        $pdostm->bindValue(":sender_id", $message->getUserId(), PDO::PARAM_INT);
        $pdostm->bindValue(":date_sent", $message->getOpenDate(), PDO::PARAM_STR);
        $pdostm->bindValue(":message", $message->getMessage(), PDO::PARAM_STR);

        if ($pdostm->execute()) {
            $count++;
            return $count;
        } else {
            return $count;
        }
    }

    //GET ALL TICKETS FOR SPECIFIED USER

    //GET ALL MESSAGES FOR SPECIFIED TICKET

    //MARK TICKET AS CLOSED
    //Get all Tickets
    public static function getAllTickets($db) {
        $sql = "SELECT * FROM tickets t JOIN ticket_category tc ON t.category_id = tc.id";
        $pdostm = $db->prepare($sql);

        $pdostm->setFetchMode(PDO::FETCH_OBJ);
        $pdostm->execute();

        return  $pdostm->fetchAll();


        $tickDisplay = '<table class="table table-striped table-sm text-center"><thead class="thead-dark">
                            <th>Ticket&num;</th>
                            <th>Request Category</th>
                            <th>Priority</th>
                            <th>Assigned To</th>
                            <th>Status</th>
                            <th>Actions</th>
                            </thead><tbody>';
        $tickets = $xml->xpath('//ticket');

        //Itterate through tickets to populate Table rows
        foreach ($tickets as $key => $ticket) {
            $viewDetails = '<form action="moreDetails.php" method="post"><input type="hidden" name="ticketId" value="' . $ticket[0]['id'] . '"/><input class="btn btn-default" type="submit" name="detailsBtn" value="See Details"/></form>';
            //Display Status Open/Closed
            if (!$ticket->status->dateClose) {
                $status = 'Open';
            } else {
                $status = 'Closed';
            }
            //Display Priority value
            if ($ticket->status->priority == "") {
                $priority = 'unset';
            } else {
                $priority = $ticket->status->priority;
            }
            //Display Support name
            if ($ticket->tech == "") {
                $supportName = 'unset';
            } else {
                $u = new User();
                $u->findUser($ticket->tech);
                $supportName = $u->getFirstName();
            }


            $tickDisplay .= '<tr><td>' . $ticket[0]['id'] . '</td>'
                        . '<td>' . $ticket[0]['category'] . '</td>'
                        . '<td>' . $priority . '</td>'
                        . '<td>' . $supportName . '</td>'
                        . '<td>' . $status . '</td>'
                        . '<td>' . $viewDetails . '</td>'
                        . '</tr>';
        }

        if ($tickets == []) {
            $tickDisplay .= '<tr>There are no ticket requests, YAY &lpar;That almost never happens!&rpar;<tr>';
        }

        $tickDisplay .= '</tbody></table>';

        return $tickDisplay;

    }//end getAllTickets


    function getTicketsByUserId($xml, $userId) {

        //Get all tickets that match $userId

        //build table
        $tickDisplay = '<table class="table table-striped table-sm text-center">
        <caption>Your Support Ticket History</caption>
                            <thead class="thead-dark">
                            <th>Ticket&num;</th>
                            <th>Request Category</th>
                            <th>Status</th>
                            <th>Actions</th>
                            </thead><tbody>';
        $tickets = $xml->xpath('//ticket[user="' . $userId . '"]');

        //Itterate through tickets to populate Table rows
        foreach ($tickets as $key => $ticket) {
            $viewDetails = '<form class="btn btn-default" action="moreDetails.php" method="post"><input type="hidden" name="ticketId" value="' . $ticket[0]['id'] . '"/><input class="btn btn-default" type="submit" name="detailsBtn" value="See Details"/></form>';
            if (!$ticket->status->dateClose) {
                $status = 'Open';
            } else {
                $status = 'Closed';
            }
            $tickDisplay .= '<tr><td>' . $ticket[0]['id'] . '</td>'
                        . '<td>' . $ticket[0]['category'] . '</td>'
                        . '<td>' . $status . '</td>'
                        . '<td>' . $viewDetails . '</td>'
                        . '</tr>';
        }
        $tickDisplay .= '</tbody></table>';

        return $tickDisplay;
    }//end of getTicketsByUserId

    function getTicketDetails($xml, $id) {
        $ticket = $xml->xpath('//ticket[@id="' . $id . '"]');

        //assign values for priority if already assigned.
        $priorityChange = '<form action="moreDetails.php" method="post">
        <select name="priority">
            <option value="">--Assign Priority Level--</option>
            <option value="low">Low</option>
            <option value="medium">Medium</option>
            <option value="high">High</option>
        </select>
        <input type="hidden" name="ticketId" value="' . $id . '"/>
        <input type="submit" name="updatePriorityBtn" value="Update Priority"/> <small>Update Priority, and assign ticket to you</small>' .'<?php $priorityError ?>' . '</form>';

        //Close Ticket Button
        $closeAction = '<form action="./pages/closeTicket.php" method="post">
        <input type="hidden" name="ticketId" value="' . $id . '"/>
        <input type="submit" name="closeTicket" value="Close Ticket"/> </form>';

        //Get Reason
        $reason = $ticket[0]['category'];


        $messages = getMessages($ticket);

        //Build Details Table
        $details = '<table class="table " id="ticket-details"><tr><th class="text-right">Ticket&num;</th><td>' . $ticket[0]['id'] . '</td></tr>';

        //Only add priority in Admin view
        if ($_SESSION['role'] == "support") {
            $priority = '<tr><th class="text-right">Priority</th><td>';
            //display the priority value
            if($ticket[0]->status->priority == "") {
                //if value is not present, show option to select
                $priority .= $priorityChange . '</td></tr>';
            } else {
                //value exists, show value
                $priority .= $ticket[0]->status->priority;
            }

            $details .= $priority;
        }//end Adding Priority Detail

        //Default when Open
        $closeValue = "&horbar; &horbar; ";
        //Only add Close Button in Admin view
        if ($_SESSION['role'] == "support") {
            $closeValue .= $closeAction;
        }//end Adding Close Button

        //Set Ticket close Date if closed
        if (isset($ticket[0]->status->dateClose)) {
            //Close Date
            $closeValue = date("Y-m-d H:i:s T", strtotime($ticket[0]->status->dateClose));
        }

        $details .= '<tr><th class="text-right">Date Open</th><td>' . $ticket[0]->status->dateOpen . '</td></tr>' .
                    '<tr><th class="text-right">Date Close</th><td>' . $closeValue . '</td></tr>' .
                    '<tr><th class="text-right">Issue</th><td>' . $reason . '</td></tr>' .
                    '<tr><th class="text-right">Messages</th><td>' . $messages . '</td></tr></table>';

        return $details;
    } //end getTicketDetails


    function createTicket($cat, $user, $msg) {

        //Open Exisiting XML ticket file
        $doc = getXmlFile();

        // Find latest ticket number and add one
        $xpath = new DOMXPath($doc);
        $query = '//ticket';
        $nextTicketId =  $xpath->query($query)->length; //current length of array
        $nextTicketId += 1; //add one to be the next ticket

        //get root element
        $root = $doc->getElementsByTagName("tickets")[0];

        //create Ticket Element
        $ticket = $doc->createElement('ticket');
        $category = createAttrAndValue($doc, "category", $cat);
        $ticketId = createAttrAndValue($doc, "id", $nextTicketId);
        $ticket->appendChild($category);
        $ticket->appendChild($ticketId);

        //Create Status element
        $status = $doc->createElement('status');
        $date = date("Y-m-d H:i:s T");//format date as YYYY-MM-DD HH:MM:SS Timezone(24 hour clock)
        $dateOpen = $doc->createElement('dateOpen', $date);
        $priority = $doc->createElement('priority',"");
        $status->appendChild($dateOpen);
        $status->appendChild($priority);
        $ticket->appendChild($status);

        //Create User element
        $userId = $doc->createElement('user', $user->getId());
        $ticket->appendChild($userId);

        //Create Tech element
        $tech = $doc->createElement('tech');
        $ticket->appendChild($tech);

        //Create Communique element
        $communique = $doc->createElement('communique');
        $ticket->appendChild($communique);

        $root->appendChild($ticket);
        $doc->appendChild($root);
        $doc->save('./xml/support-ticket.xml');

        //create message
        createMsg($nextTicketId, $user->getId(), $_SESSION['role'], $msg);


    }

    function createMsg($ticketId, $userId, $userType, $userMsg) {

        //Open Exisiting XML ticket file
        $doc = getXmlFile();

        // Get Communique for the specific ticket
        $xpath = new DOMXPath($doc);
        $query = '//ticket[@id='.$ticketId.']/communique';
        $communique = $xpath->query($query)[0];
        $query = '//ticket[@id='.$ticketId.']';
        $ticket = $xpath->query($query)[0];

        $date = date("Y-m-d H:i:s T");


        //Create Message element
        $message = $doc->createElement('message');
        $sent = createAttrAndValue($doc, "sent", $date);
        $message->appendChild($sent);

        //Create Sender element
        $sender = $doc->createElement('sender', $userId);
        $type = createAttrAndValue($doc, "type", $userType);
        $sender->appendChild($type);
        $message->appendChild($sender);

        //Create Body element
        $body = $doc->createElement('body', $userMsg);
        $message->appendChild($body);

        $communique->appendChild($message);
        $ticket->appendChild($communique);

        $doc->save('./xml/support-ticket.xml');

    } //end of createMsg

    function getMessages($ticket) {
        $messages = $ticket[0]->communique;

        //Load user XML to get user names
        $xml = simplexml_load_file('./xml/user.xml');
        $displayMsgs = '<div class="msg">';

        foreach ($messages->children() as $key => $msg) {
            //get sender type
            $senderType = $msg->sender[0]['type']->__toString();

            //get sender ID
            $senderID = $msg->sender[0]->__toString();

            if ($senderType == "customer") {
                //get displayname if sender type is customer
                $displayName = $xml->xpath('//user[@id="'. $senderID .'"]/displayname')[0];
            } else {
                //get firstname if sender type is support
                $displayName = $xml->xpath('//user[@id="'. $senderID .'"]/firstname')[0];
            }

            //Build format to display each message
            $displayMsgs .= '<div class="msg-header"><span class="sender">'. $msg->sender[0]['type'] .
            '</span>&lpar;' . $displayName . '&rpar; &horbar; ' . $msg->attributes() . '</div>' .
            '<div class="msg-body"><p>' . $msg->body .  '</p></div>';
        }
        $displayMsgs .= '</div>';

        return $displayMsgs;
    } //end of getMessages

}//end of Class Ticket
 ?>
