<?php
date_default_timezone_set('America/New_York');

class TimerDB {

    public function __construct() {
        //singleton class
    }

    //Get all Tickets (Database and User details from session)
    public static function getAllTimersByUser($db, $user) {
        $query = "SELECT * FROM timers WHERE user_id = :user ORDER BY id DESC";
        $pdostm = $db->prepare($query);

        $pdostm->bindValue(':user', $user, PDO::PARAM_INT);
        $pdostm->setFetchMode(PDO::FETCH_OBJ);
        $pdostm->execute();

        return $pdostm->fetchAll();
        // $timerList;
        // foreach ($userTimers as $key => $t) {
        //     $timerList .=
        // }

    }//end getAllTimersByUser

    public static function getTimerValues($time) {
    	//get remaining time in seconds
    	$hours = floor($time / 3600);
    	$minutes = floor(($time % 3600) / 60);
    	$seconds = floor($time % 60);

    	//Make single digit values still display as pre-pended by
    	($hours < 10) ? $hours = "0" . strval($hours) : $hours = strval($hours);
    	($minutes < 10) ? $minutes = "0" . strval($minutes) : $minutes = strval($minutes);
    	($seconds < 10) ? $seconds = "0" . strval($seconds) : $seconds = strval($seconds);

        $timerValues = [
            'hh'=>$hours,
            'mm'=>$minutes,
            'ss'=>$seconds,
        ];

        return $timerValues;
    }//end of getTimerValues


    function getTimerDetails() {
        //Retrieve each timer's detail
        return ; //return the Timer Details
    } //end getTicketDetails


    public static function addTimer($db, $timer) {
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO timers (user_id, t_name,  set_time, remainder) VALUES (:user_id, :timer_name, :set_time, :remainder)";

        $pdostm = $db->prepare($sql);
        $pdostm->bindValue(':user_id', $timer->user, PDO::PARAM_INT);
        $pdostm->bindValue(':timer_name', $timer->timer->getName(), PDO::PARAM_STR);
        $pdostm->bindValue(':set_time', $timer->timer->getOrigTime(), PDO::PARAM_INT);
        $pdostm->bindValue(':remainder', $timer->timer->getOrigTime(), PDO::PARAM_INT);

        $count = $pdostm->execute();
        return $count;
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
