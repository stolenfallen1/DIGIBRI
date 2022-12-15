<?php

include '../database_connection.php';

include '../function.php';

if(!is_librarian_login())
{
	header('location:librarian_login.php');
}

$message = '';

$error = '';

if(isset($_POST["add_user"]))
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
		$formdata['user_password'] = trim($_POST['user_password']);
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
				':school_id'			=>	$formdata['school_id'],
			);

			$query = "
			INSERT INTO lms_user 
            (user_fname, user_lname, user_name, user_address, user_contact_no, user_email_address, user_password, school_id) 
            VALUES (:user_fname, :user_lname, :user_name, :user_address, :user_contact_no, :user_email_address, :user_password, :school_id)
			";

			$statement = $connect->prepare($query);

			$statement->execute($data);

			header('location:user.php?msg=add');
		}

	}
}

if(isset($_POST["edit_user"]))
{
	$formdata = array();

	if(empty($_POST["user_fname"]))
	{
		$message .= '<li>First Name is required</li>';
	}
	else
	{
		$formdata['user_fname'] = trim($_POST["user_fname"]);
	}
	
	if(empty($_POST["user_lname"]))
	{
		$message .= '<li>Last Name is required</li>';
	}
	else
	{
		$formdata['user_lname'] = trim($_POST["user_lname"]);
	}

	if(empty($_POST["school_id"]))
	{
		$message .= '<li>School ID is required</li>';
	}
	else
	{
		$formdata['school_id'] = trim($_POST["school_id"]);
	}

	if(empty($_POST["user_name"]))
	{
		$message .= '<li>Username is required</li>';
	}
	else
	{
		$formdata['user_name'] = trim($_POST["user_name"]);
	}

	if(empty($_POST["user_email_address"]))
	{
		$message .= '<li>Email Address is required</li>';
	}
	else
	{
		$formdata['user_email_address'] = trim($_POST["user_email_address"]);
	}

	if(empty($_POST["user_password"]))
	{
		$message .= '<li>Password is required</li>';
	}
	else
	{
		$formdata['user_password'] = trim($_POST["user_password"]);
	}

	if(empty($_POST["user_contact_no"]))
	{
		$message .= '<li>Contact Number is required</li>';
	}
	else
	{
		$formdata['user_contact_no'] = trim($_POST["user_contact_no"]);
	}
	if(empty($_POST["user_address"]))
	{
		$message .= '<li>User Address is required</li>';
	}
	else
	{
		$formdata['user_address'] = trim($_POST["user_address"]);
	}
	
	if($message == '')
	{		
		$data = array(
			':user_fname'			=>	$formdata['user_fname'],
			':user_lname'			=>	$formdata['user_lname'],
			':school_id'		=>	$formdata['school_id'],
			':user_name'			=>	$formdata['user_name'],
			':user_email_address'	=>	$formdata['user_email_address'],
			':user_password'			=>	$formdata['user_password'],
			':user_contact_no'		=>	$formdata['user_contact_no'],
			':user_address'		=>	$formdata['user_address'],
			':user_id'		=>	$_POST["user_id"]
		);
		$query = "
		UPDATE lms_user 
        SET user_fname = :user_fname,
		user_lname = :user_lname,
		school_id = :school_id, 
        user_name = :user_name, 
        user_email_address = :user_email_address, 
        user_password = :user_password, 
        user_contact_no = :user_contact_no,
        user_address = :user_address
        WHERE user_id = :user_id
		";

		$statement = $connect->prepare($query);

		$statement->execute($data);

		header('location:user.php?msg=edit');
	}
}

