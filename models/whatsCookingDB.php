<?php

class WhatsCooking {
    public static function getAllAddresses() {
        $db = Database::getDb();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT address1 FROM profiles";
        $statement = $db->prepare($sql);
        $statement->execute(PDO::FETCH_OBJ);

        $addresses = $statement->fetchAll();

        return $addresses;
    }

    public static function addUserCooking($user_id) {
        $db = Database::getDb();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT DISTINCT p.address1, r.title, ri.img_src
            FROM recipes r JOIN recipes_made rm
            ON r.id = rm.recipe_id
            JOIN recipe_imgs ri
            ON ri.recipe_id = r.id
            JOIN profiles p
            ON p.id = rm.user_id
            WHERE p.id = :id
            GROUP BY rm.user_id";

        $statement = $db->prepare($sql);
        $statement->bindValue(":id", $user_id, PDO::PARAM_INT);
        $statement->execute();
        $mapInfo = $statement->fetch();

        $wc = new WhatsCookingDB($mapInfo['id']);
        $wc->setTitle($mapInfo['title']);
        $wc->setAdd($mapInfo['address1']);
        $wc->setImg($mapInfo['img_src']);

        return $mapInfo;
    }

    public static function whatsCookingAll() {
        $db = Database::getDb();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT DISTINCT r.id AS recipe_id, p.address1, p.city, p.country, p.province, p.postal, r.title, ri.img_src, p.id
                FROM recipes r JOIN recipes_made rm
                ON r.id = rm.recipe_id
                JOIN recipe_imgs ri
                ON ri.recipe_id = r.id
                JOIN profiles p
                ON p.id = rm.user_id
                GROUP BY rm.user_id, p.id, r.id;";
        $statement = $db->prepare($sql);
        $statement->execute();
        $rows = $statement->fetchAll();

        foreach($rows as $row) {
            $wc = new WhatsCookingDB(
                $row['id']);
                $wc->setRecipeId($row['recipe_id']);
                $wc->setAdd($row['address1']);
                $wc->setCity($row['city']);
                $wc->setCountry($row['country']);
                $wc->setProv($row['province']);
                $wc->setPost($row['postal']);
                $wc->setTitle($row['title']);
                $wc->setImg($row['img_src']);
                $user[] = $wc;
        }
        return $user;
    }

    public static function userAddress($user_id) {
        $db = Database::getDb();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT DISTINCT p.address1, p.city, p.country, p.province, p.postal, r.title, ri.img_src, p.id
                FROM recipes r JOIN recipes_made rm
                ON r.id = rm.recipe_id
                JOIN recipe_imgs ri
                ON ri.recipe_id = r.id
                JOIN profiles p
                ON p.id = rm.user_id
                WHERE p.id = :id
                GROUP BY rm.user_id, p.id, r.id";
        $statement = $db->prepare($sql);
        $statement->bindValue(":id", $user_id, PDO::PARAM_INT);
        $statement->execute();
        $address = $statement->fetch();

        $wc = new WhatsCookingDB($address['id']);
        $wc->setAdd($address['address1']);
        $wc->setCity($address['city']);
        $wc->setCountry($address['country']);
        $wc->setProv($address['province']);
        $wc->setPost($address['postal']);
        $user['address'] = $wc;
        return $user;
    }
}
 ?>
