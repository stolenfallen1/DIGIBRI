<?php


include '../database_connection.php';

include '../function.php';

if(is_user_login())
{
	header('location:search_book.php');
}

$message = '';

if(isset($_POST["login_button"]))
{
	$formdata = array();

	if(empty($_POST["user_name"]))
	{
		$message .= '<li>Username is required</li>';
	}
	else
	{
		$formdata['user_name'] = $_POST['user_name'];		
	}

	if(empty($_POST['user_password']))
	{
		$message .= '<li>Password is required</li>';
	}	
	else
	{
		$formdata['user_password'] = trim($_POST['user_password']);
	}

	if($message == '')
	{
		$data = array(
			':user_name'		=>	$formdata['user_name']
		);

		$query = "
		SELECT * FROM lms_user 
        WHERE user_name = :user_name
		";

		$statement = $connect->prepare($query);

		$statement->execute($data);

		if($statement->rowCount() > 0)
		{
			foreach($statement->fetchAll() as $row)
			{
					if($row['user_password'] == md5($formdata['user_password']))
					{
						$_SESSION['user_id'] = $row['school_id'];
						header('location:search_book.php');
					}
					else
					{
						$message = '<li>Wrong Password</li>';
					}
			}
		}
		else
		{
			$message = '<li>Wrong Username</li>';
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
<div class="d-flex align-items-center justify-content-center" style="min-height:500px;">
	<div class="col-md-6">
		<?php 

		if($message != '')
		{
			echo '<div class="alert alert-danger"><ul>'.$message.'</ul></div>';
		}

		?>
		<div class="card">
			<div class="card-header">Library Patron Login</div>
			<div class="card-body">
				<form method="POST">
					<div class="mb-3">
						<label class="form-label">Username</label>
						<input type="text" name="user_name" id="user_name" class="form-control" />
					</div>
					<div class="mb-3">
						<label class="form-label">Password</label>
						<input type="password" name="user_password" id="user_password" class="form-control" />
					</div>
					<div class="d-flex align-items-center justify-content-between mt-4 mb-0">
						<input id="hoverbtn" type="submit" name="login_button" class="btn btn-dark" value="Login" />
					</div>
				</form>
							<p></p>
							<a href="user_registration.php">No account yet? Click here to Sign Up</a>
			</div>
		</div>
	</div>
</div>