if(isset($_POST['importSubmit'])){
    
    // Allowed mime types
    $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
    
    // Validate whether selected file is a CSV file
    if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)){
        
        // If the file is uploaded
        if(is_uploaded_file($_FILES['file']['tmp_name'])){
            
            // Open uploaded CSV file with read-only mode
            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
            
            // Skip the first line
            fgetcsv($csvFile);
            
            // Parse data from CSV file line by line
            while(($line = fgetcsv($csvFile)) !== FALSE){
                // Get row data
                $user_fname   = $line[0];
                $user_lname  = $line[1];
                $user_name  = $line[2];
                $user_address = $line[3];
                $user_contact_no   = $line[4];
                $user_email_address  = $line[5];
                $user_password  = $line[6];
                $school_id = $line[7];				
                
                // Check whether member already exists in the database with the same email
                $prevQuery = "SELECT user_id FROM lms_user WHERE school_id = '".$line[7]."'";
                $prevResult = $connect->query($prevQuery);
                
                if($prevResult->rowCount() > 0){
                    // Update member data in the database
					header('location:user.php?msg=edit');
                }else{
                    // Insert member data in the database
                    $connect->query("INSERT INTO lms_user (user_fname, user_lname, user_name, user_address, user_contact_no, user_email_address, user_password, school_id) VALUES ('".$user_fname."', '".$user_lname."', '".$user_name."', 
					'".$user_address."', '".$user_contact_no."', '".$user_email_address."', '".$user_password."', '".$school_id."')");
                }
            }
            
            // Close opened CSV file
            fclose($csvFile);
            
            header('location:user.php?msg=add');
        }else{
			header('location:user.php?msg=invalid');
        }
    }else{
		header('location:user.php?msg=invalid');
    }
}

// Redirect to the listing page


$query = "
SELECT * FROM lms_user
    ORDER BY user_name ASC
";

$statement = $connect->prepare($query);

$statement->execute();

include 'librarian_header.php';

?>

