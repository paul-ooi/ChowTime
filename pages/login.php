<?php
$pageTitle = "Login/Register";
require_once 'partial/_header.php';
require_once 'db.php'; //Database Class file
require_once 'profile.php'; //Profile Logic file
require_once 'validation.php'; //Validation Library File

function checkLogin($db, $username, $passw)
{
	$sql = "SELECT id FROM profiles WHERE username = $username && pass = $passw";
	$pdostm = $db->prepare($sql);
        $pdostm->execute();
        $profile = $pdostm->fetch(PDO::FETCH_OBJ);
        return $profile;
}


if(isset($_POST['loginButton']))
{
	$username = $_POST['userName'];
	$pass = $_POST['pass'];
	//echo $pass;
	$hPass = password_hash($pass, PASSWORD_BCRYPT);
	//echo $hPass;
	$db = Database::getDb();
	$p = new Profile();
	
	
	$userID = checkLogin($db, $username, $hPass);
	var_dump($userID);
	if($userID)
	{
		echo "False";
	}
	else
	{
		echo $userID;
	}
}
?>
<link rel="stylesheet" type="text/css" href="../assets/css/whatsCooking.css"/>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/css/bootstrap-slider.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/bootstrap-slider.min.js"></script>
<script src="../assets/js/whatsCooking.js"></script>
</head>

<?php
require_once 'partial/_mainnav.php';
//require_once 'Whats-cooking.php';
?>
<main class="container ddwrapper  mb-5">
	<form action="login.php" method="post" name="login">
		<div class="row">
			<div class="form-group col-lg-6">
				<label name="userName" for="userName">Username</label>
				<input type="text" name="userName" id="userName" class="form-control"/>
				<label name="err_userName" for="userName" id="err_userName" ></label>
			</div>
			<div class="form-group col-lg-6">
				<label name="pass" for="pass">Password</label>
				<input type="password" name="pass" id="pass" class="form-control"/>
				<label name="err_pass" for="pass" id="err_pass" ></label>
			</div>
		</div>
		<div class="form-group">
				<button type="submit" name="loginButton" for="login" class="form-control">Login</button>
			</div>
		<div class="row">
			<div class="form-group col-lg-6">
				<h2>Not a user?</h2>
				<a href="index.php">Register your account</a>
			</div>
		</div>
	</form>

</main>

<?php
    require_once 'partial/_footer.php';
?>
</body>
</html>