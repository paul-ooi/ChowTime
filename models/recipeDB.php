<?php
class RecipeDb {
    // DISPLAY ALL RECIPES
    public static function displayAllRecipes() {
        $db = Database::getDb();

        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "SELECT * FROM recipes";
        $statement = $db->prepare($query);
        $statement->setFetchMode(PDO::FETCH_OBJ);
        $statement->execute();

        return $statement->fetchAll();
    }

    //DISPLAY ONLY RECIPE NAME
    public static function displayByTitle($title) {
        $db = Database::getDb();

        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "SELECT title FROM recipes WHERE title LIKE '%$title%'";
        $statement = $db->prepare($query);
        $statement->bindValue(":title", $title, PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    //DISPLAY RECIPE BY ID
    public static function displayById($in_id) {
        $db = Database::getDb();

        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "SELECT * FROM recipes WHERE id = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $in_id, PDO::PARAM_INT);
        $statement->setFetchMode(PDO::FETCH_OBJ);
        $statement->execute();
        return $statement->fetch();
    }

    //ADD A RECIPE
    public static function addRecipe($recipe) {
        $db = Database::getDb();

        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "INSERT INTO recipes VALUES (:id, :user_id, :img_id, :title, :descr, SEC_TO_TIME(:p_time*60), SEC_TO_TIME(:c_time*60), :dish, :ingred, :diff, :spicy, null, :steps)";

        $statement = $db->prepare($query);

        $id = $recipe->getId();
        $user_id = $recipe->getUserId();
        $img_id = $recipe->getImgId();
        $title = $recipe->getTitle();
        $descr = $recipe->getDescr();
        $p_time = $recipe->getPrepTime();
        $c_time = $recipe->getCookTime();
        $dish = $recipe->getDishLvl();
        $ingred = $recipe->getIngredLvl();
        $diff = $recipe->getDiffLvl();
        $spicy = $recipe->getSpicyLvl();
        $steps = $recipe->getSteps();

        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $statement->bindValue(':img_id', $img_id, PDO::PARAM_INT);
        $statement->bindValue(':title', $title, PDO::PARAM_STR);
        $statement->bindValue(':descr', $descr, PDO::PARAM_STR);
        $statement->bindValue(':p_time', $p_time);
        $statement->bindValue(':c_time', $c_time);
        $statement->bindValue(':dish', $dish, PDO::PARAM_INT);
        $statement->bindValue(':ingred', $ingred, PDO::PARAM_INT);
        $statement->bindValue(':diff', $diff, PDO::PARAM_INT);
        $statement->bindValue(':spicy', $spicy, PDO::PARAM_INT);
        $statement->bindValue(':steps', $steps, PDO::PARAM_STR);

        $statement->setFetchMode(PDO::FETCH_OBJ);
        $count = $statement->execute();

        return $count;
    }

    //UPDATE A RECIPE (also should be done based on user session)
    //Default params are exhisting params from the recipe
    public static function updateRecipe($in_id, $recipe) {
        $db = Database::getDb();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "UPDATE recipes SET
                    descr =  :descr,
                    img = :img,
                    prep = :prep,
                    ingred = :ingred,
                    diff = :diff,
                  WHERE id = :id";

        $this->setId($in_id);
        $id = $this->getId();
        $title = $this->getTitle();
        $descr = $this->getDescr();
        $img = $this->getImgSrc();
        $prep = $this->getPrepTime();
        $dish = $this->getDishLvl();
        $statement->bindValue(":ingred", $ingred, PDO::PARAM_STR);
        $statement->bindValue(":diff", $diff, PDO::PARAM_STR);
        $statement->setFetchMode(PDO::FETCH_OBJ);
        $count = $statement->execute();

        return $count;
    }
    //DELETE A RECIPE
    public static function deleteRecipe($id) {
        $db = Database::getDb();

        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "DELETE FROM recipes WHERE id = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(":id", $id, PDO::PARAM_INT);
        $statement->setFetchMode(PDO::FETCH_OBJ);
        $count = $statement->execute();

        return $count;
    }

    //TOTAL RECIPE TIME
    public static function totalRecipeTime($id) {
        $db = Database::getDb();

        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "SELECT ADDTIME(prep_time, cook_time) AS 'total_time' FROM recipes WHERE id = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(":id", $id, PDO::PARAM_INT);
        $statement->setFetchMode(PDO::FETCH_OBJ);
        $statement->execute();
        return $statement->fetch();
    }

    //RECOMMENDED DIFFICULTY
    public static function recommDiff($id) {
        $db = Database::getDb();

        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "SELECT ROUND(((dishes_lvl + ingred_lvl + spicy_lvl)/3), 2) AS 'recomm_diff' FROM recipes WHERE id= :id";
        $statement = $db->prepare($query);
        $statement->bindValue(":id", $id);
        $statement->setFetchMode(PDO::FETCH_OBJ);
        $statement->execute();
        return $statement->fetch();
    }

    //MAIN RECIPE IMAGE
    public static function mainRecipeImg($id) {
        $db = Database::getDb();

        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "SELECT img_src FROM recipe_imgs ri
        JOIN recipes r
        ON r.main_img_id = ri.id
        WHERE r.id = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(":id", $id);
        $statement->setFetchMode(PDO::FETCH_OBJ);
        $statement->execute();

        return $statement->fetch();
    }

    //ALL RECIPE IMAGES
    public static function allRecipeImgs($id) {
        $db = Database::getDb();

        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "SELECT img_src FROM recipe_imgs ri
        JOIN recipes r
        ON r.id = ri.recipe_id
        WHERE r.id = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(":id", $id);
        $statement->setFetchMode(PDO::FETCH_OBJ);
        $statement->execute();

        return $statement->fetchAll();
    }

    //SELECT LAST RECIPE ID FROM THE LIST - https://stackoverflow.com/questions/3133711/select-last-id-without-insert?utm_medium=organic&utm_source=google_rich_qa&utm_campaign=google_rich_qa
    public static function getLastRecipe() {
        $db = Database::getDb();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT @var := MAX(id) FROM recipes";
        $statement = $db->prepare($sql);
        $statement->execute();
        return $statement->fetch();
    }

    public static function getImageCount() {
        $db = Database::getDb();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT COUNT(img_src) FROM recipe_imgs";
        $statement = $db->prepare($sql);
        $statement->execute();
        return $statement->fetch();
    }

    public static function getLastImgId() {
        $db = Database::getDb();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT @var := MAX(id) FROM recipe_imgs";
        $statement = $db->prepare($sql);
        $statement->execute();
        return $statement->fetch();
    }

    public static function insertImage($recipes) {
        $db = Database::getDb();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql ="INSERT INTO recipe_imgs VALUES (null, :recipe_id, :img_src, null)";

        $recipe_id = $recipes->getRecipeId();
        $img_src = $recipes->getImgSrc();

        $statement = $db->prepare($sql);
        $statement->bindValue(":recipe_id", $recipe_id);
        $statement->bindValue(":img_src", $img_src);

        $insert = $statement->execute();
        return $insert;
    }


    //SEARCH FUNCTIONS - ADVANCED SEARCHES
    //DISPLAY ONLY RECIPE NAME
    public static function getRecipeDetailsByTitle($title) {
        $db = Database::getDb();

        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "SELECT * FROM recipes r JOIN recipe_imgs ri ON r.id = ri.recipe_id WHERE title LIKE '%$title%' GROUP BY ri.recipe_id";
        $statement = $db->prepare($query);
        $statement->bindValue(":title", $title, PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_OBJ);
    }
}
?>
