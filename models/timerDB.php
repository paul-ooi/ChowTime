<?php
date_default_timezone_set('America/New_York');

class TimerDB {

    public function __construct() {
        //singleton class
    }

    //Get all Tickets (Database and User details from session)
    public static function getAllTimersByUser($db, $user) {
        $sql = "SELECT * FROM timers WHERE user_id = :user";
        $pdostm = $db->prepare($sql);

        $pdostm->bindValue(':user',user, PDO::PARAM_INT);
        $pdostm->setFetchMode(PDO::FETCH_OBJ);
        $pdostm->execute();

        return  $pdostm->fetchAll();
    }//end getAllTimersByUser




    function getTimerDetails() {
        //Retrieve each timer's detail
        return ; //return the Timer Details
    } //end getTicketDetails


    function createTimer($cat, $user, $msg) {
 //


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
