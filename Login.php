<?php require_once("Includes/DB.php");?>
<?php require_once("Includes/Functions.php");?>
<?php require_once("Includes/Sessions.php");?>

<?php
	if(isset($_SESSION["UserId"])){
		Redirect_to("Dashboard.php");
	}
	if(isset($_POST["Submit"])){
		$UserName = $_POST["Username"];
		$Password = $_POST["Password"];
		if(empty($UserName) || empty($Password)){
			$_SESSION["ErrorMessage"]="All fields must be filled out";
			Redirect_to("Login.php");
		}else{
			//code for checking username and password from database
			$Found_Account = Login_Attempt($UserName, $Password);
			if($Found_Account){
				$_SESSION["UserId"]=$Found_Account["id"];
				$_SESSION["UserName"]=$Found_Account["username"];
				$_SESSION["AdminName"]=$Found_Account["aname"];

				$_SESSION["SuccessMessage"] = "Welcome ".$_SESSION["AdminName"];
				if(isset($_SESSION["TrackingURL"])){
					Redirect_to($_SESSION["TrackingURL"]);
				}else{
					Redirect_to("Dashboard.php");
				}



			}else{
				$_SESSION["ErrorMessage"] = "Incorrect Username/Password";
				Redirect_to("Login.php");
			}




			




			}
	}
?>




<!DOCTYPE html>
<html>
<head>
 	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/styles.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<title>Login</title>
</head>

<body style="background-image: url(Images/hospital.png); background-repeat: repeat; background-size: cover;" >
	<!-- NAVBAR BEGIN-->

	<nav class="navbar navbar-expand-lg navbar-info bg-info">
		<div class="container">
			<a href="#" class="navbar-brand text-white" > <img src="Images/health.png" alt="health image"> PRIMARY HEALTH CMS</a>
			<button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarcollapseCMS" >
				<span class="navbar-toggler-icon"> </span> 
			</button>
			<div class="collapse navbar-collapse" id="navbarcollapseCMS">
				
			
			</div>

		</div>
		



	</nav>



	<!-- NAVBAR ENDS-->
	<!-- HEADER -->
	<header class="bg-light text-dark py-3">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
				</div>
				
			</div>
			
		</div>
		



	</header>
	<!--Header Ends-->

<!--Main Area start-->
	<section class="container py-2 my-4">
		<div class="row">
			<div class="offset-sm-3 col-sm-6" style="min-height:400px;">
			<?php 
				echo ErrorMessage();
				echo SuccessMessage();


			 ?>
				<div class="card bg-secondary text-light">
					<div class="card-header">
						<h4>Welcome Back! </h4>						
					</div>
					<div class="card-body bg-dark">
						<form class="" action="Login.php" method="post">
							<div class="form-group">
								<label for="username"><span class="FieldInfo">UserName:</span> </label>
								<div class="input-group mb-3"> 
									<input type="text" class="form-control" name="Username" id="username" value="">
								</div>
							</div>
							<div class="form-group">
								<label for="password"><span class="FieldInfo">Password:</span> </label>
								<div class="input-group mb-3"> 
									<input type="password" class="form-control" name="Password" id="password" value="">
								</div>
							</div>
							<input type="submit" name="Submit" class="btn btn-info btn-block" value="Login">
							
						</form>
						
					</div>
					
				</div>
				
			</div>



		</div>














	</section>
























<!-- Main Area end-->

























<footer class="bg-light text-dark">
	<div class="container">
		<div class="row">
			<div class="col" id="year">
				<p class="lead text-center">Theme By | Temitope Adesanya | <span id="yearCMS"></span> &copy; All right reserved </p>
				
			</div>
			
		</div>
		
	</div>
	
</footer>


<script src="https://kit.fontawesome.com/ccc1d92440.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
	const d = new Date();
	let year = d.getFullYear();
	document.getElementById("yearCMS").innerHTML = year;
	//$('#year').text(new Date().getFullYear());



</script>
</body>
</html>