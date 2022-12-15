<?php


include '../database_connection.php';

include '../function.php';

if(!is_librarian_login())
{
	header('location:librarian_login.php');
}

$message = '';

$success = '';

if(isset($_POST['save_button']))
{
	$formdata = array();
	
	if(empty($_POST['librarian_fname']))
	{
		$message .= '<li>First Name is required</li>';
	}
	else
	{
		$formdata['librarian_fname'] = trim($_POST['librarian_fname']);
	}
	
	if(empty($_POST['librarian_lname']))
	{
		$message .= '<li>Last Name is required</li>';
	}
	else
	{
		$formdata['librarian_lname'] = trim($_POST['librarian_lname']);
	}
	
	if(empty($_POST['lib_school_id']))
	{
		$message .= '<li>School ID is required</li>';
	}
	else
	{
		$formdata['lib_school_id'] = trim($_POST['lib_school_id']);
	}

	if(empty($_POST['librarian_email_address']))
	{
		$message .= '<li>Email Address is required</li>';
	}
	else
	{
		if(!filter_var($_POST["librarian_email_address"], FILTER_VALIDATE_EMAIL))
		{
			$message .= '<li>Invalid Email Address</li>';
		}
		else
		{
			$formdata['librarian_email_address'] = trim($_POST['librarian_email_address']);
		}
	}

	if(empty($_POST['librarian_password']))
	{
		$message .= '<li>Password is required</li>';
	}
	else
	{
		$formdata['librarian_password'] = md5(trim($_POST['librarian_password']));
	}

	if(empty($_POST['lib_user_name']))
	{
		$message .= '<li>User Name is required</li>';
	}
	else
	{
		$formdata['lib_user_name'] = trim($_POST['lib_user_name']);
	}

	if(empty($_POST['librarian_address']))
	{
		$message .= '<li>User Address Detail is required</li>';
	}
	else
	{
		$formdata['librarian_address'] = trim($_POST['librarian_address']);
	}

	if(empty($_POST['librarian_contact_no']))
	{
		$message .= '<li>User Address Detail is required</li>';
	}
	else
	{
		$formdata['librarian_contact_no'] = $_POST['librarian_contact_no'];
	}

	

	if($message == '')
	{
		$data = array(
			':librarian_fname'			=>	$formdata['librarian_fname'],
			':librarian_lname'			=>	$formdata['librarian_lname'],
			':lib_user_name'			=>	$formdata['lib_user_name'],
			':librarian_address'		=>	$formdata['librarian_address'],
			':librarian_contact_no'		=>	$formdata['librarian_contact_no'],
			':librarian_email_address'	=>	$formdata['librarian_email_address'],
			':librarian_password'		=>	$formdata['librarian_password'],
			':lib_school_id'		=>	$_SESSION['librarian_id']
		);

		$query = "
		UPDATE lms_librarian 
            SET librarian_fname = :librarian_fname,
			librarian_lname = :librarian_lname,
			lib_user_name = :lib_user_name, 
            librarian_address = :librarian_address, 
            librarian_contact_no = :librarian_contact_no,  
            librarian_email_address = :librarian_email_address, 
            librarian_password = :librarian_password 
            WHERE lib_school_id = :lib_school_id
		";

		$statement = $connect->prepare($query);

		$statement->execute($data);

		$success = 'Profile Edited Successfully';
	}
}


$query = "
	SELECT * FROM lms_librarian 
	WHERE lib_school_id = '".$_SESSION['librarian_id']."'
";

$result = $connect->query($query);

include 'librarian_header.php';

?>
<div class="container-fluid px-4">
	<h1 class="mt-4">Profile</h1>
	<ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
		<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
		<li class="breadcrumb-item active">Profile</li>
	</ol>
	<div class="card mb-4">
			<?php 
		if($message != '')
		{
			echo '<div class="alert alert-danger"><ul>'.$message.'</ul></div>';
		}

		if($success != '')
		{
			echo '<div class="alert alert-success">'.$success.'</div>';
		}
		?>
    	<div class="card-header">
    		<i class="fas fa-user"></i> Profile
       	</div>
       	<div class="card-body">
			<?php 
			foreach($result as $row)
			{
			?>
					<form method="post">
					
				<div class="row">
       				<div class="col-md-6">
       					<div class="mb-3">
						<label class="form-label">First Name</label>
						<input type="text" name="librarian_fname" id="librarian_fname" class="form-control" value="<?php echo $row['librarian_fname']; ?>" />
       					</div>
       				</div>
					<div class="col-md-6">
       					<div class="mb-3">
						<label class="form-label">Last Name</label>
						<input type="text" name="librarian_lname" id="librarian_lname" class="form-control" value="<?php echo $row['librarian_lname']; ?>" />
       					</div>
       				</div>
       			</div>

				<div class="row">
       				<div class="col-md-6">
       					<div class="mb-3">
						<label class="form-label">School ID</label>
						<input type="text" name="lib_school_id" id="lib_school_id" class="form-control" value="<?php echo $row['lib_school_id']; ?>" readonly/>
       					</div>
       				</div>
					<div class="col-md-6">
       					<div class="mb-3">
						<label class="form-label">User Name</label>
						<input type="text" name="lib_user_name" id="lib_user_name" class="form-control" value="<?php echo $row['lib_user_name']; ?>" />
       					</div>
       				</div>
       			</div>
				
				<div class="row">
       				<div class="col-md-6">
       					<div class="mb-3">
						<label class="form-label">Email address</label>
						<input type="text" name="librarian_email_address" id="librarian_email_address" class="form-control" value="<?php echo $row['librarian_email_address']; ?>" />
       					</div>
       				</div>
					<div class="col-md-6">
       					<div class="mb-3">
						<label class="form-label">Password</label>
						<input type="password" name="librarian_password" id="librarian_password" class="form-control" value="<?php echo $row['librarian_password']; ?>" />
       					</div>
       				</div>
       			</div>
				
				<div class="row">
       				<div class="col-md-6">
       					<div class="mb-3">
						<label class="form-label">User Contact No.</label>
						<input type="text" name="librarian_contact_no" id="librarian_contact_no" class="form-control" value="<?php echo $row['librarian_contact_no']; ?>" />
       					</div>
       				</div>
					<div class="col-md-6">
       					<div class="mb-3">
						<label class="form-label">User Address</label>
						<input type="text" name="librarian_address" id="librarian_address" class="form-control" value="<?php echo $row['librarian_address']; ?>" />
       					</div>
       				</div>
       			</div>
					<div class="text-center mt-4 mb-2">
						<input type="submit" name="save_button" class="btn btn-primary" value="Edit" />
					</div>				

					</form>
			<?php
			}
			?>
				</div>
			</div>
	</div>		
