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

    //SELECT BY DATETIME BY DATE AND TIME
    public static function displayDateTime($in_id) {
        $db = Database::getDb();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "SELECT date(pub_date) as d, time(pub_date) as t FROM recipes WHERE id = :id";

        $statement = $db->prepare($query);
        $statement->bindValue(":id", $in_id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_OBJ);
    }

    //ADD A RECIPE
    public static function addRecipe($recipe) {
        $db = Database::getDb();

        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "INSERT INTO recipes VALUES (:id, :userid, :img_id, :title, :descr, SEC_TO_TIME(:p_time*60), SEC_TO_TIME(:c_time*60), :dish, :ingred, :diff, :spicy, null, :steps)";

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
        $statement->bindValue(':userid', $user_id, PDO::PARAM_INT);
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
    public static function updateRecipe($recipe) {
        $db = Database::getDb();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "UPDATE recipes SET 
                    title = :title,
                    description = :descr,
                    prep_time = SEC_TO_TIME(:prep*60),
                    cook_time = SEC_TO_TIME(:cook*60),
                    dishes_lvl = :dish,
                    ingred_lvl = :ingred,
                    diff_lvl = :diff,
                    spicy_lvl = :spice,
                    pub_date = :pub_date,
                    steps = :steps
                    WHERE id = :recipe_id";

        $id = $recipe->getId();
        $title = $recipe->getTitle();
        $descr = $recipe->getDescr();
        $prep = $recipe->getPrepTime();
        $cook = $recipe->getCookTime();
        $dish = $recipe->getDishLvl();
        $ingred = $recipe->getIngredLvl();
        $diff = $recipe->getDiffLvl();
        $spicy = $recipe->getSpicyLvl();
        $pub = $recipe->getPubDate();
        $steps = $recipe->getSteps();

        $statement = $db->prepare($query);

        $statement->bindValue(":title", $title, PDO::PARAM_STR);
        $statement->bindValue(":descr", $descr, PDO::PARAM_STR);
        $statement->bindValue(":prep", $prep, PDO::PARAM_INT);
        $statement->bindValue(":cook", $cook, PDO::PARAM_INT);
        $statement->bindValue(":dish", $dish, PDO::PARAM_INT);
        $statement->bindValue(":ingred", $ingred, PDO::PARAM_INT);
        $statement->bindValue(":diff", $diff, PDO::PARAM_INT);
        $statement->bindValue(":spice", $spicy, PDO::PARAM_INT);
        $statement->bindValue(":pub_date", $pub);
        $statement->bindValue(":steps", $steps);
        $statement->bindValue(":recipe_id", $id);

        $statement->setFetchMode(PDO::FETCH_OBJ);
        $count = $statement->execute();
        return $count;
    }
    //DELETE A RECIPE FROM IMG AND RECIPE TABLE AT ONCE
    public static function deleteRecipe($id) {
        $db = Database::getDb();

        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "DELETE recipes, recipe_imgs 
        FROM recipes JOIN recipe_imgs 
        WHERE recipes.id = :id AND recipe_imgs.recipe_id = :id";
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

    public static function getLastImgId() {
        $db = Database::getDb();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT @var := MAX(id) FROM recipe_imgs";
        $statement = $db->prepare($sql);
        $statement->execute();
        return $statement->fetch();
    }

    public static function updateMainImage($recipe) {
        $db = Database::getDb();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE recipes SET main_img_id = :img_id WHERE id = :recipe_id";
        $statement = $db->prepare($sql);

        $recipe_id = $recipe->getRecipeId();
        $img_id = $recipe->getImgId();

        $statement->bindValue(":img_id", $img_id);
        $statement->bindValue(":recipe_id", $recipe_id);
        return $statement->execute();
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

    //SEARCH FUNCTION
    //DISPLAY BASED ON RECIPE NAME
    public static function getRecipeDetailsByTitle($title) {
        $db = Database::getDb();
        $title = strtoupper($title);

        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "SELECT * FROM recipes r JOIN recipe_imgs ri ON r.id = ri.recipe_id WHERE UPPER(r.title) LIKE '%$title%' GROUP BY ri.recipe_id";
        $statement = $db->prepare($query);
        $statement->bindValue(":title", $title, PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    //IN RECIPE ID
    public static function getRecipeOwner($id) {
        $db = Database::getDb();

        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "SELECT user_id FROM recipes WHERE id = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(":id", $id, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }

    //GET RECIPE FROM TIME TO MINUTES
    public function getRecipeTimeInMin($id) {
        $db = Database::getDb();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "SELECT ROUND((TIME_TO_SEC(prep_time))/60,0) as CT, ROUND((TIME_TO_SEC(cook_time))/60,0) as PT FROM recipes WHERE id = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(":id", $id);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_OBJ);
    } 

    public function deleteImg($img_src) {
        $db = Database::getDb();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "DELETE FROM recipe_imgs WHERE img_src = :img_src";

        $statement = $db->prepare($query);
        $statement->bindValue(":img_src", $img_src);
        $count = $statement->execute();
        return $count;    
    }

    //GET MAIN RECIPE IMAGE ID BY RECIPE ID
    public static function getMainImgId($recipe_id) {
        $db = Database::getDb();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "SELECT main_img_id FROM recipes WHERE id = :id";

        $statement = $db->prepare($query);
        $statement->bindValue(":id", $recipe_id);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_OBJ);
    }

    //GET IMAGE ID FROM IMG SRC
    public static function getImgIdFromSrc($imgSrc) {
        $db = Database::getDb();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "SELECT id FROM recipe_imgs WHERE img_src = :img_src";

        $statement = $db->prepare($query);
        $statement->bindValue(":img_src", $imgSrc);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_OBJ);
    }

    public static function getRecipeIdFromSrc($imgSrc) {
        $db = Database::getDb();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "SELECT recipe_id FROM recipe_imgs WHERE img_src = :img_src";
        $statement = $db->prepare($query);
        $statement->bindValue(":img_src", $imgSrc);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_OBJ);
    }

    public static function updateRecipeMainImgId($img_src_id, $recipe_id) {
        $db = Database::getDb();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);        
        $query = "UPDATE recipes SET main_img_id = :img_src_id WHERE id = :recipe_id";

        $statement = $db->prepare($query);
        $statement->bindValue(":img_src_id", $img_src_id);
        $statement->bindValue(":recipe_id", $recipe_id);
        $count = $statement->execute();

        return $count;
    }

    public static function getRecentPublishedRecipe() {
        $db = Database::getDb();
        $db->setAttribute(PDO::ERRMODE_EXCEPTION, PDO::ATTR_ERRMODE);
        $query = "SELECT MAX(pub_date) AS pub_date, id FROM recipes GROUP BY pub_date ORDER BY pub_date desc";

        $statement = $db->prepare($query);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_OBJ);

    }

    public static function getUserRole($user_id) {
        $db = Database::getDb();
        $db->setAttribute(PDO::ERRMODE_EXCEPTION, PDO::ATTR_ERRMODE);
        $query = "SELECT admin FROM profiles WHERE id = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(":id", $user_id);
        $statement->execute();
        $int = $statement->fetch();

        return $int;
    }

    public static function getImgSrc($recipe_id) {
        $db = Database::getDb();
        $r = new Recipes();
        $db->setAttribute(PDO::ERRMODE_EXCEPTION, PDO::ATTR_ERRMODE);
        $query = "SELECT img_src FROM recipe_imgs WHERE recipe_id = :recipe_id";

        $statement = $db->prepare($query);
        $statement->bindValue(":recipe_id", $recipe_id);
        $statement->execute();
        $rows = $statement->fetchAll(PDO::FETCH_OBJ);

        foreach($rows as $img) {
            $r = new Recipes();
            $r->setImgSrc($img->img_src);
            $images[] = $r;
        }
        return $images;
    }
}
?>