<div class="container-fluid py-4" style="min-height: 700px;">
	<h1>Library Patron</h1>
	<?php 

	if(isset($_GET['action']))
	{
		if($_GET['action'] == 'add')
		{
	?>

	<ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
		<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
		<li class="breadcrumb-item"><a href="user.php">Library Patron Management</a></li>
		<li class="breadcrumb-item active">Register Library Patron(s)</li>
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
					<i class="fas fa-user-plus"></i> Register Library Patron(s)
                </div>
				
                <div class="card-body">

                <form method="POST">
				
        		<div class="row">
        			<div class="col-md-6">
        				<div class="mb-3">
        					<label class="form-label">First Name</label>
        					<input type="text" name="user_fname" id="user_fname" class="form-control" />
        				</div>
        			</div>
					<div class="col-md-6">
        				<div class="mb-3">
        					<label class="form-label">Last Name</label>
        					<input type="text" name="user_lname" id="user_lname" class="form-control" />
        				</div>
        			</div>
        		</div>

        		<div class="row">
        			<div class="col-md-6">
        				<div class="mb-3">
        					<label class="form-label">School ID</label>
        					<input type="text" name="school_id" id="school_id" class="form-control" />
        				</div>
        			</div>
					<div class="col-md-6">
        				<div class="mb-3">
        					<label class="form-label">Username</label>
        					<input type="text" name="user_name" id="user_name" class="form-control" />
        				</div>
        			</div>
        		</div>
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Email Address</label>
							<input type="text" name="user_email_address" id="user_email_address" class="form-control" />
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Password</label>
							<input type="password" name="user_password" id="user_password" step="1" class="form-control" />
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Contact No.</label>
							<input type="text" name="user_contact_no" id="user_contact_no" class="form-control" />
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Address</label>
							<input type="text" name="user_address" id="user_address" step="1" class="form-control" />
						</div>
					</div>
				</div>
        		<div class="mt-4 mb-3 text-center">
        			<input type="submit" name="add_user" class="btn btn-success" value="Register" />
        		</div>

                	</form>
					
				<div class="row">
					<div class="col-md-12 head">
						<div class="text-center">
							<a href="javascript:void(0);" class="btn btn-primary" onclick="formToggle('importFrm');"><i class="plus"></i> Import</a>
						</div>
					</div>	
				</div>

				<div class="col-md-12 text-center" id="importFrm" style="display: none;">
					<form action="user.php" method="post" enctype="multipart/form-data">
						<input type="file" name="file" />
						<input type="submit" class="btn btn-success" name="importSubmit" value="Import">
					</form>
				</div>
                </div>
            </div>


	<?php 
		}
		else if($_GET["action"] == 'edit')
		{
			$user_id = $_GET["code"];

			if($user_id > 0)
			{
				$query = "
				SELECT * FROM lms_user 
                WHERE user_id = '$user_id'
				";

				$user_result = $connect->query($query);

				foreach($user_result as $user_row)
				{
				?>
	
	<ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
		<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
		<li class="breadcrumb-item"><a href="user.php">Library Patron Management</a></li>
		<li class="breadcrumb-item active">View Library Patron</li>
	</ol>
	<div class="card mb-4">
    	<div class="card-header">
    		<i class="fas fa-user"></i> View Library Patron
       	</div>
       	<div class="card-body">

					<form method="post">
					
				<div class="row">
       				<div class="col-md-6">
       					<div class="mb-3">
       						<label class="form-label">First Name</label>
       						<input type="text" name="user_fname" id="user_fname" class="form-control" value="<?php echo $user_row['user_fname']; ?>" readonly/>
       					</div>
       				</div>
					<div class="col-md-6">
       					<div class="mb-3">
       						<label class="form-label">Last Name</label>
       						<input type="text" name="user_lname" id="user_lname" class="form-control" value="<?php echo $user_row['user_lname']; ?>" readonly/>
       					</div>
       				</div>
       			</div>

				<div class="row">
       				<div class="col-md-6">
       					<div class="mb-3">
       						<label class="form-label">School ID</label>
       						<input type="text" name="school_id" id="school_id" class="form-control" value="<?php echo $user_row['school_id']; ?> " readonly/>
       					</div>
       				</div>
					<div class="col-md-6">
       					<div class="mb-3">
       						<label class="form-label">Username</label>
       						<input type="text" name="user_name" id="user_name" class="form-control" value="<?php echo $user_row['user_name']; ?>" readonly/>
       					</div>
       				</div>
       			</div>
				
				<div class="row">
       				<div class="col-md-6">
       					<div class="mb-3">
       						<label class="form-label">Email Address</label>
       						<input type="text" name="user_email_address" id="user_email_address" class="form-control" value="<?php echo $user_row['user_email_address']; ?>" readonly/>
       					</div>
       				</div>
					<div class="col-md-6">
       					<div class="mb-3">
       						<label class="form-label">Password</label>
       						<input type="password" name="user_password" id="user_password" class="form-control" value="<?php echo $user_row['user_password']; ?>" readonly/>
       					</div>
       				</div>
       			</div>
				
				<div class="row">
       				<div class="col-md-6">
       					<div class="mb-3">
       						<label class="form-label">Contact Number</label>
       						<input type="text" name="user_contact_no" id="user_contact_no" class="form-control" value="<?php echo $user_row['user_contact_no']; ?>" readonly/>
       					</div>
       				</div>
					<div class="col-md-6">
       					<div class="mb-3">
       						<label class="form-label">Address</label>
       						<input type="text" name="user_address" id="user_address" class="form-control" value="<?php echo $user_row['user_address']; ?>" readonly/>
       					</div>
       				</div>
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
		<li class="breadcrumb-item active">Library Patron Management</li>
	</ol>

	<?php 

	if(isset($_GET['msg']))
	{
		if($_GET['msg'] == 'add')
		{
			echo '<div class="alert alert-success alert-dismissible fade show" role="alert">New Library Patron(s) Registered<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
		}

		if($_GET["msg"] == 'edit')
		{
			echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Library Patron Edited Successfully<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
		}
		
		if($_GET["msg"] == 'invalid')
		{
			echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">Invalid File <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
		}
	}	

	?>

	<div class="card mb-4">
		<div class="card-header">
			<div class="row">
				<div class="col col-md-6">
					<i class="fas fa-table me-1"></i> Library Patron Management
				</div>
				<div class="col col-md-6" align="right">
					<a href="user.php?action=add" class="btn btn-success btn-sm">Register</a>
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
    						<td>'.$row["user_fname"].'</td>
    						<td>'.$row["user_lname"].'</td>
    						<td>'.$row["school_id"].'</td>
    						<td>
								<a href="user.php?action=edit&code='.$row["user_id"].'" class="btn btn-sm btn-primary">View</a>
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

<script>
function formToggle(ID){
    var element = document.getElementById(ID);
    if(element.style.display === "none"){
        element.style.display = "block";
    }else{
        element.style.display = "none";
    }
}
</script>
