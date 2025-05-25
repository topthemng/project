
<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php 
	$_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"];
	Confirm_Login(); 
	?>

<?php

//$SearchQueryParameter = $_GET['id'];
if(isset($_POST["Submit"])){

		//Query to Delete post in our database when everything is fine

		global $ConnectingDB;
		$sql = "DELETE FROM posts WHERE id='$SearchQueryParameter' ";
		$Execute = $ConnectingDB->query($sql);

		if($Execute){
			$_SESSION["SuccessMessage"]="Post deleted successfully;";
			Redirect_to("Posts.php");			
		}else{
			$_SESSION["ErrorMessage"] = "Something went wrong. Try again !";
			Redirect_to("Posts.php");

		}





	}

	//Ending of submit button if-condition
 
 



?>
<!DOCTYPE html>
<html>
<head>
 	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/styles.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<title>Delete Post</title>
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
					<h1> <i class="fa-solid fa-hospital-user"></i> Delete Post</h1> 
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
				//Fetching Existing Content according to our
				global $ConnectingDB;
				$sql = "SELECT * FROM posts WHERE id = '$SearchQueryParameter'";
				$stmt = $ConnectingDB->query($sql);
				while($DataRows=$stmt->fetch()){
					$TitleToBeUpdated = $DataRows["title"];
					$CategoryToBeUpdated = $DataRows["category"];
					$ImageToBeUpdated = $DataRows["image"];
					$PostToBeUpdated = $DataRows["post"];;

				}
			


			 ?>
			<form class="" action="DeletePost.php?id=<?php echo $SearchQueryParameter; ?>" method="post" enctype="multipart/form-data">
				<div class="card bg-secondary text-light mb-3">
					
					<div class="card-body bg-dark">
						<div class="form-group">
							<label for="title"> <span class="FieldInfo">Post Title</span> </label>
							<input disabled class="form-control" type="text" name="PostTitle" id="title" placeholder="type title here" value="">
							
						</div>
						<div class="form-group mb-3">
							<label for="CategoryTitle"> <span class="FieldInfo">Choose Category</span> </label>
							<select class="form-control" id="CategoryTitle" name="Category">
								<?php
								//Fetching all the categories from category table
								global $ConnectingDB;
								$sql = "SELECT id,title FROM category";
								$stmt = $ConnectingDB->query($sql);
								while($DataRows = $stmt->fetch()){
									$Id = $DataRows["id"];
									$CategoryName = $DataRows["title"];


									?> 
								
								<option><?php echo $CategoryName; ?></option>

							<?php } ?>





							


							</select>
							
						</div>
						
						<div class="form-group">
							<div class="custom-file">
							<input class="form-control custom-file-input" type="file" name="Image" id="imageSelect" value="">
							<label for="imageSelect" class="custom-file-label"> <span class="FieldInfo"></span> </label>
							</div>
						</div>

						<div class="form-group">
							<label for="Post" ><span class="FieldInfo">Post:</span> </label>
							<textarea disabled class="form-control" id="Post" name="PostDesription" rows="8" cols="8"></textarea>
							
						</div>


						<div class="row"  >
							<div class="col-lg-6 d-grid mt-2">
								<a href="Dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> BACK TO DASHBOARD </a>							
							</div>
							<div class="col-lg-6 d-grid mt-2">
								<button type="submit" name="Submit" class="btn btn-danger btn-block"><i class="fas fa-trash"> Delete</i> </button>
								
							</div>

					</div>
				</div>
				

			</form>
			
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