
<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>

<?php 
	$_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"];
	Confirm_Login(); 
	?>
<?php
if(isset($_POST["Submit"])){
	$Category = $_POST["CategoryTitle"];
	$Admin = $_SESSION["UserName"];
;
	date_default_timezone_set("Africa/Lagos");
	$CurrentTime = time();
	$DateTime = strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);


	if(empty($Category)){
	$_SESSION["ErrorMessage"]  = "All fields must be filled out completely";
		Redirect_to("Categories.php");
	}elseif (strlen($Category)<3) {
		$_SESSION["ErrorMessage"]  = "Category title should be greater than 3 characters";
		Redirect_to("Categories.php");
	}elseif (strlen($Category) > 49){
		$_SESSION["ErrorMessage"] = "Category title should be less than 50 characters";
		Redirect_to("Categories.php");
	}else{
		//Query to insert category in our database when everything is fine

		global $ConnectingDB;
		$sql = "INSERT INTO category(title,author,datetime)";
		$sql .= "VALUES(:categoryName, :adminName, :dateTime)";
		$stmt = $ConnectingDB->prepare($sql);
		$stmt->bindValue(':categoryName', $Category);
		$stmt->bindValue(':adminName', $Admin);
		$stmt->bindValue(':dateTime', $DateTime);
		$Execute=$stmt->execute();

		if($Execute){
			$_SESSION["SuccessMessage"]="Category with id : ".$ConnectingDB->lastInsertId()." added successfully";
			Redirect_to("Categories.php");

		}else{
			$_SESSION["ErrorMessage"] = "Something went wrong. Try again !";
			Redirect_to("Categories.php");
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
	<title>Categories</title>
</head>

<body style="background-image: url(Images/hospital.jpg); background-repeat: repeat; background-size: cover;" >
	<!-- NAVBAR BEGIN-->

	<nav class="navbar navbar-expand-lg navbar-info bg-info">
		<div class="container">
			<a href="#" class="navbar-brand text-white" > <img src="Images/health.png" alt="health image"> PRIMARY HEALTH CMS</a>
			<button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarcollapseCMS" >
				<span class="navbar-toggler-icon"> </span> 
			</button>
			<div class="collapse navbar-collapse mr-auto" id="navbarcollapseCMS">
				
			<ul class="navbar-nav">
				<li class="nav-item">
					<a href="MyProfile.php" class="nav-link text-white"><i class="fa-solid fa-user"></i>MyProfile</a>
				</li>
				<li class="nav-item">
					<a href="Dashboard.php" class="nav-link text-white">Dashboard</a>
				</li>
				<li class="nav-item">
					<a href="Posts.php" class="nav-link text-white">Patients</a>
				</li>
				<li class="nav-item">
					<a href="Categories/php" class="nav-link text-white">Doctors</a>
				</li>
 				<li class="nav-item">
					<a href="Admins.php" class="nav-link text-white">ManageAdmins</a>
				</li>
				<li class="nav-item">
					<a href="Comments.php" class="nav-link text-white">Comments</a>
				</li>
				<li class="nav-item">
					<a href="Blog.php" class="nav-link text-white">Emergency</a>
				</li>
			</ul>

			<ul class="navbar-nav ml-auto">
				<li class="nav-item">
					<a href="Logout.php" class="nav-link text-white" > Logout</a>
					
				</li>
				
			</ul>

			</div>

		</div>
		



	</nav>



	<!-- NAVBAR ENDS-->
	<!-- HEADER -->
	<header class="bg-light text-dark py-3">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h1> <i class="fas fa-edit"></i> Manage Categories</h1> 
				</div>
				
			</div>
			
		</div>
		


	</header>


<!--Main Area-->
	<section class="container py-2 mb-4">
		<div class="offset-lg-1 col-lg-10" style="min-height: 400px;">

			<?php 
				echo ErrorMessage();
				echo SuccessMessage();


			 ?>
			<form class="" action="Categories.php" method="post">
				<div class="card bg-secondary text-light mb-3">
					<div class="card-header">
						<h1>Add New Category</h1>
						
					</div>
					<div class="card-body bg-dark">
						<div class="form-group">
							<label for="title"> <span class="FieldInfo">Category Title:</span> </label>
							<input class="form-control" type="text" name="CategoryTitle" id="title" placeholder="type title here" value="">
							
						</div>
						<div class="row"  >
							<div class="col-lg-6 d-grid mt-2">
								<a href="Dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> Back to Dashboard </a>							
							</div>
							<div class="col-lg-6 d-grid mt-2">
								<button type="submit" name="Submit" class="btn btn-success btn-block"><i class="fas fa-check"> Publish|Submit</i> </button>
								
							</div>

					</div>
				</div>
				

			</form>
					<h2>Un-Approved Comments</h2>

				<table class="table table-striped table-hover">
					<thead class="thead-dark">
						<tr>
							<th>No</th>
							<th>Date & Time</th>
							<th>Name</th>
							<th>Comment</th>
							<th>Approve</th>
							<th>Delete</th>
							<th>Details</th>
							
						</tr>
						
					</thead>

		
				<?php 
				global $ConnectingDB;
				$sql = "SELECT * FROM comments WHERE status='off' ORDER BY id DESC";
				$Execute = $ConnectingDB->query($sql);
				$SrNo=0;

				while (($DataRows = $Execute->fetch())) {
					$CommentId = $DataRows["id"];
					$DateTime = $DataRows["datetime"];
					$CommenterName = $DataRows["name"];
					$CommentContent = $DataRows["comment"];
					$CommentPostId = $DataRows["post_id"];
					$SrNo++;

				
				?>

	
				<tbody>
					<tr>
						<td><?php echo htmlentities($SrNo); ?></td>
						<td>
							<?php 
							if(strlen($DateTime>11)){
							$DateTime = substr($DateTime, 0,10)." ..";
							}
							echo htmlentities($DateTime); ?>
								
						</td>
						<td><?php 
							if(strlen($CommenterName)>10){
							$CommenterName = substr($CommenterName, 0,9)." ..";
							}
							echo htmlentities($CommenterName); ?>
								
						</td>
						<td><?php echo htmlentities($CommenterContent); ?></td>
						<td><a href="ApproveComments.php?id=<?php echo htmlentities($CommentId);?>" class="btn btn-success"></a> Approve </td>
						<td><a href="FullPost.php?id=<?php echo htmlentities($CommentPostId);?>" class="btn btn-primary" target="blank"></a>Live Preview </td>
						<td><a  href="DeleteComment.php?id=<?php echo htmlentities($CommentId); ?> " class="btn btn-danger"></a> </td>
						
					</tr>
					
					
				</tbody>

	<?php } ?>


		</table>	
		
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