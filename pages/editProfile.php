<?php
session_start();
$pageTitle = "Edit Profile";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php';
require_once 'partial/_header.php';
require_once '../models/db.php'; //Database Class file
require_once '../models/profile.php'; //Profile Logic file
require_once '../models/validation.php'; //Validation Library File

$db = Database::getDb();
$p = new Profile();

$userProfile = $p->getProfileById($db, $_SESSION['user_id']);

$onSel = "";
$qcSel = "";
$bcSel = "";
$abSel = "";
$mbSel = "";
$skSel = "";
$nsSel = "";
$nbSel = "";
$nlSel = "";
$peSel = "";
$ntSel = "";
$nuSel = "";
$ytSel = "";

if($userProfile->country == "Canada")
{
	$canSel = "selected";
}
if($userProfile->province == "ON")
{
	$onSel = "selected";
}
else if($userProfile->province == "QC")
{
	$qcSel = "selected";
}
else if($userProfile->province == "BC")
{
	$bcSel = "selected";
}
else if($userProfile->province == "AB")
{
	$abSel = "selected";
}
else if($userProfile->province == "MB")
{
	$mbSel = "selected";
}
else if($userProfile->province == "SK")
{
	$skSel = "selected";
}
else if($userProfile->province == "NS")
{
	$nsSel = "selected";
}
else if($userProfile->province == "NB")
{
	$nbSel = "selected";
}
else if($userProfile->province == "NL")
{
	$nlSel = "selected";
}
else if($userProfile->province == "PE")
{
	$peSel = "selected";
}
else if($userProfile->province == "NT")
{
	$ntSel = "selected";
}
else if($userProfile->province == "NU")
{
	$nuSel = "selected";
}
else if($userProfile->province == "YT")
{
	$ytSel = "selected";
}

if(isset($_POST['editProfile']))
{
	$textRegex = '/^[a-z]+$/i';
	$addRegex = '/\w+(\s\w+){2,}/';
	$cityRegex = '/(\w+\s?){1,}/';
    $fname = $_POST['fname'];
	$fnameTest = Validation::validateAlphaOnly($textRegex, $fname);
    $lname = $_POST['lname'];
	$lnameTest = Validation::validateAlphaOnly($textRegex, $lname);
    $username = $_POST['userName'];
	$usernameTest = Validation::validateAlphaOnly($textRegex, $username);
    $email = $_POST['email'];
	$emailTest = Validation::email($email);
    $addr1 = $_POST['add1'];
	$addr1Test = Validation::validateAlphaOnly($addRegex, $addr1);
    $city = $_POST['city'];
	$cityTest = Validation::validateAlphaOnly($cityRegex, $city);
    $country = $_POST['country'];
	$countryTest = Validation::validateDD($country);
    $prov = $_POST['state'];
	$provTest = Validation::validateDD($prov);
    $postalc = $_POST['pcode'];
	$postalcTest = Validation::postalCode($postalc);
    $admin = 0;
    $imageError = 1;
	$db = Database::getDb();
    $p = new Profile();
	$target_dir = "../images/profileImages/";
	$noImage = 0;
	
	if($_FILES['pimage']['name'] != "")
	{
		$imageFileType = strtolower(pathinfo($_FILES['pimage']['name'],PATHINFO_EXTENSION));
		$_FILES['pimage']['name'] = $_SESSION['user_id'] . "pimage." . $imageFileType;
		$target_file = $target_dir . basename($_FILES['pimage']['name']);
		if ($_FILES['pimage']['size'] > 500000) {
			echo "Sorry, your file is too large.";
			$imageError = 0;
		}
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
			echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			$imageError = 0;
		}
		if($imageError == 0)
		{
			echo "No dice";
		}
		else
		{
			if(move_uploaded_file($_FILES['pimage']['tmp_name'], $target_file))
			{
				//Upload cleared
			} 
			else
			{
				echo "There was an error uploading the file, please try again!";
			}
		}
	}
	else
	{
		$noImage = 1;
	}
    if($fnameTest != 0  && $lnameTest != 0 && $usernameTest != 0 && $postalcTest != 0 && $emailTest != 0 && $cityTest != 0 && $countryTest != 0 && $provTest != 0 && $addr1Test != 0)
	{
		if($noImage == 1)
		{
			$count = $p->updateProfile($db, $_SESSION['user_id'], $fname, $lname, $username, $email, $addr1, $city, $country, $prov, $postalc);
			if($count)
			{
				header('Location: editProfile.php');
			}
			else
			{
				echo "Account was not updated";
			}
		}
		else
		{
			$count = $p->updateProfileImage($db, $_SESSION['user_id'], $fname, $lname, $username, $email,  $addr1, $city, $country, $prov, $postalc, $target_file);
			if($count)
			{
				header('Location: editProfile.php');
			}
			else
			{
				echo "Account was not updated";
			}
		}
	}
	else
	{
		echo "Error";
	}
    
}
if(isset($_POST['changePassword']))
{
	$passRegex = '/^\w+$/i';
	$pass = $_POST['pass'];
	$opassTTest = Validation::validateAlphaOnly($passRegex, $pass);
    $cpass = $_POST['cPass'];
	$cpassTTest = Validation::validateAlphaOnly($passRegex, $cpass);
	$passTest = Validation::confirmPass($pass,$cpass);
	
	
	$hashedPass = password_hash($pass, PASSWORD_BCRYPT);
	
	if($cpassTTest != 0  && $passTest != 0)
	{
		$count = $p->updatePassword($db, $_SESSION['user_id'], $hashedPass);
		if($count)
		{
			header('Location: editProfile.php');
		}
		else
		{
			echo "Password was not updated";
		}
	}
}

