<?php


include '../database_connection.php';

include '../function.php';

if(is_librarian_login())
{
	header('location:index.php');
}

$message = '';

if(isset($_POST["login_button"]))
{
	$formdata = array();

	if(empty($_POST["lib_user_name"]))
	{
		$message .= '<li>Username is required</li>';
	}
	else
	{
		$formdata['lib_user_name'] = $_POST['lib_user_name'];		
	}

	if(empty($_POST['librarian_password']))
	{
		$message .= '<li>Password is required</li>';
	}	
	else
	{
		$formdata['librarian_password'] = trim($_POST['librarian_password']);
	}

	if($message == '')
	{
		$data = array(
			':lib_user_name'		=>	$formdata['lib_user_name']
		);

		$query = "
		SELECT * FROM lms_librarian 
        WHERE lib_user_name = :lib_user_name
		";

		$statement = $connect->prepare($query);

		$statement->execute($data);

		if($statement->rowCount() > 0)
		{
			foreach($statement->fetchAll() as $row)
			{
					if($row['librarian_password'] == md5($formdata['librarian_password']))
					{
						$_SESSION['librarian_id'] = $row['lib_school_id'];
						header('location:index.php');
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

include 'librarian_header.php';

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
			<div class="card-header">Librarian Login</div>
			<div class="card-body">
				<form method="POST">
					<div class="mb-3">
						<label class="form-label">Username</label>
						<input type="text" name="lib_user_name" id="lib_user_name" class="form-control" />
					</div>
					<div class="mb-3">
						<label class="form-label">Password</label>
						<input type="password" name="librarian_password" id="librarian_password" class="form-control" />
					</div>
					<div class="d-flex align-items-center justify-content-between mt-4 mb-0">
						<input id="hoverbtn" type="submit" name="login_button" class="btn btn-dark" value="Login" />
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

