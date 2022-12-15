<?php

include '../database_connection.php';

include '../function.php';

if(!is_admin_login())
{
	header('location:../index.php');
}

$message = '';

$error = '';

if(isset($_POST["add_librarian"]))
{
	$formdata = array();
	
	if(empty($_POST["librarian_fname"]))
	{
		$message .= '<li>First Name is required</li>';
	}
	else
	{
		$formdata['librarian_fname'] = trim($_POST['librarian_fname']);
	}
	
	if(empty($_POST["librarian_lname"]))
	{
		$message .= '<li>Last Name is required</li>';
	}
	else
	{
		$formdata['librarian_lname'] = trim($_POST['librarian_lname']);
	}	
	
	if(empty($_POST["librarian_email_address"]))
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

	if(empty($_POST["librarian_password"]))
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
		$message .= '<li>User Contact Number Detail is required</li>';
	}
	else
	{
		$formdata['librarian_contact_no'] = trim($_POST['librarian_contact_no']);
	}
	
	if(empty($_POST['lib_school_id']))
	{
		$message .= '<li>School ID is required</li>';
	}
	else
	{
		$formdata['lib_school_id'] = trim($_POST['lib_school_id']);
	}

	if($message == '')
	{
		$data = array(
			':lib_school_id'		=>	$formdata['lib_school_id']
		);

		$query = "
		SELECT * FROM lms_librarian
        WHERE lib_school_id = :lib_school_id
		";

		$statement = $connect->prepare($query);

		$statement->execute($data);

		if($statement->rowCount() > 0)
		{
			$message = '<li>School ID Already Registered</li>';
		}
		else{
			$data = array(
				':librarian_fname'			=>	$formdata['librarian_fname'],
				':librarian_lname'			=>	$formdata['librarian_lname'],				
				':lib_user_name'			=>	$formdata['lib_user_name'],
				':librarian_address'		=>	$formdata['librarian_address'],
				':librarian_contact_no'		=>	$formdata['librarian_contact_no'],
				':librarian_email_address'	=>	$formdata['librarian_email_address'],
				':librarian_password'		=>	$formdata['librarian_password'],
				':lib_school_id'			=>	$formdata['lib_school_id']				
			);

			$query = "
			INSERT INTO lms_librarian 
            (librarian_fname, librarian_lname, lib_user_name, librarian_address, librarian_contact_no, librarian_email_address, librarian_password, lib_school_id) 
            VALUES (:librarian_fname, :librarian_lname, :lib_user_name, :librarian_address, :librarian_contact_no, :librarian_email_address, :librarian_password, :lib_school_id)
			";

			$statement = $connect->prepare($query);

			$statement->execute($data);

			header('location:librarian.php?msg=add');
		}

	}
}

if(isset($_POST["edit_librarian"]))
{
	$formdata = array();

	if(empty($_POST["librarian_fname"]))
	{
		$error .= '<li>First Name is required</li>';
	}
	else
	{
		$formdata['librarian_fname'] = trim($_POST["librarian_fname"]);
	}
	
	if(empty($_POST["librarian_lname"]))
	{
		$error .= '<li>Last Name is required</li>';
	}
	else
	{
		$formdata['librarian_lname'] = trim($_POST["librarian_lname"]);
	}

	if(empty($_POST["lib_school_id"]))
	{
		$error .= '<li>School ID is required</li>';
	}
	else
	{
		$formdata['lib_school_id'] = trim($_POST["lib_school_id"]);
	}

	if(empty($_POST["lib_user_name"]))
	{
		$error .= '<li>Username is required</li>';
	}
	else
	{
		$formdata['lib_user_name'] = trim($_POST["lib_user_name"]);
	}

	if(empty($_POST["librarian_email_address"]))
	{
		$error .= '<li>Email Address is required</li>';
	}
	else
	{
		$formdata['librarian_email_address'] = trim($_POST["librarian_email_address"]);
	}

	if(empty($_POST["librarian_password"]))
	{
		$error .= '<li>Password is required</li>';
	}
	else
	{
		$formdata['librarian_password'] = md5(trim($_POST["librarian_password"]));
	}

	if(empty($_POST["librarian_contact_no"]))
	{
		$error .= '<li>Contact Number is required</li>';
	}
	else
	{
		$formdata['librarian_contact_no'] = trim($_POST["librarian_contact_no"]);
	}
	if(empty($_POST["librarian_address"]))
	{
		$error .= '<li>User Address is required</li>';
	}
	else
	{
		$formdata['librarian_address'] = trim($_POST["librarian_address"]);
	}
	
	if($error == '')
	{		
		$data = array(
			':librarian_fname'			=>	$formdata['librarian_fname'],
			':librarian_lname'			=>	$formdata['librarian_lname'],
			':lib_school_id'		=>	$formdata['lib_school_id'],
			':lib_user_name'			=>	$formdata['lib_user_name'],
			':librarian_email_address'	=>	$formdata['librarian_email_address'],
			':librarian_password'			=>	$formdata['librarian_password'],
			':librarian_contact_no'		=>	$formdata['librarian_contact_no'],
			':librarian_address'		=>	$formdata['librarian_address'],
			':librarian_id'		=>	$_POST["librarian_id"]
		);
		$query = "
		UPDATE lms_librarian 
        SET librarian_fname = :librarian_fname,
		librarian_lname = :librarian_lname,
		lib_school_id = :lib_school_id, 
        lib_user_name = :lib_user_name, 
        librarian_email_address = :librarian_email_address, 
        librarian_password = :librarian_password, 
        librarian_contact_no = :librarian_contact_no,
        librarian_address = :librarian_address
        WHERE librarian_id = :librarian_id
		";

		$statement = $connect->prepare($query);

		$statement->execute($data);

		header('location:librarian.php?msg=edit');
	}
}

