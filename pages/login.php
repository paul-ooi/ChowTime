<?php
$pageTitle = "Login/Register";
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
				<label name="cUserN" for="cUserN">Username</label>
				<input type="text" name="cUserN" id="cUserN" class="form-control"/>
				<label name="err_cUserN" for="cUserN" id="err_cUserN" ></label>
			</div>
			<div class="form-group col-lg-6">
				<label name="cPass" for="cPass">Password</label>
				<input type="password" name="cPass" id="cPass" class="form-control"/>
				<label name="err_cPass" for="cPass" id="err_cPass" ></label>
			</div>
		</div>
		<div class="form-group">
				<button type="submit" name="cSubmitBtn" for="contact" class="form-control">Login</button>
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