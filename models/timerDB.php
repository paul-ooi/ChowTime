<?php
date_default_timezone_set('America/New_York');//USE THIS IN FUTURE TO ASSIGN END DATES FOR TIMERS 

class TimerDB {

    public function __construct() {
        //singleton class
    }

    //GET ALL TIMERS FO SPECIFIED USER
    public static function getAllTimersByUser($db, $user) {
        $query = "SELECT * FROM timers WHERE user_id = :user ORDER BY id DESC";
        $pdostm = $db->prepare($query);

        $pdostm->bindValue(':user', $user, PDO::PARAM_INT);
        $pdostm->setFetchMode(PDO::FETCH_OBJ);
        $pdostm->execute();

        return $pdostm->fetchAll();


    }//end getAllTimersByUser

    // GET THE VALUES OF THE TIMERS FROM THE DB
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


    // ADD TIMER TO THE DB
    public static function addTimer($db, $timer) {
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO timers (user_id, t_name,  set_time, remainder) VALUES (:user_id, :timer_name, :set_time, :remainder)";

        $pdostm = $db->prepare($sql);
        $pdostm->bindValue(':user_id', $timer->user, PDO::PARAM_INT);
        $pdostm->bindValue(':timer_name', $timer->timer->getName(), PDO::PARAM_STR);
        $pdostm->bindValue(':set_time', $timer->timer->getOrigTime(), PDO::PARAM_INT);
        $pdostm->bindValue(':remainder', $timer->timer->getOrigTime(), PDO::PARAM_INT);

        $count = $pdostm->execute();

        if ($count == 1) {
            $feedbackMsg = "Saved " . $timer->timer->getName() . " timer to Your Timers.";
        } else {
            $feedbackMsg = "Error, Timer not saved.";
        }
        return $feedbackMsg;
    }// end of addTimer

    // REMOVE TIMER FROM THE DB
    public static function delTimer($db, $timerName, $origTime) {
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "DELETE FROM timers WHERE t_name = :timerName and set_time = :origTime ORDER BY id DESC LIMIT 1";

        $pdostm = $db->prepare($sql);
        $pdostm->bindValue(':timerName', $timerName, PDO::PARAM_STR);
        $pdostm->bindValue(':origTime', $origTime, PDO::PARAM_INT);

        $count = $pdostm->execute();

        if ($count == 1) {
            $feedbackMsg = "Success, Timer removed.";
        } else {
            $feedbackMsg = "Error, Timer not removed.";
        }
        return $feedbackMsg;

    }

    //TO BUILD CROSS PAGE FUNCTIONALITY, SAVE ALL TIMERS BEFORE CHANGE PAGE
    // public static function pauseTimer(($db, $timerName, $remainTime) {

    // }



}//end of Class Ticket
 ?>