$query = "
SELECT * FROM lms_librarian
    ORDER BY lib_user_name ASC
";

$statement = $connect->prepare($query);

$statement->execute();

include '../header.php';

?>

<div class="container-fluid py-4" style="min-height: 700px;">
	<h1>Librarian</h1>
	<?php 

	if(isset($_GET['action']))
	{
		if($_GET['action'] == 'add')
		{
	?>

	<ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
		<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
		<li class="breadcrumb-item"><a href="librarian.php">Librarian Management</a></li>
		<li class="breadcrumb-item active">Register Librarian</li>
	</ol>
			<?php

			if($message != '')
			{
				echo '<div class="alert alert-danger"><ul>'.$message.'</ul></div>';
			}				

			if($error != '')
			{
				echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><ul class="list-unstyled">'.$error.'</ul> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
			}

			?>
			<div class="card mb-4">
				<div class="card-header">
					<i class="fas fa-user-plus"></i> Register Librarian
                </div>
                <div class="card-body">

                <form method="POST">
				
        		<div class="row">
        			<div class="col-md-6">
        				<div class="mb-3">
        					<label class="form-label">First Name</label>
        					<input type="text" name="librarian_fname" id="librarian_fname" class="form-control" />
        				</div>
        			</div>
					<div class="col-md-6">
        				<div class="mb-3">
        					<label class="form-label">Last Name</label>
        					<input type="text" name="librarian_lname" id="librarian_lname" class="form-control" />
        				</div>
        			</div>
        		</div>

        		<div class="row">
        			<div class="col-md-6">
        				<div class="mb-3">
        					<label class="form-label">School ID</label>
        					<input type="text" name="lib_school_id" id="lib_school_id" class="form-control" />
        				</div>
        			</div>
					<div class="col-md-6">
        				<div class="mb-3">
        					<label class="form-label">Username</label>
        					<input type="text" name="lib_user_name" id="lib_user_name" class="form-control" />
        				</div>
        			</div>
        		</div>
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Email Address</label>
							<input type="text" name="librarian_email_address" id="librarian_email_address" class="form-control" />
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Password</label>
							<input type="password" name="librarian_password" id="librarian_password" step="1" class="form-control" />
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Contact No.</label>
							<input type="text" name="librarian_contact_no" id="librarian_contact_no" class="form-control" />
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Address</label>
							<input type="text" name="librarian_address" id="librarian_address" step="1" class="form-control" />
						</div>
					</div>
				</div>
        		<div class="mt-4 mb-3 text-center">
        			<input type="submit" name="add_librarian" class="btn btn-success" value="Add" />
        		</div>

                	</form>

                </div>
            </div>


	<?php 
		}
		else if($_GET["action"] == 'edit')
		{
			$librarian_id = $_GET["code"];

			if($librarian_id > 0)
			{
				$query = "
				SELECT * FROM lms_librarian 
                WHERE librarian_id = '$librarian_id'
				";

				$librarian_result = $connect->query($query);

				foreach($librarian_result as $librarian_row)
				{
				?>
	
	<ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
		<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
		<li class="breadcrumb-item"><a href="librarian.php">Librarian Management</a></li>
		<li class="breadcrumb-item active">Edit Librarian</li>
	</ol>
	<div class="card mb-4">
    	<div class="card-header">
    		<i class="fas fa-user-edit"></i> Edit Librarian
       	</div>
       	<div class="card-body">

					<form method="post">
					
				<div class="row">
       				<div class="col-md-6">
       					<div class="mb-3">
       						<label class="form-label">First Name</label>
       						<input type="text" name="librarian_fname" id="librarian_fname" class="form-control" value="<?php echo $librarian_row['librarian_fname']; ?>" />
       					</div>
       				</div>
					<div class="col-md-6">
       					<div class="mb-3">
       						<label class="form-label">Last Name</label>
       						<input type="text" name="librarian_lname" id="librarian_lname" class="form-control" value="<?php echo $librarian_row['librarian_lname']; ?>" />
       					</div>
       				</div>
       			</div>

				<div class="row">
       				<div class="col-md-6">
       					<div class="mb-3">
       						<label class="form-label">School ID</label>
       						<input type="text" name="lib_school_id" id="lib_school_id" class="form-control" value="<?php echo $librarian_row['lib_school_id']; ?>" readonly/>
       					</div>
       				</div>
					<div class="col-md-6">
       					<div class="mb-3">
       						<label class="form-label">Username</label>
       						<input type="text" name="lib_user_name" id="lib_user_name" class="form-control" value="<?php echo $librarian_row['lib_user_name']; ?>" />
       					</div>
       				</div>
       			</div>
				
				<div class="row">
       				<div class="col-md-6">
       					<div class="mb-3">
       						<label class="form-label">Email Address</label>
       						<input type="text" name="librarian_email_address" id="librarian_email_address" class="form-control" value="<?php echo $librarian_row['librarian_email_address']; ?>" />
       					</div>
       				</div>
					<div class="col-md-6">
       					<div class="mb-3">
       						<label class="form-label">Password</label>
       						<input type="password" name="librarian_password" id="librarian_password" class="form-control" value="<?php echo $librarian_row['librarian_password']; ?>" />
       					</div>
       				</div>
       			</div>
				
				<div class="row">
       				<div class="col-md-6">
       					<div class="mb-3">
       						<label class="form-label">Contact Number</label>
       						<input type="text" name="librarian_contact_no" id="librarian_contact_no" class="form-control" value="<?php echo $librarian_row['librarian_contact_no']; ?>" />
       					</div>
       				</div>
					<div class="col-md-6">
       					<div class="mb-3">
       						<label class="form-label">Address</label>
       						<input type="text" name="librarian_address" id="librarian_address" class="form-control" value="<?php echo $librarian_row['librarian_address']; ?>" />
       					</div>
       				</div>
       			</div>
				
     			<div class="mt-4 mb-3 text-center">
       				<input type="hidden" name="librarian_id" value="<?php echo $librarian_row['librarian_id']; ?>" />
       				<input type="submit" name="edit_librarian" class="btn btn-primary" value="Edit" />
       			</div>

					</form>

				</div>
			</div>

		</div>
	</div>

				<?php 
				}
			}
		}
	}
	else
	{	

	?>
	<ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
		<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
		<li class="breadcrumb-item active">Librarian Management</li>
	</ol>

	<?php 

	if(isset($_GET['msg']))
	{
		if($_GET['msg'] == 'add')
		{
			echo '<div class="alert alert-success alert-dismissible fade show" role="alert">New Librarian Added<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
		}

		if($_GET["msg"] == 'edit')
		{
			echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Librarian Data Edited <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
		}
	}	

	?>

	<div class="card mb-4">
		<div class="card-header">
			<div class="row">
				<div class="col col-md-6">
					<i class="fas fa-table me-1"></i> Librarian Management
				</div>
				<div class="col col-md-6" align="right">
					<a href="librarian.php?action=add" class="btn btn-success btn-sm">Register</a>
				</div>
			</div>
		</div>
		<div class="card-body">

			<table id="datatablesSimple">
				<thead>
					<tr>
                        <th>First Name</th>
                        <th>Last Name</th>
						<th>School ID</th>
                        <th>Action</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
                        <th>First Name</th>
                        <th>Last Name</th>
						<th>School ID</th>
                        <th>Action</th>
					</tr>
				</tfoot>
				<tbody>
				<?php 

    			if($statement->rowCount() > 0)
    			{
    				foreach($statement->fetchAll() as $row)
    				{						
    					echo '
    					<tr>
    						<td>'.$row["librarian_fname"].'</td>
    						<td>'.$row["librarian_lname"].'</td>
							<td>'.$row["lib_school_id"].'</td>
    						<td>
								<a href="librarian.php?action=edit&code='.$row["librarian_id"].'" class="btn btn-sm btn-primary">View</a>
							</td>
    					</tr>
    					';
    				}
    			}
    			else
    			{
    				echo '

    				<tr>
    					<td colspan="10" class="text-center">No Data Found</td>
    				</tr>
    				';
    			}

				?>
				</tbody>
			</table>
		</div>
	</div>
	<?php 
	}
	?>

</div>
