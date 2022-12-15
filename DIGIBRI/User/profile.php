<?php


include '../database_connection.php';

include '../function.php';

if(!is_user_login())
{
	header('location:user_login.php');
}

$message = '';

$success = '';

if(isset($_POST['save_button']))
{
	$formdata = array();
	
	if(empty($_POST['user_fname']))
	{
		$message .= '<li>First Name is required</li>';
	}
	else
	{
		$formdata['user_fname'] = trim($_POST['user_fname']);
	}
	
	if(empty($_POST['user_lname']))
	{
		$message .= '<li>Last Name is required</li>';
	}
	else
	{
		$formdata['user_lname'] = trim($_POST['user_lname']);
	}
	
	if(empty($_POST['school_id']))
	{
		$message .= '<li>School ID is required</li>';
	}
	else
	{
		$formdata['school_id'] = trim($_POST['school_id']);
	}

	if(empty($_POST['user_email_address']))
	{
		$message .= '<li>Email Address is required</li>';
	}
	else
	{
		if(!filter_var($_POST["user_email_address"], FILTER_VALIDATE_EMAIL))
		{
			$message .= '<li>Invalid Email Address</li>';
		}
		else
		{
			$formdata['user_email_address'] = trim($_POST['user_email_address']);
		}
	}

	if(empty($_POST['user_password']))
	{
		$message .= '<li>Password is required</li>';
	}
	else
	{
		$formdata['user_password'] = md5(trim($_POST['user_password']));
	}

	if(empty($_POST['user_name']))
	{
		$message .= '<li>User Name is required</li>';
	}
	else
	{
		$formdata['user_name'] = trim($_POST['user_name']);
	}

	if(empty($_POST['user_address']))
	{
		$message .= '<li>User Address Detail is required</li>';
	}
	else
	{
		$formdata['user_address'] = trim($_POST['user_address']);
	}

	if(empty($_POST['user_contact_no']))
	{
		$message .= '<li>User Address Detail is required</li>';
	}
	else
	{
		$formdata['user_contact_no'] = $_POST['user_contact_no'];
	}

	

	if($message == '')
	{
		$data = array(
			':user_fname'			=>	$formdata['user_fname'],
			':user_lname'			=>	$formdata['user_lname'],
			':user_name'			=>	$formdata['user_name'],
			':user_address'			=>	$formdata['user_address'],
			':user_contact_no'		=>	$formdata['user_contact_no'],
			':user_email_address'	=>	$formdata['user_email_address'],
			':user_password'		=>	$formdata['user_password'],
			':school_id'		=>	$_SESSION['user_id']
		);

		$query = "
		UPDATE lms_user 
            SET user_fname = :user_fname,
			user_lname = :user_name,
			user_name = :user_lname, 
            user_address = :user_address, 
            user_contact_no = :user_contact_no,  
            user_email_address = :user_email_address, 
            user_password = :user_password 
            WHERE school_id = :school_id
		";

		$statement = $connect->prepare($query);

		$statement->execute($data);

		$success = 'Profile Edited Successfully';
	}
}


$query = "
	SELECT * FROM lms_user 
	WHERE school_id = '".$_SESSION['user_id']."'
";

$result = $connect->query($query);

include 'user_header.php';

?>

<div class="container-fluid px-4">
	<h1 class="mt-4">Profile</h1>
	<ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
		<li class="breadcrumb-item"><a href="search_book.php">Dashboard</a></li>
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
						<input type="text" name="user_fname" id="user_fname" class="form-control" value="<?php echo $row['user_fname']; ?>" />
       					</div>
       				</div>
					<div class="col-md-6">
       					<div class="mb-3">
						<label class="form-label">Last Name</label>
						<input type="text" name="user_lname" id="user_lname" class="form-control" value="<?php echo $row['user_lname']; ?>" />
       					</div>
       				</div>
       			</div>

				<div class="row">
       				<div class="col-md-6">
       					<div class="mb-3">
						<label class="form-label">School ID</label>
						<input type="text" name="school_id" id="school_id" class="form-control" value="<?php echo $row['school_id']; ?>" readonly/>
       					</div>
       				</div>
					<div class="col-md-6">
       					<div class="mb-3">
						<label class="form-label">User Name</label>
						<input type="text" name="user_name" id="user_name" class="form-control" value="<?php echo $row['user_name']; ?>" />
       					</div>
       				</div>
       			</div>
				
				<div class="row">
       				<div class="col-md-6">
       					<div class="mb-3">
						<label class="form-label">Email address</label>
						<input type="text" name="user_email_address" id="user_email_address" class="form-control" value="<?php echo $row['user_email_address']; ?>" />
       					</div>
       				</div>
					<div class="col-md-6">
       					<div class="mb-3">
						<label class="form-label">Password</label>
						<input type="password" name="user_password" id="user_password" class="form-control" value="<?php echo $row['user_password']; ?>" />
       					</div>
       				</div>
       			</div>
				
				<div class="row">
       				<div class="col-md-6">
       					<div class="mb-3">
						<label class="form-label">User Contact No.</label>
						<input type="text" name="user_contact_no" id="user_contact_no" class="form-control" value="<?php echo $row['user_contact_no']; ?>" />
       					</div>
       				</div>
					<div class="col-md-6">
       					<div class="mb-3">
						<label class="form-label">User Address</label>
						<input type="text" name="user_address" id="user_address" class="form-control" value="<?php echo $row['user_address']; ?>" />
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
