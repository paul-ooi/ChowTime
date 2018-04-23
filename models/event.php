<?php
class Event {
//comm\\\
    // CREATE COMMENT
    public function addEvent($db, $user_id, $event_name, $event_location, $date, $start_time, $end_time, $description, $theme){
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $start_time = $date . ' ' . $start_time;
        $end_time = $date . ' ' . $end_time;
        $date = $start_time;
        $date = date("Y-m-d H:i:s", strtotime($date));
        $start_time = date("Y-m-d H:i:s", strtotime($start_time));
        $end_time = date("Y-m-d H:i:s", strtotime($end_time));

        echo $date . " " . $start_time . " " . $end_time;
        $sql = 'insert into events (user_id, event_name, event_location, date, start_time, end_time, description, privacy, theme)'
                . " values (:user_id, :event_name, :event_location, '$date', '$start_time', '$end_time', :description, 0, :theme)";
        $pdostm = $db->prepare($sql);
        $pdostm->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $pdostm->bindValue(':event_name', $event_name, PDO::PARAM_STR);
        $pdostm->bindValue(':event_location', $event_location, PDO::PARAM_STR);
        $pdostm->bindValue(':description', $description, PDO::PARAM_STR);
        $pdostm->bindValue(':theme', $theme, PDO::PARAM_STR);
        $count = $pdostm->execute();
        return $count;
    }

    // READ ALL PUBLIC EVENTS
    public function getAllEvents($db){
        $sql = 'SELECT * FROM events where privacy = 0';
        $pdostm = $db->prepare($sql);
        $pdostm->setFetchMode(PDO::FETCH_OBJ);
        $pdostm->execute();
        return $pdostm->fetchAll();
    }

    // READ 1 EVENT
    public function getEvent($db, $event_id){
        $sql = 'SELECT * FROM events where id = :event_id';
        $pdostm = $db->prepare($sql);
        $pdostm->bindValue(':event_id', $event_id, PDO::PARAM_INT);
        $pdostm->setFetchMode(PDO::FETCH_OBJ);
        $pdostm->execute();
        return $pdostm->fetchAll();
    }

	//Get all event by event id sorted by start date

	public function getEventByStartDate($db, $event_id){
        $sql = 'SELECT * FROM events where id = :event_id order by date, start_time';
        $pdostm = $db->prepare($sql);
        $pdostm->bindValue(':event_id', $event_id, PDO::PARAM_INT);
        $pdostm->setFetchMode(PDO::FETCH_OBJ);
        $pdostm->execute();
        return $pdostm->fetchAll();
    }

    // Get unique dates
    public function getUniqueDatesByMonth($db, $start_date, $end_date){
        $start_date = date("Y-m-d", strtotime($start_date));
        $end_date = date("Y-m-d", strtotime($end_date));
        $sql = "select distinct date from events where privacy = 0 and date >=  '$start_date' and date <= '$end_date' order by date";
        $pdostm = $db->prepare($sql);
        $pdostm->setFetchMode(PDO::FETCH_OBJ);
        $pdostm->execute();
        return $pdostm->fetchAll();
    }

    // Get all public events for unique date
    public function getPublicEventsByDate($db, $date){
        $sql = "select * from events where privacy = 0 and date = '$date' order by start_time";
        $pdostm = $db->prepare($sql);
        $pdostm->setFetchMode(PDO::FETCH_OBJ);
        $pdostm->execute();
        return $pdostm->fetchAll();
    }

    // Events Created By you
    public function myEvents($db, $user_id){
        $sql = 'select * from events where user_id = :user_id order by start_time';
        $pdostm = $db->prepare($sql);
        $pdostm->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $pdostm->setFetchMode(PDO::FETCH_OBJ);
        $pdostm->execute();
        return $pdostm->fetchAll();
    }

	public function myEventsByStartDate($db, $user_id){
        $sql = 'select * from events where user_id = :user_id order by date';
        $pdostm = $db->prepare($sql);
        $pdostm->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $pdostm->setFetchMode(PDO::FETCH_OBJ);
        $pdostm->execute();
        return $pdostm->fetchAll();
    }

    // Events You are attending
    public function eventsAttending($db, $user_id){
        $sql = 'select * from events_attendees where user_id = :user_id';
        $pdostm = $db->prepare($sql);
        $pdostm->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $pdostm->setFetchMode(PDO::FETCH_OBJ);
        $pdostm->execute();
        return $pdostm->fetchAll();
    }

    // Checks if user is attending the events
    public function checkAttendance($db, $user_id, $event_id){
        $sql = 'select * from events_attendees where user_id = :user_id and event_id = :event_id';
        $pdostm = $db->prepare($sql);
        $pdostm->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $pdostm->bindValue(':event_id', $event_id, PDO::PARAM_INT);
        $pdostm->setFetchMode(PDO::FETCH_OBJ);
        $pdostm->execute();
        return $pdostm->fetchAll();
    }

    // Add Attendance
    public function addAttendance($db, $user_id, $event_id){
        $sql = 'insert into events_attendees (user_id, event_id) values (:user_id, :event_id)';
        $pdostm = $db->prepare($sql);
        $pdostm->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $pdostm->bindValue(':event_id', $event_id, PDO::PARAM_INT);
        $count = $pdostm->execute();
        return $count;
    }

    // Delete Attendance
    public function deleteAttendance($db, $user_id, $event_id){
        $sql = 'delete from events_attendees where user_id = :user_id and event_id = :event_id';
        $pdostm = $db->prepare($sql);
        $pdostm->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $pdostm->bindValue(':event_id', $event_id, PDO::PARAM_INT);
        $count = $pdostm->execute();
        return $count;
    }

    // UPDATE EVENT
    public function updateEvent($db, $id, $event_name, $event_location, $date, $start_time, $end_time, $description, $theme){
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $start_time = $date . ' ' . $start_time;
        $end_time = $date . ' ' . $end_time;
        $date = $start_time;
        $sql = "UPDATE events SET event_name = :event_name, event_location = :event_location, date = '$date', start_time = '$start_time', end_time = '$end_time', description = :description, theme = :theme WHERE id = :id";
        $pdostm = $db->prepare($sql);
        $pdostm->bindValue(':id', $id, PDO::PARAM_INT);
        $pdostm->bindValue(':event_name', $event_name, PDO::PARAM_STR);
        $pdostm->bindValue(':event_location', $event_location, PDO::PARAM_STR);
        $pdostm->bindValue(':description', $description, PDO::PARAM_STR);
        $pdostm->bindValue(':theme', $theme, PDO::PARAM_STR);
        $count = $pdostm->execute();
        return $count;
    }

    // DELETE EVENT
    public function deleteEvent($db, $id){
        $sql = 'DELETE FROM events WHERE id = :id';
        $pdostm = $db->prepare($sql);
        $pdostm->bindValue(':id', $id, PDO::PARAM_INT);
        $count = $pdostm->execute();
        return $count;
    }

    // GET THEME BANNERS
    public function getBanner($db){
        $sql = 'SELECT * FROM theme_pics';
        $pdostm = $db->prepare($sql);
        $pdostm->setFetchMode(PDO::FETCH_OBJ);
        $pdostm->execute();
        return $pdostm->fetchAll();
    }
}
