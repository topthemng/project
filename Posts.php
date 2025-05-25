<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>

<?php 
	$_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"];
	
	Confirm_Login(); 

	?>


<!DOCTYPE html>
<html>
<head>
 	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/styles.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<title>Post</title>
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
				
			<ul class="navbar-nav mr-auto">
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
					<a href="Blog.php?page=1" class="nav-link text-white">Emergency</a>
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
					<h1> <i class="fas fa-blog"></i> Blog Posts</h1> 
				</div>
				<div class="col-lg-3 mb-2">
					<a href="AddNewPost.php" class="btn btn-primary btn-block">
						<i class="fas fa-edit"></i> Add New Post
					</a>
				</div>
				<div class="col-lg-3 mb-2">
					<a href="Categories.php" class="btn btn-info btn-block">
						<i class="fas fa-folder-plus"></i> Add New Category
					</a>
				</div>
				<div class="col-lg-3 mb-2">
					<a href="Admins.php" class="btn btn-warning btn-block">
						<i class="fas fa-user-plus"></i> Add New Admin
					</a>
				</div>
				<div class="col-lg-3 mb-2">
					<a href="Comments.php" class="btn btn-success btn-block">
						<i class="fas fa-check"></i> Approve Comments
					</a>
				</div>
					
			</div>
			
		</div>
		



	</header>


<!--Main Area-->
	<section class="container py-2 mb-4">
		<div class="row">
			<div class="col-lg-12">
				<?php
				echo ErrorMessage();
				echo SuccessMessage();



				?>
				<table class="table  table-striped table-hover">
					<thead class="table-primary">
					<tr>
						<th>#</th>
						<th>Title</th>
						<th>Category</th>
						<th>Date & Time</th>
						<th>Author</th>
						<th>Banner</th>
						<th>Comments</th>
						<th>Actions</th>
						<th>Live Preview</th>
					
					</tr>
					</thead>

					<?php
					global $ConnectingDB;
					$sql = "SELECT * FROM posts";
					$stmt = $ConnectingDB->query($sql);
					$sr=0;
					while($DataRows = $stmt->fetch()){
						$Id 		= 	$DataRows["id"];
						$DateTime	=	$DataRows["datetime"];
						$PostTitle	=	$DataRows["title"];
						$Category 	=	$DataRows["category"];
						$Admin		=	$DataRows["author"];
						$Image		=	$DataRows["image"];
						$PostText	=	$DataRows["post"];
						$sr++;
					

					?>
					<tr>
						<td><?php echo $sr; ?></td>
						<td><?php 
						if (strlen($PostTitle) > 15){
							$PostTitle = substr($PostTitle, 0,15);}
							echo $PostTitle;	
						  ?></td>
						<td><?php echo $Category; ?></td>
						<td><?php 
						if(strlen($DateTime) > 11){
							$DateTime = substr($DateTime, 0, 11);

						} echo $DateTime; ?></td>
						<td><?php 
						if(strlen($Admin) > 6){
							$Admin = substr($Admin, 0,6);
						} echo $Admin; 
						?></td>
						<td><img src="Uploads/<?php echo $Image; ?>" width="170px;" height="50px" ></td>
						<td>Comments</td>
						<td> 
							<a href="EditPost.php?id=<?php echo $Id; ?>"> <span class="btn btn-warning">Edit</span> </a>
							<a href="DeletePost.php?id=<?php echo $Id; ?>"> <span class="btn btn-danger">Delete</span></a>
						</td>				
						<td> <a href="FullPost.php?id=<?php echo $Id; ?>" target="_blank"> <span class="btn btn-primary">Live Preview</span></a> </td>
						

					</tr>
				<?php } ?>

				</table>
				
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



</script>
</body>
</html>