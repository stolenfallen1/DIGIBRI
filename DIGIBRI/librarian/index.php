<?php

include '../database_connection.php';

include '../function.php';

if(!is_librarian_login())
{
	header('location:librarian_login.php');
}


include 'librarian_header.php';

?>
<html>
	<head>
		<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
		<style>
			#hoverbtn:hover {
				color: #D70505;
				border: 2px solid #F59292;
				font-weight: bold;
			}
			#Sub-header {
				text-align: center;
				font-style: italic;
				font-size: 25px;
			}
		</style>
	</head>
	<body>
		<div class="container-fluid py-4">
			<h1 class="mb-5">Dashboard</h1>
			<hr>
			<div class="row">
				<!-- REPORTS OF ACTIVE BOOKS, AUTHORS, CATEGORY, LOCATION RACK -->
				<div class="col-xl-3 col-md-6">
					<div class="card border-primary mb-3">
						<div class="card-header">Pending Requests <i class="fa fa-book" aria-hidden="true"></i></div>
						<div class="card-body text-primary">
							<h1 class="text-center"><?php echo books_pending($connect); ?></h1>
							<p class="card-text"> Total amount of pending requests from library patrons. </p>
							<!-- <a id="hoverbtn" href="#" class="btn btn-light">View Details</a> -->
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-md-6">
					<div class="card border-success mb-3">
						<div class="card-header">Total Books <i class="fa fa-book" aria-hidden="true"></i></div>
						<div class="card-body text-success">
							<h1 class="text-center"><?php echo total_book($connect); ?></h1>
							<p class="card-text"> Total amount of books in the library either active or inactive. </p>
							<!-- <a id="hoverbtn" href="#" class="btn btn-light">View Details</a> -->
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-md-6">
					<div class="card border-info mb-3">
						<div class="card-header">Active Books <i class="fa fa-book" aria-hidden="true"></i></div>
						<div class="card-body text-info">
							<h1 class="text-center"><?php echo active_book($connect); ?></h1>
							<p class="card-text">Total amount of active books available in the library. </p>
							<!-- <a id="hoverbtn" href="#" class="btn btn-light">View Details</a> -->
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-md-6">
					<div class="card border-warning mb-3">
						<div class="card-header">Total Library Patrons <i class="fa fa-user-circle" aria-hidden="true"></i></i></div>
						<div class="card-body text-warning">
							<h1 class="text-center"><?php echo total_user($connect); ?></h1>
							<p class="card-text"> Total amount of library patrons registered. </p>
							<!-- <a id="hoverbtn" href="#" class="btn btn-light">View Details</a> -->
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-md-6">
					<div class="card border-primary mb-3">
						<div class="card-header">Books Issued <i class="fa fa-book" aria-hidden="true"></i></div>
						<div class="card-body text-primary">
							<h1 class="text-center"><?php echo books_issued($connect); ?></h1>
							<p class="card-text"> Total amount of books issued from the library. </p>
							<!-- <a id="hoverbtn" href="#" class="btn btn-light">View Details</a> -->
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-md-6">
					<div class="card border-success mb-3">
						<div class="card-header">Books Returned <i class="fa fa-book" aria-hidden="true"></i></div>
						<div class="card-body text-success">
							<h1 class="text-center"><?php echo books_returned($connect); ?></h1>
							<p class="card-text"> Total amount of borrowed books returned to the library. </p>
							<!-- <a id="hoverbtn" href="#" class="btn btn-light">View Details</a> -->
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-md-6">
					<div class="card border-info mb-3">
						<div class="card-header">Books Borrowed <i class="fa fa-book" aria-hidden="true"></i></div>
						<div class="card-body text-info">
							<h1 class="text-center"><?php echo book_borrowed($connect); ?></h1>
							<p class="card-text"> Total amount of books borrowed from the library. </p>
							<!-- <a id="hoverbtn" href="#" class="btn btn-light">View Details</a> -->
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-md-6">
					<div class="card border-warning mb-3">
						<div class="card-header">Fines <i class="fa fa-book" aria-hidden="true"></i></div>
						<div class="card-body text-warning">
							<h1 class="text-center">₱ <?php echo total_fine($connect); ?></h1>
							<p class="card-text"> Total amount of fine collected from late returned books. </p>
							<!-- <a id="hoverbtn" href="#" class="btn btn-light">View Details</a> -->
						</div>
					</div>
				</div><hr>
				<!-- PIE GRAPH CHART -->
				<?php 
				
				$sql = $connect->query('SELECT COUNT(*) AS Y, lms_category.category_name AS X FROM lms_book INNER JOIN lms_category ON lms_book.category_id = lms_category.category_id GROUP BY X;');
				foreach($sql as $data) 
				{
					$barX[] = $data["X"];
					$barY[] = $data["Y"];
				}
				
				?>
				
				<div class="col-xl-5 col-md-6">
					<div>
						<canvas id="barChart"></canvas>
					</div>
					<p align="center">Books in category</p>
					<script>
						const barLabels = <?php echo json_encode($barX) ?>;
						const barData = {
						labels: barLabels,
						datasets: [{
							label: 'Books in a Category',
							data: <?php echo json_encode($barY) ?>,
							backgroundColor: [
							'rgba(255, 99, 132, 0.2)',
							'rgba(255, 159, 64, 0.2)',
							'rgba(255, 205, 86, 0.2)',
							'rgba(75, 192, 192, 0.2)',
							'rgba(54, 162, 235, 0.2)',
							'rgba(153, 102, 255, 0.2)',
							'rgba(201, 203, 207, 0.2)'
							],
							borderColor: [
							'rgb(255, 99, 132)',
							'rgb(255, 159, 64)',
							'rgb(255, 205, 86)',
							'rgb(75, 192, 192)',
							'rgb(54, 162, 235)',
							'rgb(153, 102, 255)',
							'rgb(201, 203, 207)'
							],
							borderWidth: 1
						}]
						};

						const barConfig = {
							type: 'pie',
							data: barData,
							options: {
								scales: {
								y: {
									beginAtZero: true
								}
								}
							},
						};

						const myChart = new Chart(
							document.getElementById('barChart'),
							barConfig
						);
					</script>
				</div>
				<!-- LINE GRAPH CHART -->
				<?php 
				
				$sql = $connect->query('SELECT COUNT(*) AS Y, lms_location_rack.location_rack_name AS X FROM lms_book INNER JOIN lms_location_rack ON lms_book.location_rack_id = lms_location_rack.location_rack_id GROUP BY X;');
				foreach($sql as $data) 
				{
					$lineX[] = $data["X"];
					$lineY[] = $data["Y"];
				}
				
				?>
				<div class="col-xl-7 col-md-6">
					<div>
						<canvas id="lineChart"></canvas>
					</div>
					<p align="center">Books in location racks</p>
					<script>
						const lineLabels = <?php echo json_encode($lineX) ?>;
						const lineData = {
						labels: lineLabels,
						datasets: [{
							label: 'Books count in a library rack',
							data: <?php echo json_encode($lineY) ?>,
							backgroundColor: [
							'rgba(255, 99, 132, 0.2)',
							'rgba(255, 159, 64, 0.2)',
							'rgba(255, 205, 86, 0.2)',
							'rgba(75, 192, 192, 0.2)',
							'rgba(54, 162, 235, 0.2)',
							'rgba(153, 102, 255, 0.2)',
							'rgba(201, 203, 207, 0.2)'
							],
							borderColor: [
							'rgb(255, 99, 132)',
							'rgb(255, 159, 64)',
							'rgb(255, 205, 86)',
							'rgb(75, 192, 192)',
							'rgb(54, 162, 235)',
							'rgb(153, 102, 255)',
							'rgb(201, 203, 207)'
							],
							borderWidth: 1
						}]
						};

						const lineConfig = {
							type: 'bar',
							data: lineData,
							options: {
								scales: {
								y: {
									beginAtZero: true
								}
								}
							},
						};

						const lineChart = new Chart(
							document.getElementById('lineChart'),
							lineConfig
						);
					</script>
				</div>
				
			</div><hr>
		</div>
	</body>
</html>

