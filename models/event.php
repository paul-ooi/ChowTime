<?php
class Event {

    // CREATE COMMENT
    public function addEvent($db, $event_id, $user_id, $event_name, $event_location, $date, $start_time, $end_time, $description, $privacy, $theme){
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = 'INSERT INTO events (id, user_id, event_name, event_location, date, start_time, end_time, description, privacy, theme)
                              VALUES' + "(:event_id, :user_id, :event_name, :event_location, $date, $start_time, $end_time, :description, :privacy, :theme)";
        $pdostm = $db->prepare($sql);
        $pdostm->bindValue(':event_id', $event_id, PDO::PARAM_INT);
        $pdostm->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $pdostm->bindValue(':event_name', $event_name, PDO::PARAM_STR);
        $pdostm->bindValue(':event_location', $event_location, PDO::PARAM_STR);
        $pdostm->bindValue(':description', $description, PDO::PARAM_STR);
        $pdostm->bindValue(':privacy', $privacy, PDO::PARAM_STR);
        $pdostm->bindValue(':theme', $theme, PDO::PARAM_STR);
        $count = $pdostm->execute();
        return $count;
    }

    // READ ALL
    public function getAllEvents($db){
        $sql = 'SELECT * FROM events';
        $pdostm = $db->prepare($sql);
        $pdostm->setFetchMode(PDO::FETCH_OBJ);
        $pdostm->execute();
        return $pdostm->fetchAll();
    }

    // UPDATE COMMENT
    public function updateEvent($db, $id, $event_name, $event_location, $date, $start_time, $end_time, $description, $privacy, $theme)){
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE events SET event_name = :event_name, event_location = :event_location, date = $date, start_time = $start_time, end_time = $end_time, description = :description, privacy = :privacy, theme = :theme WHERE id = :id";
        $pdostm = $db->prepare($sql);
        $pdostm->bindValue(':id', $id, PDO::PARAM_INT);
        $pdostm->bindValue(':event_name', $event_name, PDO::PARAM_STR);
        $pdostm->bindValue(':event_location', $event_location, PDO::PARAM_STR);
        $pdostm->bindValue(':description', $description, PDO::PARAM_STR);
        $pdostm->bindValue(':privacy', $privacy, PDO::PARAM_STR);
        $pdostm->bindValue(':theme', $theme, PDO::PARAM_STR);
        $count = $pdostm->execute();
        return $count;
    }

    // DELETE COMMENT
    public function deleteEvent($db, $id){
        $sql = 'DELETE FROM events WHERE id = :id';
        $pdostm = $db->prepare($sql);
        $pdostm->bindValue(':id', $id, PDO::PARAM_INT);
        $count = $pdostm->execute();
        return $count;
    }
}
