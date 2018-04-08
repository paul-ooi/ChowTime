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
                ON r.made_id = rm.id
                JOIN recipe_imgs ri
                ON ri.recipe_id = r.id
                JOIN profiles p
                ON p.made_id = rm.id
                WHERE p.id = :id
                GROUP BY rm.user_id";

        $statement = $db->prepare($sql);
        $statement->bindValue(":id", $user_id, PDO::PARAM_INT);
        $statement->execute();
        $mapInfo = $statement->fetch();

        $wc = new WhatsCookingDB($mapInfo['address1'], $mapInfo['title'], $mapInfo['img_src']);

        return $mapInfo;
    }

    public static function whatsCookingAll() {
        $db = Database::getDb();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT p.address1, p.city, p.country, p.province, p.postal, r.title, ri.img_src, p.id
                FROM recipes r JOIN recipes_made rm
                ON r.made_id = rm.id
                JOIN recipe_imgs ri
                ON ri.recipe_id = r.id
                JOIN profiles p
                ON p.made_id = rm.id
                GROUP BY rm.user_id, p.id, r.made_id";
        $statement = $db->prepare($sql);
        $statement->execute();
        $rows = $statement->fetchAll();

        foreach($rows as $row) {
            $wc = new WhatsCookingDB($row['address1'], $row['city'], $row['country'], $row['province'], $row['postal'], $row['title'], $row['img_src']);
            $wc->setId($row['id']);

            $user[] = $wc;
        }

        return $user;

    }
}
 ?>
