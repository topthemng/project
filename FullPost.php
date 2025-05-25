<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php 
	$_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"];
	Confirm_Login(); 
	?>
<?PHP $SearchQueryParameter = $_GET["id"];?>

<?php
if(isset($_POST["Submit"])){
	$Name = $_POST["CommenterName"];
	$Email = $_POST["CommenterEmail"];
	$Comment = $_POST["CommenterThoughts"];

	date_default_timezone_set("Africa/Lagos");
	$CurrentTime = time();
	$DateTime = strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);


	if(empty($Name)||empty($Email)||empty($Comment)){
	$_SESSION["ErrorMessage"]  = "All fields must be filled out completely";
		Redirect_to("FullPost.php?id=$SearchQueryParameter");
	}elseif (strlen($Comment)>500) {
		$_SESSION["ErrorMessage"]  = "Comment length should be less than 500 characters";
		Redirect_to("FullPost.php?id=$SearchQueryParameter");
	}else{
		//Query to insert category in our database when everything is fine

		global $ConnectingDB;
		$sql = "INSERT INTO comments(datetime, name, email, comment)";
		$sql .= "VALUES(:dateTime, :name, :email, :comment)";
		$stmt = $ConnectingDB->prepare($sql);
		$stmt->bindValue(':dateTime', $DateTime);
		$stmt->bindValue(':name', $Name);
		$stmt->bindValue(':email', $Email);
		$stmt->bindValue(':comment' $Comment);
		$Execute=$stmt->execute();

		if($Execute){
			$_SESSION["SuccessMessage"]="Comment submitted successfully";
			Redirect_to("FullPost.php?id=$SearchQueryParameter");

		}else{
			$_SESSION["ErrorMessage"] = "Something went wrong. Try again !";
			Redirect_to("FullPost.php?id=$SearchQueryParameter");
		}





	}

}	//Ending of submit button if-condition
 
 



?>


<!DOCTYPE html>
<html>
<head>
 	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/styles.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<title>Blog page</title>
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
				
			<ul class="navbar-nav ml-auto">				
				<li class="nav-item">
					<a href="Blog.php" class="nav-link text-white">Home</a>
				</li>
				<li class="nav-item">
					<a href="#" class="nav-link text-white">About Us</a>
				</li>
				<li class="nav-item">
					<a href="Blog.php" class="nav-link text-white">Blog</a>
				</li>
				<li class="nav-item">
					<a href="#" class="nav-link text-white">Contact Us</a>
				</li>
				<li class="nav-item">
					<a href="#" class="nav-link text-white">Features</a>
				</li>
			</ul>

			<ul class="navbar-nav ml-auto">
				<form class="form-inline d-none d-sm-block" action="Blog.php" >
					<div class="form-group">
						<input class="form-control mr-2" type="text" name="Search" placeholder="Search here" value="">
						<button type="submit" class="btn btn-primary" name="SearchButton">Go</button>
						
					</div>
					


				</form>				
			</ul>

			</div>

		</div>
		



	</nav>



	<!-- NAVBAR ENDS-->
	<!-- HEADER -->
		<div class="container">
			<div class="row mt-4">
				
				<!-- Main Area Start -->
				<div class="col-sm-8">
					<h1>The complete response CMS blog</h1>
					<h5 class="lead">The complete blog by using PHP by Temitope Adesanya</h5>
					<?php
					global $ConnectingDB;
					//sql query when Search Button is active
					if(isset($_GET["SearchButton"])){
						$Search = $_GET["Search"];
						$sql = "SELECT * FROM posts
						WHERE datetime LIKE :search
						OR title LIKE :search
						OR category LIKE :search
						or post LIKE :search
						";
						$stmt = $ConnectingDB-> prepare($sql);
						$stmt -> bindValue(':search','%'.$Search.'%');
						$stmt->execute();
 
					}
					// The default SQL query
					else{
						$PostIdFromURL = $_GET["id"];
						
						if(!isset($PostIdFromURL)){
							$_SESSION["ErrorMessage"]="Bad Request!";
							Redirect_to("Blog.php");
						}
						$sql = "SELECT * FROM posts WHERE id = '$PostIdFromURL'" ;
						$stmt = $ConnectingDB->query($sql);
		
  
					}
					
					while ($DataRows = $stmt->fetch()) {
						$PostId = $DataRows["id"];
						$DateTime = $DataRows["datetime"];
						$PostTitle = $DataRows["title"];
						$Category = $DataRows["category"];
						$Admin = $DataRows["author"];
						$Image = $DataRows["image"];
						$PostDescription = $DataRows["post"];
						
					?>
					<div class="card">
						<img class="img-fluid card-img-top" style="max-height: 300px; max-width: 250px" src="Uploads/<?php echo htmlentities($Image); ?>">
						<div class="card-body">
							<h4 class="card-title"><?php echo $PostTitle; ?></h4>
							<small class="text-muted"> Written by <?php echo htmlentities($Admin); ?> on <?php echo htmlentities($DateTime); ?> </small>
							<span style="background-color: black; float:right" class="badge badge-info text-light">Comment 20</span>
							<hr>
							<p class="card-text">
								@
								<?php 
								echo htmlentities($PostDescription); ?>
								
						</div>
						
					</div>
					<?php } ?>

					<!--Comment part start-->

					<div class="">
						<form class="" action="FullPost.php?id">
							

						qe
						</form>
						

					</div>



					<!--Comment part end-->




				</div>
				<!-- Main Area end-->

				<!-- Side Area Start -->
				<div class="col-sm-4">
					
				</div>

				<!-- Side Area end -->
				
			</div>

			





		</div>















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