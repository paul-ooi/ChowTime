<?php
$pageTitle = "Edit Profile";
require_once 'partial/_header.php';
?>
<link rel="stylesheet" type="text/css" href="../assets/css/whatsCooking.css"/>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/css/bootstrap-slider.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/bootstrap-slider.min.js"></script>
<script src="../assets/js/whatsCooking.js"></script>
</head>

<?php
require_once 'partial/_mainnav.php';
require_once 'Whats-cooking.php';
?>
	<main class="container ddwrapper  mb-5">
<form action="contactus.php" method="post" name="contact">
	<div class="row">
        <div class="form-group col-lg-6">
            <label name="cFirst" for="cFirst">First Name</label>
            <input type="text" name="cFirst" id="cFirst" class="form-control"/>
            <label name="err_cFirst" for="cFirst" id="err_cFirst" ></label>
        </div>
		<div class="form-group col-lg-6">
            <label name="cLast" for="cLast">Last Name</label>
            <input type="text" name="cLast" id="cLast" class="form-control"/>
            <label name="err_cLast" for="cLast" id="err_cLast" ></label>
        </div>
	</div>
	<div class="row">
        <div class="form-group col-lg-6">
            <label name="cUserN" for="cUserN">Username</label>
            <input type="text" name="cUserN" id="cUserN" class="form-control"/>
            <label name="err_cUserN" for="cUserN" id="err_cUserN" ></label>
        </div>
		<div class="form-group col-lg-6">
            <label name="cEmail" for="cEmail">Email</label>
            <input type="text" name="cEmail" id="cEmail" class="form-control"/>
            <label name="err_cEmail" for="cEmail" id="err_cEmail" ></label>
        </div>
	</div>
	<div class="row">
        <div class="form-group col-lg-6">
            <label name="cPass" for="cPass">Password</label>
            <input type="password" name="cPass" id="cPass" class="form-control"/>
            <label name="err_cPass" for="cPass" id="err_cPass" ></label>
        </div>
		<div class="form-group col-lg-6">
            <label name="cPass2" for="cPass2">Confirm Password</label>
            <input type="password" name="cPass2" id="cPass2" class="form-control"/>
            <label name="err_cPass2" for="cPass2" id="err_cPass2" ></label>
        </div>
	</div>
	<div class="row">
        <div class="form-group col-lg-6">
            <label name="country" for="country">Country</label>
            <label name="err_country" for="country" id="err_country" ></label>
			<select name="cIssue" id="cIssue" class="form-control">
                <option value="">--Select your Country--</option>
                <option value="db">Pull from DB</option>
                <option value="db">Pull from DB</option>
                <option value="db">Pull from DB</option>
                <option value="db">Pull from DB</option>
                <option value="db">Pull from DB</option>
                <option value="db">Pull from DB</option>
            </select>
        </div>
		<div class="form-group col-lg-6">
            <label name="state" for="state">Province/State</label>
            <label name="err_state" for="state" id="state" ></label>
			<select name="cIssue" id="cIssue" class="form-control">
                <option value="">--Select your Province--</option>
                <option value="db">Pull from DB</option>
                <option value="db">Pull from DB</option>
                <option value="db">Pull from DB</option>
                <option value="db">Pull from DB</option>
                <option value="db">Pull from DB</option>
                <option value="db">Pull from DB</option>
            </select>
        </div>
	</div>
	<div class="row">
        <div class="form-group col-lg-6">
            <label name="add1" for="add1">Address #1</label>
            <input type="text" name="add1" id="add1" class="form-control"/>
            <label name="err_add1" for="add1" id="err_add1" ></label>
        </div>
		<div class="form-group col-lg-6">
            <label name="pcode" for="pcode">Postal Code</label>
            <input type="text" name="pcode" id="pcode" class="form-control"/>
            <label name="err_pcode" for="pcode" id="err_pcode"></label>
        </div>
		<div class="form-group">
            <button type="submit" name="cSubmitBtn" for="contact" class="form-control">Submit</button>
        </div>
	</div>
	</main>

<?php
    require_once 'partial/_footer.php';
?>
</body>
</html>