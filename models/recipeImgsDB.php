<?php

class RecipeImagesDB {

    //CREATE
    public static function insertImg($image) {
        $db = Database::getDb();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO recipe_imgs VALUES (':id', ':recipe_id', ':img_src', ':theme_id')";
        $db->prepare($sql);
        $sql->bindValue(":id", $image->getId(), PDO::PARAM_INT);
        $sql->bindValue(":recipe_id", $image->getRecipeId(), PDO::PARAM_INT);
        $sql->bindValue(":img_src", $image->getImgSrc(), PDO::PARAM_STR);
        $sql->bindValue(":theme_id", $image->getThemeId(), PDO::PARAM_INT);
        $count = $db->execute(PDO::FETCH_OBJ);

        return $count;
    }

}

//READ


//UPDATE


//DELETE




//GET ID(PK) BY RECIPE ID



?>
