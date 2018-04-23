<?php
class Profile
{
    public function createProfile($db, $fname, $lname, $username, $email, $pass, $addr1, $city, $country, $prov, $postalc, $admin)
    {
        $sql = "INSERT INTO profiles (fname, lname, username, email, pass, address1, city, country, province, postal, admin) VALUES ('$fname', '$lname', '$username', '$email', '$pass', '$addr1', '$city', '$country', '$prov', '$postalc', '$admin')";
        $pdostm = $db->prepare($sql);
        $count = $pdostm->execute();
        
        return $count;
    }
    public function getAllProfiles($db)
    {
        $sql = "SELECT * FROM profiles";
        $pdostm = $db->prepare($sql);
        $pdostm->setFetchMode(PDO::FETCH_OBJ);
        $pdostm->execute();
        
        return $pdostm->fetchAll();
    }
    public function deleteProfile($db, $id)
    {
        $query = "DELETE FROM profiles WHERE id=:id";
        $pdostm = $db->prepare($query);
        $pdostm->bindValue(':id', $id, PDO::PARAM_INT);
        $count = $pdostm->execute();
        return $count;
    }
    public function getProfileById($db, $id)
    {
        $sql = "SELECT * FROM profiles WHERE id = $id";
        $pdostm = $db->prepare($sql);
        $pdostm->execute();
        $profile = $pdostm->fetch(PDO::FETCH_OBJ);
        return $profile;
    }
	public function checkLogin($db, $username)
	{
		$sql = "SELECT * FROM profiles WHERE username = $username";
        $pdostm = $db->prepare($sql);
        $pdostm->setFetchMode(PDO::FETCH_OBJ);
        $pdostm->execute();
        
        return $pdostm->fetchAll();
	}
    public function updateProfile($db, $id, $fname, $lname, $username, $email, $addr1, $city, $country, $prov, $postalc)
    {
        $sql = "UPDATE profiles SET fname = '$fname', lname = '$lname', username = '$username', email = '$email', address1 = '$addr1', city = '$city', country = '$country', province = '$prov', postal = '$postalc' WHERE id = $id";
        $pdostm = $db->prepare($sql);
        $count = $pdostm->execute();
        return $count;
    }
	public function updateProfileImage($db, $id, $fname, $lname, $username, $email, $addr1, $city, $country, $prov, $postalc, $pimage)
    {
        $sql = "UPDATE profiles SET fname = '$fname', lname = '$lname', username = '$username', email = '$email', address1 = '$addr1', city = '$city', country = '$country', province = '$prov', postal = '$postalc', pimage = '$pimage' WHERE id = $id";
        $pdostm = $db->prepare($sql);
        $count = $pdostm->execute();
        return $count;
    }
	public function updatePassword($db, $id, $pass)
	{
		$sql = "UPDATE profiles SET pass = '$pass' WHERE id = $id";
		$pdostm = $db->prepare($sql);
        $count = $pdostm->execute();
        return $count;
	}
	public function usersRecipeMade($db, $id) {
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "SELECT * FROM recipes_made WHERE user_id = :id";
        $pdostm = $db->prepare($query);
        $pdostm->bindValue(":id", $id, PDO::PARAM_INT);
		$pdostm->setFetchMode(PDO::FETCH_OBJ);
        $pdostm->execute();
        
        return $pdostm->fetchAll();
    }
	public function recipeById($db, $id)
	{
		$sql = "SELECT * FROM recipes r JOIN recipe_imgs ri ON r.id = ri.recipe_id WHERE r.id = $id";
        $pdostm = $db->prepare($sql);
        $pdostm->execute();
        $profile = $pdostm->fetch(PDO::FETCH_OBJ);
        return $profile;
	}
	public function userRecipes($db, $id) {
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "SELECT * FROM recipes WHERE user_id = :id";
        $pdostm = $db->prepare($query);
        $pdostm->bindValue(":id", $id, PDO::PARAM_INT);
		$pdostm->setFetchMode(PDO::FETCH_OBJ);
        $pdostm->execute();
        
        return $pdostm->fetchAll();
    }
}