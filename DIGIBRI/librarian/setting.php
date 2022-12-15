<?php

//setting.php

include '../database_connection.php';

include '../function.php';

if(!is_librarian_login())
{
	header('location:librarian_login.php');
}

$message = '';

if(isset($_POST['edit_setting']))
{
	$data = array(
		':library_total_book_issue_day'	=>	$_POST['library_total_book_issue_day'],
		':library_one_day_fine'			=>	$_POST['library_one_day_fine'],
		':library_issue_total_book_per_user'	=>	$_POST['library_issue_total_book_per_user']
	);

	$query = "
	UPDATE lms_setting 
        SET library_total_book_issue_day = :library_total_book_issue_day, 
        library_one_day_fine = :library_one_day_fine, 
        library_issue_total_book_per_user = :library_issue_total_book_per_user
	";

	$statement = $connect->prepare($query);

	$statement->execute($data);

	$message = '
	<div class="alert alert-success alert-dismissible fade show" role="alert">Data Edited <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>
	';
}

$query = "
SELECT * FROM lms_setting 
LIMIT 1
";

$result = $connect->query($query);

include 'librarian_header.php';

?>

<div class="container-fluid px-4">
	<h1 class="mt-4">Setting</h1>

	<ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
		<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
		<li class="breadcrumb-item active">Settings</a></li>
	</ol>
	<div class="row">
		<div class="col-md-6">	
	<?php 

	if($message != '')	
	{
		echo $message;
	}

	?>
	<div class="card mb-4">
		<div class="card-header">
			<i class="fas fa-cog"></i> Library Settings
		</div>
		<div class="card-body">

			<form method="post">
				<?php 
				foreach($result as $row)
				{
				?>
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Borrowing Period</label>
							<input type="number" name="library_total_book_issue_day" id="library_total_book_issue_day" class="form-control" value="<?php echo $row['library_total_book_issue_day']; ?>" />
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Fine</label>
							<input type="number" name="library_one_day_fine" id="library_one_day_fine" class="form-control" value="<?php echo $row['library_one_day_fine']; ?>" />
						</div>
					</div>				
				</div>
				<div class="row">
					<div class="col-md-6">
						<label class="form-label">Book Issue Limit</label>
						<input type="number" name="library_issue_total_book_per_user" id="library_issue_total_book_per_user" class="form-control" value="<?php echo $row['library_issue_total_book_per_user']; ?>" />
					</div>
				</div>
				<div class="mt-4 mb-0">
					<input type="submit" name="edit_setting" class="btn btn-primary" value="Save" />
				</div>
				<?php 
				}
				?>
			</form>

		</div>
	</div>
		</div>
	</div>		
</div>
