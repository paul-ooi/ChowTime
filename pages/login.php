<?php
session_start();
unset($_SESSION['user_id']);
$pageTitle = "Login/Register";
require_once 'partial/_header.php';
require_once '../models/db.php'; //Database Class file
require_once '../models/profile.php'; //Profile Logic file
require_once '../models/validation.php'; //Validation Library File

$loginError = "";

if(isset($_POST['loginButton']))
{
	
	$username = $_POST['userName'];
	$pass = $_POST['pass'];
	//echo $pass;
	$hPass = password_hash($pass, PASSWORD_BCRYPT);
	//echo $hPass;
	$db = Database::getDb();
	$p = new Profile();
	$profiles = $p->getAllProfiles($db);
	foreach($profiles as $user)
	{
		if($user->username == $username)
		{
			if(password_verify($pass, $user->pass))
			{
				$_SESSION['user_id'] = $user->id;
				$_SESSION['role'] = $user->admin;
				header("Location: ../index.php");
			}
			else
			{
				$loginError = "Invalid username/password";
			}
			
		}
		else
		{
			$loginError = "Invalid username/password";
		}
	}
}
?>
<link rel="stylesheet" type="text/css" href="../assets/css/whatsCooking.css"/>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/css/bootstrap-slider.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/bootstrap-slider.min.js"></script>
</head>

<?php
require_once 'partial/_mainnav.php';
?>
<main class="container ddwrapper  mb-5">
	<form action="login.php" method="post" name="login">
		<div class="row">
			<div class="form-group col-lg-6 offset-lg-3">
				<div class="form-group">
					<label name="userName" for="userName">Username</label>
					<input type="text" name="userName" id="userName" class="form-control"/>
					<label name="err_userName" for="userName" id="err_userName"></label>
				</div>
				<div class="form-group">
					<label name="pass" for="pass">Password</label>
					<input type="password" name="pass" id="pass" class="form-control"/>
					<label name="err_pass" for="pass" id="err_pass" ></label>
				</div>
				<div class="form-group">
					<button type="submit" name="loginButton" for="login" class="form-control">Login</button>
					<?php echo $loginError ?>
				</div>
				<div class="row">
					<div class="form-group col-lg-6">
						<h3>Not a user?</h3>
						<a href="createProfile.php">Register your account!</a>
					</div>
				</div>
			</div>
		</div>
		
		
	</form>

</main>

<?php
    require_once 'partial/_footer.php';
?>
</body>
</html>