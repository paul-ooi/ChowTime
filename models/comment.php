<?php
class Comment {

    // CREATE COMMENT
    public function addComment($db, $recipeId, $userId, $comment){
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO comments (recipe_id, user_id, comment)
                              VALUES (:recipeId, :userId, :comment)";
        $pdostm = $db->prepare($sql);
        $pdostm->bindValue(':recipeId', $recipeId, PDO::PARAM_INT);
        $pdostm->bindValue(':userId', $userId, PDO::PARAM_INT);
        $pdostm->bindValue(':comment', $comment, PDO::PARAM_STR);
        $count = $pdostm->execute();
        return $count;
    }

    // READ ALL
    public function getAllComments($db){
        $sql = 'SELECT * FROM comments';
        $pdostm = $db->prepare($sql);
        $pdostm->setFetchMode(PDO::FETCH_OBJ);
        $pdostm->execute();
        return $pdostm->fetchAll();
    }

    // UPDATE COMMENT
    public function updateComment($db, $id, $comment){
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = 'UPDATE comments SET comment = :comment WHERE id = :id';
        $pdostm = $db->prepare($sql);
        $pdostm->bindValue(':id', $id, PDO::PARAM_INT);
        $pdostm->bindValue(':comment', $comment, PDO::PARAM_STR);
        $count = $pdostm->execute();
        return $count;
    }

    // DELETE COMMENT
    public function deleteComment($db, $id){
        $sql = 'DELETE FROM comments WHERE id = :id';
        $pdostm = $db->prepare($sql);
        $pdostm->bindValue(':id', $id, PDO::PARAM_INT);
        $count = $pdostm->execute();
        return $count;
    }

    //READ comments
    public function getCommentById($db, $id){
        $sql = 'SELECT * FROM comments WHERE id = :id';
        $pdostm = $db->prepare($sql);
        $pdostm->execute();
        $pdostm->bindValue(':id', $id, PDO::PARAM_INT);
        $comment = $pdostm->fetch(PDO::FETCH_OBJ);
        return $comment;
    }

    public function getUniqueRecipe($db){
        $sql = 'SELECT DISTINCT recipe_id FROM comments';
        $pdostm = $db->prepare($sql);
        $pdostm->setFetchMode(PDO::FETCH_OBJ);
        $pdostm->execute();
        return $pdostm->fetchAll();
    }

    public function getRecipesComments($db, $recipeId){
        $sql = "SELECT * FROM comments WHERE recipe_id = :recipeId";
        $pdostm = $db->prepare($sql);
        $pdostm->bindValue(':recipeId', $recipeId, PDO::PARAM_INT);
        $pdostm->setFetchMode(PDO::FETCH_OBJ);
        $pdostm->execute();
        return $pdostm->fetchAll();
    }

    public function getRecipeEventComments($db, $recipe_event, $recipe_event_id){
        if ($recipe_event == "recipe"){
            $recipe_event = "recipe_id";
        } else {
            $recipe_event = "event_id";
        }

        $sql = "SELECT * FROM comments WHERE :recipe_event = :recipe_event_id";
        $pdostm = $db->prepare($sql);
        $pdostm->bindValue(':recipe_event', $recipe_event, PDO::PARAM_STR);
        $pdostm->bindValue(':recipe_event_id', $recipe_event_id, PDO::PARAM_INT);
        $pdostm->setFetchMode(PDO::FETCH_OBJ);
        $pdostm->execute();
        return $pdostm->fetchAll();
    }
}
