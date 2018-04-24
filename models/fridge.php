<?php
class Fridge
{
	
	
	public function getAllFridgeById($db, $id)
	{
		$sql = "SELECT * FROM fridge f JOIN ingredients i ON f.ing_id = i.id WHERE f.user_id = $id";
        $pdostm = $db->prepare($sql);
        $pdostm->execute();
        $pdostm->execute();
        
        return $pdostm->fetchAll();
	}
	
	public function getAllFridgeHistoryById($db, $id)
	{
		$sql = "SELECT * FROM fridge_history fh 
				JOIN ingredients i ON fh.ing_id = i.id
				WHERE fh.user_id = $id";
        $pdostm = $db->prepare($sql);
        $pdostm->execute();
        $pdostm->execute();
        
        return $pdostm->fetchAll();
	}
	
	public function deleteFridgeItemById($db, $id, $user_id, $ing_id)
	{
		date_default_timezone_set("America/Toronto");
		$pubdate = date("Y-m-d H:i:s");
		$sql = "DELETE FROM fridge WHERE id=$id";
        $pdostm = $db->prepare($sql);
        $count = $pdostm->execute();
		
		$lastTrans = 0;
		$sql2 = "INSERT INTO fridge_history (ing_id, user_id, last_trans, pubdate) VALUES ('$ing_id', '$user_id', '$lastTrans', '$pubdate')";
		$pdostm2 = $db->prepare($sql2);
		$pdostm2->execute();
		
		return $count;
	}
	
	public function addFridgeItemById($db, $user_id, $ing_id)
	{
		date_default_timezone_set("America/Toronto");
		$pubdate = date("Y-m-d H:i:s");
		$sql = "INSERT INTO fridge (ing_id, user_id, pubdate) VALUES ('$ing_id', '$user_id', '$pubdate')";
        $pdostm = $db->prepare($sql);
        $count = $pdostm->execute();
		
		$lastTrans = 1;
		$sql2 = "INSERT INTO fridge_history (ing_id, user_id, last_trans, pubdate) VALUES ('$ing_id', '$user_id', '$lastTrans', '$pubdate')";
		$pdostm2 = $db->prepare($sql2);
		$pdostm2->execute();
        
        return $count;
	}
	
	public function getIngredients($db)
	{
		$sql = "SELECT * FROM ingredients order by food_name";
        $pdostm = $db->prepare($sql);
        $pdostm->setFetchMode(PDO::FETCH_OBJ);
        $pdostm->execute();
        
        return $pdostm->fetchAll();
	}
}
?>