?>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/css/bootstrap-slider.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/bootstrap-slider.min.js"></script>
</head>

<?php
require_once 'partial/_mainnav.php';
?>
<main class="container ddwrapper  mb-5">

<form action="editProfile.php" enctype="multipart/form-data" method="POST">
	<div class="row">
		<div class="form-group col-lg-6 offset-lg-3">
			<h2>Edit Profile Information</h2>
		</div>
		<div class="form-group col-lg-6 offset-lg-3">
			<div class="form-group">
				<label name="fname" for="fname">First Name</label>
				<input type="text" name="fname" id="fname" class="form-control" value="<?php echo $userProfile->fname; ?>"/>
				<label name="err_fname" for="fname" id="err_fname" ></label>
			</div>
		</div>
		<div class="form-group col-lg-6 offset-lg-3">
			<div class="form-group">
				<label name="lname" for="lname">Last Name</label>
				<input type="text" name="lname" id="lname" class="form-control" value="<?php echo $userProfile->lname; ?>"/>
				<label name="err_lname" for="lname" id="err_lname" ></label>
			</div>
		</div>
		<div class="form-group col-lg-6 offset-lg-3">
			<div class="form-group">
				<label name="pimage" for="pimage">Profile Picture</label>
				<input type="file" name="pimage" id="pimage" class="form-control"/>
				<label name="err_pimage" for="pimage" id="err_pimage" ></label>
			</div>
		</div>
		<div class="form-group col-lg-6 offset-lg-3">
			<div class="form-group">
				<label name="userName" for="userName">Username</label>
				<input type="text" name="userName" id="userName" class="form-control" value="<?php echo $userProfile->username; ?>"/>
				<label name="err_userName" for="userName" id="err_userName" ></label>
			</div>
		</div>
		<div class="form-group col-lg-6 offset-lg-3">
			<div class="form-group">
				<label name="email" for="email">Email</label>
				<input type="text" name="email" id="email" class="form-control" value="<?php echo $userProfile->email; ?>"/>
				<label name="err_email" for="email" id="err_email" ></label>
			</div>
		</div>
		<div class="form-group col-lg-6 offset-lg-3">
			<div class="form-group">
				<label name="country" for="country">Country</label>
				<label name="err_country" for="country" id="err_country" ></label>
				<select name="country" id="country" class="form-control">
					<option value="">--Select your Country--</option>
					<option value="Canada" <?php echo $canSel; ?>>Canada</option>
				</select>
			</div>
		</div>
		<div class="form-group col-lg-6 offset-lg-3">
			<div class="form-group">
				<label name="state" for="state">Province/State</label>
				<label name="err_state" for="state" id="state" ></label>
				<select name="state" id="state" class="form-control">
					<option value="">--Select your Province--</option>
					<option value="ON" <?php echo $onSel; ?>>Ontario</option>
					<option value="QC" <?php echo $qcSel; ?>>Quebec</option>
					<option value="BC" <?php echo $bcSel; ?>>British Columbia</option>
					<option value="AB" <?php echo $abSel; ?>>Alberta</option>
					<option value="MB" <?php echo $mbSel; ?>>Manitoba</option>
					<option value="SK" <?php echo $skSel; ?>>Saskatchewan</option>
					<option value="NS" <?php echo $nsSel; ?>>Nova Scotia</option>
					<option value="NB" <?php echo $nbSel; ?>>New Brunswick</option>
					<option value="NL" <?php echo $nlSel; ?>>Newfoundland and Labrador</option>
					<option value="PE" <?php echo $peSel; ?>>Prince Edward Island</option>
					<option value="NT" <?php echo $ntSel; ?>>Northwest Territories</option>
					<option value="NU" <?php echo $nuSel; ?>>Nunavut</option>
					<option value="YT" <?php echo $ytSel; ?>>Yukon</option>
				</select>
			</div>
		</div>
		<div class="form-group col-lg-6 offset-lg-3">
			<div class="form-group">
				<label name="add1" for="add1">Address #1</label>
				<input type="text" name="add1" id="add1" class="form-control" value="<?php echo $userProfile->address1; ?>"/>
				<label name="err_add1" for="add1" id="err_add1" ></label>
			</div>
		</div>
		<div class="form-group col-lg-6 offset-lg-3">
			<div class="form-group">
				<label name="city" for="city">City</label>
				<input type="text" name="city" id="city" class="form-control" value="<?php echo $userProfile->city; ?>"/>
				<label name="err_city" for="city" id="err_city"></label>
			</div>
		</div>
		<div class="form-group col-lg-6 offset-lg-3">
			<div class="form-group">
				<label name="pcode" for="pcode">Postal Code</label>
				<input type="text" name="pcode" id="pcode" class="form-control" value="<?php echo $userProfile->postal; ?>"/>
				<label name="err_pcode" for="pcode" id="err_pcode"></label>
			</div>
		</div>
		<div class="form-group col-lg-6 offset-lg-3">
			<div class="form-group">
				<button type="submit" name="editProfile" for="editP" class="form-control">Edit Profile</button>
			</div>
		</div>
	</div>
</form>
<form action="editProfile.php" enctype="multipart/form-data" method="POST">
	<div class="row">
		<div class="form-group col-lg-6 offset-lg-3">
			<h2>Change Password</h2>
		</div>
		<div class="form-group col-lg-6 offset-lg-3">
			<div class="form-group">
				<label name="pass" for="pass">Password</label>
				<input type="password" name="pass" id="pass" class="form-control"/>
				<label name="err_pass" for="pass" id="err_pass" ></label>
			</div>
		</div>
		<div class="form-group col-lg-6 offset-lg-3">
			<div class="form-group">
				<label name="cPass" for="cPass">Confirm Password</label>
				<input type="password" name="cPass" id="cPass" class="form-control"/>
				<label name="err_cPass" for="cPass" id="err_cPass" ></label>
			</div>
		</div>
		<div class="form-group col-lg-6 offset-lg-3">
			<div class="form-group">
				<button type="submit" name="changePassword" for="changeP" class="form-control">Change Password</button>
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