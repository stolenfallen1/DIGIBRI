<?php

include 'database_connection.php';

include 'function.php';


$message = '';

if(isset($_POST["login_button"]))
{

	$formdata = array();

	if(empty($_POST["admin_uname"]))
	{
		$message .= '<li>Username is required</li>';
	}
	else
	{
		$formdata['admin_uname'] = $_POST['admin_uname'];		
	}

	if(empty($_POST['admin_password']))
	{
		$message .= '<li>Password is required</li>';
	}
	else
	{
		$formdata['admin_password'] = $_POST['admin_password'];
	}

	if($message == '')
	{
		$data = array(
			':admin_uname'		=>	$formdata['admin_uname']
		);

		$query = "
		SELECT * FROM lms_admin 
        WHERE admin_uname = :admin_uname
		";

		$statement = $connect->prepare($query);

		$statement->execute($data);

		if($statement->rowCount() > 0)
		{
			foreach($statement->fetchAll() as $row)
			{
				if($row['admin_password'] == md5($formdata['admin_password']))
				{
					$_SESSION['admin_id'] = $row['admin_id'];

					header('location:admin/index.php');
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

include 'header.php';

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

			<div class="card-header">Admin Login</div>

			<div class="card-body">

				<form method="POST">

					<div class="mb-3">
						<label class="form-label">Username</label>

						<input type="text" name="admin_uname" id="admin_uname" class="form-control" />

					</div>

					<div class="mb-3">
						<label class="form-label">Password</label>

						<input type="password" name="admin_password" id="admin_password" class="form-control" />

					</div>

					<div class="d-flex align-items-center justify-content-between mt-4 mb-0">

						<input id="hoverbtn" type="submit" name="login_button" class="btn btn-dark" value="Login" />

					</div>

				</form>

			</div>

		</div>

	</div>

</div>