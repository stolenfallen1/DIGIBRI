<?php

include '../database_connection.php';

include '../function.php';

if(is_user_login())
{
	header('location:search_book.php');
}

$message = '';

$success = '';

if(isset($_POST["register_button"]))
{
	$formdata = array();
	
	if(empty($_POST["user_fname"]))
	{
		$message .= '<li>First Name is required</li>';
	}
	else
	{
		$formdata['user_fname'] = trim($_POST['user_fname']);
	}
	
	if(empty($_POST["user_lname"]))
	{
		$message .= '<li>Last Name is required</li>';
	}
	else
	{
		$formdata['user_lname'] = trim($_POST['user_lname']);
	}	
	
	if(empty($_POST["user_email_address"]))
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

	if(empty($_POST["user_password"]))
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
		$message .= '<li>User Contact Number Detail is required</li>';
	}
	else
	{
		$formdata['user_contact_no'] = trim($_POST['user_contact_no']);
	}
	
	if(empty($_POST['school_id']))
	{
		$message .= '<li>School ID is required</li>';
	}
	else
	{
		$formdata['school_id'] = trim($_POST['school_id']);
	}

	if($message == '')
	{
		$data = array(
			':school_id'		=>	$formdata['school_id']
		);

		$query = "
		SELECT * FROM lms_user 
        WHERE school_id = :school_id
		";

		$statement = $connect->prepare($query);

		$statement->execute($data);

		if($statement->rowCount() > 0)
		{
			$message = '<li>School ID Already Registered</li>';
		}
		else{
			$data = array(
				':user_fname'			=>	$formdata['user_fname'],
				':user_lname'			=>	$formdata['user_lname'],				
				':user_name'			=>	$formdata['user_name'],
				':user_address'			=>	$formdata['user_address'],
				':user_contact_no'		=>	$formdata['user_contact_no'],
				':user_email_address'	=>	$formdata['user_email_address'],
				':user_password'		=>	$formdata['user_password'],
				':school_id'			=>	$formdata['school_id']
			);

			$query = "
			INSERT INTO lms_user 
            (user_fname, user_lname, user_name, user_address, user_contact_no, user_email_address, user_password, school_id) 
            VALUES (:user_fname, :user_lname, :user_name, :user_address, :user_contact_no, :user_email_address, :user_password, :school_id)
			";

			$statement = $connect->prepare($query);

			$statement->execute($data);
        header("location:user_login.php");
		}

	}
}

include 'user_header.php';

?>
<style>
	#hoverbtn:hover {
		background: #F59292;
	}
</style>
<div class="d-flex align-items-center justify-content-center mt-5 mb-5" style="min-height:700px;">
	<div class="col-md-6">
		<?php 
		

		if($success != '')
		{
			echo '<div class="alert alert-success">'.$success.'</div>';
		}
		
		if($message != '')
		{
			echo '<div class="alert alert-danger">'.$message.'</div>';
		}		

		?>
		<div class="card">
			<div class="card-header">Library Patron Registration</div>
			<div class="card-body">
				<form method="POST" enctype="multipart/form-data">
					<div class="mb-3">
						<label class="form-label">First Name</label>
                        <input type="text" name="user_fname" class="form-control" id="user_fname" value="" />
                    </div>
					<div class="mb-3">
						<label class="form-label">Last Name</label>
                        <input type="text" name="user_lname" class="form-control" id="user_lname" value="" />
                    </div>
					<div class="mb-3">
						<label class="form-label">School ID</label>
                        <input type="text" name="school_id" class="form-control" id="school_id" value="" />
                    </div>
					<div class="mb-3">
						<label class="form-label">Email address</label>
						<input type="text" name="user_email_address" id="user_email_address" class="form-control" />
					</div>
					<div class="mb-3">
						<label class="form-label">Password</label>
						<input type="password" name="user_password" id="user_password" class="form-control" />
					</div>
					<div class="mb-3">
						<label class="form-label">User Name</label>
                        <input type="text" name="user_name" class="form-control" id="user_name" value="" />
                    </div>
					<div class="mb-3">
						<label class="form-label">User Contact No.</label>
						<input type="text" name="user_contact_no" id="user_contact_no" class="form-control" />
					</div>
					<div class="mb-3">
						<label class="form-label">User Address</label>
						<textarea name="user_address" id="user_address" class="form-control"></textarea>
					</div>
					<div class="text-center mt-4 mb-2">
						<input id="hoverbtn" type="submit" name="register_button" class="btn btn-dark" value="Register" />
					</div>
										</div>
					<div class="text-center mt-15 mb-2">
							<a href="user_login.php">Already have an account? Login here</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

