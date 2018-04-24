<?php
class LikesDislikes {
    // READ FOR EVENTS
    public function getLikesByEvent($db, $event_id){
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = 'SELECT count(*) as count FROM event_likes WHERE event_id = :event_id;';
        $pdostm = $db->prepare($sql);
        $pdostm->bindValue(':event_id', $event_id, PDO::PARAM_INT);
        $pdostm->setFetchMode(PDO::FETCH_OBJ);
        $pdostm->execute();
        return $pdostm->fetchAll();
    }

    public function getDislikesByEvent($db, $event_id){
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = 'SELECT count(*) as count FROM event_dislikes WHERE event_id = :event_id;';
        $pdostm = $db->prepare($sql);
        $pdostm->bindValue(':event_id', $event_id, PDO::PARAM_INT);
        $pdostm->setFetchMode(PDO::FETCH_OBJ);
        $pdostm->execute();
        return $pdostm->fetchAll();
    }

    public function checkUserLikeEvent($db, $event_id, $user_id){
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = 'select * from event_likes where event_id = :event_id and user_id = :user_id';
        $pdostm = $db->prepare($sql);
        $pdostm->bindValue(':event_id', $event_id, PDO::PARAM_INT);
        $pdostm->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $pdostm->setFetchMode(PDO::FETCH_OBJ);
        $pdostm->execute();
        return $pdostm->fetchAll();
    }

    public function checkUserDislikeEvent($db, $event_id, $user_id){
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = 'select * from event_dislikes where event_id = :event_id and user_id = :user_id';
        $pdostm = $db->prepare($sql);
        $pdostm->bindValue(':event_id', $event_id, PDO::PARAM_INT);
        $pdostm->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $pdostm->setFetchMode(PDO::FETCH_OBJ);
        $pdostm->execute();
        return $pdostm->fetchAll();
    }

    // READ FOR RECIPES
    public function getLikesByRecipe($db, $recipe_id){
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = 'SELECT count(*) as count FROM recipe_likes WHERE recipe_id = :recipe_id;';
        $pdostm = $db->prepare($sql);
        $pdostm->bindValue(':recipe_id', $recipe_id, PDO::PARAM_INT);
        $pdostm->setFetchMode(PDO::FETCH_OBJ);
        $pdostm->execute();
        return $pdostm->fetchAll();
    }

    public function getDislikesByRecipe($db, $recipe_id){
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = 'SELECT count(*) as count FROM recipe_dislikes WHERE recipe_id = :recipe_id;';
        $pdostm = $db->prepare($sql);
        $pdostm->bindValue(':recipe_id', $recipe_id, PDO::PARAM_INT);
        $pdostm->setFetchMode(PDO::FETCH_OBJ);
        $pdostm->execute();
        return $pdostm->fetchAll();
    }

    public function checkUserLikeRecipe($db, $recipe_id, $user_id){
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = 'select * from recipe_likes where recipe_id = :recipe_id and user_id = :user_id';
        $pdostm = $db->prepare($sql);
        $pdostm->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $pdostm->bindValue(':recipe_id', $recipe_id, PDO::PARAM_INT);
        $pdostm->setFetchMode(PDO::FETCH_OBJ);
        $pdostm->execute();
        return $pdostm->fetchAll();
    }

    public function checkUserDislikeRecipe($db, $recipe_id, $user_id){
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = 'select * from recipe_dislikes where recipe_id = :recipe_id and user_id = :user_id';
        $pdostm = $db->prepare($sql);
        $pdostm->bindValue(':recipe_id', $recipe_id, PDO::PARAM_INT);
        $pdostm->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $pdostm->setFetchMode(PDO::FETCH_OBJ);
        $pdostm->execute();
        return $pdostm->fetchAll();
    }

    // CREAD AND DELETE FOR EVENTS
    public function addLikeEvent($db, $event_id, $user_id){
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = 'insert into event_likes (event_id, user_id) values (:event_id, :user_id)';
        $pdostm = $db->prepare($sql);
        $pdostm->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $pdostm->bindValue(':event_id', $event_id, PDO::PARAM_INT);
        $count = $pdostm->execute();
        return $count;
    }

    public function deleteLikeEvent($db, $event_id, $user_id){
        $sql = 'delete from event_likes where event_id = :event_id and user_id = :user_id';
        $pdostm = $db->prepare($sql);
        $pdostm->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $pdostm->bindValue(':event_id', $event_id, PDO::PARAM_INT);
        $count = $pdostm->execute();
        return $count;
    }

    public function addDislikeEvent($db, $event_id, $user_id){
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = 'insert into event_dislikes (event_id, user_id) values (:event_id, :user_id)';
        $pdostm = $db->prepare($sql);
        $pdostm->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $pdostm->bindValue(':event_id', $event_id, PDO::PARAM_INT);
        $count = $pdostm->execute();
        return $count;
    }

    public function deleteDislikeEvent($db, $event_id, $user_id){
        $sql = 'delete from event_dislikes where event_id = :event_id and user_id = :user_id';
        $pdostm = $db->prepare($sql);
        $pdostm->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $pdostm->bindValue(':event_id', $event_id, PDO::PARAM_INT);
        $count = $pdostm->execute();
        return $count;
    }

    // CREAD AND DELETE FOR RECIPES
    public function addLikeRecipe($db, $recipe_id, $user_id){
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = 'insert into recipe_likes (recipe_id, user_id) values (:recipe_id, :user_id)';
        $pdostm = $db->prepare($sql);
        $pdostm->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $pdostm->bindValue(':recipe_id', $recipe_id, PDO::PARAM_INT);
        $count = $pdostm->execute();
        return $count;
    }

    public function deleteLikeRecipe($db, $recipe_id, $user_id){
        $sql = 'delete from recipe_likes where recipe_id = :recipe_id and user_id = :user_id';
        $pdostm = $db->prepare($sql);
        $pdostm->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $pdostm->bindValue(':recipe_id', $recipe_id, PDO::PARAM_INT);
        $count = $pdostm->execute();
        return $count;
    }

    public function addDislikeRecipe($db, $recipe_id, $user_id){
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = 'insert into recipe_dislikes (recipe_id, user_id) values (:recipe_id, :user_id)';
        $pdostm = $db->prepare($sql);
        $pdostm->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $pdostm->bindValue(':recipe_id', $recipe_id, PDO::PARAM_INT);
        $count = $pdostm->execute();
        return $count;
    }

    public function deleteDislikeRecipe($db, $recipe_id, $user_id){
        $sql = 'delete from recipe_dislikes where recipe_id = :recipe_id and user_id = :user_id';
        $pdostm = $db->prepare($sql);
        $pdostm->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $pdostm->bindValue(':recipe_id', $recipe_id, PDO::PARAM_INT);
        $count = $pdostm->execute();
        return $count;
    }

}
