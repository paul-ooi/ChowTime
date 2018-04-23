<?php
$pageTitle = "Edit Profile";
require_once 'partial/_header.php';

require_once '../models/db.php'; //Database Class file
require_once '../models/profile.php'; //Profile Logic file
require_once '../models/validation.php'; //Validation Library File

if(isset($_POST['createProfile']))
{
	$textRegex = '/^[a-z]+$/i';
	$passRegex = '/^\w+$/i';
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
    $pass = $_POST['pass'];
	$opassTTest = Validation::validateAlphaOnly($passRegex, $pass);
    $cpass = $_POST['cPass'];
	$cpassTTest = Validation::validateAlphaOnly($passRegex, $cpass);
	$passTest = Validation::confirmPass($pass,$cpass);
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
    
    $db = Database::getDb();
    $p = new Profile();
	if($fnameTest != 0  && $lnameTest != 0 && $usernameTest != 0 && $postalcTest != 0 && $emailTest != 0 && $cpassTTest != 0 && $cityTest != 0 && $countryTest != 0 && $provTest != 0 && $addr1Test != 0 && $passTest != 0)
	{
		$hashedPass = password_hash($pass, PASSWORD_BCRYPT);
		$count = $p->createProfile($db, $fname, $lname, $username, $email, $hashedPass, $addr1, $city, $country, $prov, $postalc, $admin);
		if($count)
		{
			header('Location: login.php');
		}
		else
		{
			echo "Account was not created";
		}
	}
	else
	{
		echo "Error";
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
<form action="createProfile.php" method="post" name="createP">
	<div class="row">
        <div class="form-group col-lg-6">
            <label name="fname" for="fname">First Name</label>
            <input type="text" name="fname" id="fname" class="form-control"/>
            <label name="err_fname" for="fname" id="err_fname" ></label>
        </div>
    </div>
    <div class="row">
		<div class="form-group col-lg-6">
            <label name="lname" for="lname">Last Name</label>
            <input type="text" name="lname" id="lname" class="form-control"/>
            <label name="err_lname" for="lname" id="err_lname" ></label>
        </div>
	</div>
	<div class="row">
        <div class="form-group col-lg-6">
            <label name="userName" for="userName">Username</label>
            <input type="text" name="userName" id="userName" class="form-control"/>
            <label name="err_userName" for="userName" id="err_userName" ></label>
        </div>
    </div>
    <div class="row">
		<div class="form-group col-lg-6">
            <label name="email" for="email">Email</label>
            <input type="text" name="email" id="email" class="form-control"/>
            <label name="err_email" for="email" id="err_email" ></label>
        </div>
	</div>
	<div class="row">
        <div class="form-group col-lg-6">
            <label name="pass" for="pass">Password</label>
            <input type="password" name="pass" id="pass" class="form-control"/>
            <label name="err_pass" for="pass" id="err_pass" ></label>
        </div>
    </div>
    <div class="row">
		<div class="form-group col-lg-6">
            <label name="cPass" for="cPass">Confirm Password</label>
            <input type="password" name="cPass" id="cPass" class="form-control"/>
            <label name="err_cPass" for="cPass" id="err_cPass" ></label>
        </div>
	</div>
	<div class="row">
        <div class="form-group col-lg-6">
            <label name="country" for="country">Country</label>
            <label name="err_country" for="country" id="err_country" ></label>
			<select name="country" id="country" class="form-control">
                <option value="">--Select your Country--</option>
                <option value="Canada">Canada</option>
            </select>
        </div>
    </div>
    <div class="row">
		<div class="form-group col-lg-6">
            <label name="state" for="state">Province/State</label>
            <label name="err_state" for="state" id="state" ></label>
			<select name="state" id="state" class="form-control">
                <option value="">--Select your Province--</option>
                <option value="ON">Ontario</option>
                <option value="QC">Quebec</option>
                <option value="BC">British Columbia</option>
                <option value="AB">Alberta</option>
                <option value="MB">Manitoba</option>
                <option value="SK">Saskatchewan</option>
                <option value="NS">Nova Scotia</option>
                <option value="NB">New Brunswick</option>
                <option value="NL">Newfoundland and Labrador</option>
                <option value="PE">Prince Edward Island</option>
                <option value="NT">Northwest Territories</option>
                <option value="NU">Nunavut</option>
                <option value="YT">Yukon</option>
            </select>
        </div>
	</div>
	<div class="row">
        <div class="form-group col-lg-6">
            <label name="add1" for="add1">Address #1</label>
            <input type="text" name="add1" id="add1" class="form-control"/>
            <label name="err_add1" for="add1" id="err_add1" ></label>
        </div>
    </div>
    <div class="row">
		<div class="form-group col-lg-6">
            <label name="city" for="city">City</label>
            <input type="text" name="city" id="city" class="form-control"/>
            <label name="err_city" for="city" id="err_city"></label>
        </div>
	</div>
    <div class="row">
		<div class="form-group col-lg-6">
            <label name="pcode" for="pcode">Postal Code</label>
            <input type="text" name="pcode" id="pcode" class="form-control"/>
            <label name="err_pcode" for="pcode" id="err_pcode"></label>
        </div>
	</div>
    <div class="row">
        <div class="form-group">
            <button type="submit" name="createProfile" for="createP" class="form-control">Create Profile</button>
        </div>
    </div>
	</main>

<?php
    require_once 'partial/_footer.php';
?>
</body>
</html>