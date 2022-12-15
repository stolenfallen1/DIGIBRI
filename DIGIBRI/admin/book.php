<?php

include '../database_connection.php';

include '../function.php';

if(!is_admin_login())
{
	header('location:../index.php');
}

$message = '';

$error = '';

if(isset($_POST["add_book"]))
{
	$formdata = array();

	if(empty($_POST["book_name"]))
	{
		$error .= '<li>Book Title is required</li>';
	}
	else
	{
		$formdata['book_name'] = trim($_POST["book_name"]);
	}

	if(empty($_POST["category_id"]))
	{
		$error .= '<li>Book Category is required</li>';
	}
	else
	{
		$formdata['category_id'] = trim($_POST["category_id"]);
	}

	if(empty($_POST["book_author"]))
	{
		$error .= '<li>Book Author is required</li>';
	}
	else
	{
		$formdata['book_author'] = trim($_POST["book_author"]);
	}

	if(empty($_POST["location_rack_id"]))
	{
		$error .= '<li>Book Location Rack is required</li>';
	}
	else
	{
		$formdata['location_rack_id'] = trim($_POST["location_rack_id"]);
	}

	if(empty($_POST["book_isbn_number"]))
	{
		$error .= '<li>Book ISBN is required</li>';
	}
	else
	{
		$formdata['book_isbn_number'] = trim($_POST["book_isbn_number"]);
	}
	if(empty($_POST["book_no_of_copy"]))
	{
		$error .= '<li>Book No. of Copy is required</li>';
	}
	else
	{
		$formdata['book_no_of_copy'] = trim($_POST["book_no_of_copy"]);
	}
	if(empty($_POST["publisher"]))
	{
		$error .= '<li>Publisher is required</li>';
	}
	else
	{
		$formdata['publisher'] = trim($_POST["publisher"]);
	}
	if(empty($_POST["publication_date"]))
	{
		$error .= '<li>Publication date is required</li>';
	}
	else
	{
		$formdata['publication_date'] = trim($_POST["publication_date"]);
	}
	if(!empty($_FILES['image_file']['name']))
	{
		$img_name = $_FILES['image_file']['name'];
		$tmp_name = $_FILES['image_file']['tmp_name'];
		$folder = "../asset/Uploads/";

		move_uploaded_file($tmp_name, $folder . $img_name);
		$formdata['image_file'] = $img_name;

	}
	else
	{
		$error .= '<li>Please Select Book Cover Image</li>';
	}


	if($error == '')
	{
		$data = array(
			':book_isbn_number'		=>	$formdata['book_isbn_number']
		);

		$query = "
		SELECT * FROM lms_book 
        WHERE book_isbn_number = :book_isbn_number
		";

		$statement = $connect->prepare($query);

		$statement->execute($data);

		if($statement->rowCount() > 0)
		{
			$error = '<li>Book ISBN Already Registered</li>';
		}
		else{		
		$data = array(
			':category_id'			=>	$formdata['category_id'],
			':book_author'			=>	$formdata['book_author'],
			':location_rack_id'		=>	$formdata['location_rack_id'],
			':book_name'			=>	$formdata['book_name'],
			':book_isbn_number'		=>	$formdata['book_isbn_number'],
			':book_no_of_copy'		=>	$formdata['book_no_of_copy'],
			':publisher'			=>	$formdata['publisher'],
			':publication_date'		=>	$formdata['publication_date'],
			':image_file'			=> 	$formdata['image_file'],
			':book_status'			=>	'Active',
		);

		$query = "
		INSERT INTO lms_book 
        (category_id, book_author, location_rack_id, book_name, book_isbn_number, book_no_of_copy, publisher , publication_date, image_file, book_status) 
        VALUES (:category_id, :book_author, :location_rack_id, :book_name, :book_isbn_number, :book_no_of_copy, :publisher, :publication_date, :image_file, :book_status)
		";

		$statement = $connect->prepare($query);

		$statement->execute($data);

		header('location:book.php?msg=add');

	}
}
}

if(isset($_POST["edit_book"]))
{
	$formdata = array();

	if(empty($_POST["book_name"]))
	{
		$error .= '<li>Book Title is required</li>';
	}
	else
	{
		$formdata['book_name'] = trim($_POST["book_name"]);
	}

	if(empty($_POST["category_id"]))
	{
		$error .= '<li>Book Category is required</li>';
	}
	else
	{
		$formdata['category_id'] = trim($_POST["category_id"]);
	}

	if(empty($_POST["book_author"]))
	{
		$error .= '<li>Book Author is required</li>';
	}
	else
	{
		$formdata['book_author'] = trim($_POST["book_author"]);
	}

	if(empty($_POST["location_rack_id"]))
	{
		$error .= '<li>Book Location Rack is required</li>';
	}
	else
	{
		$formdata['location_rack_id'] = trim($_POST["location_rack_id"]);
	}

	if(empty($_POST["book_isbn_number"]))
	{
		$error .= '<li>Book ISBN is required</li>';
	}
	else
	{
		$formdata['book_isbn_number'] = trim($_POST["book_isbn_number"]);
	}
	if(empty($_POST["book_no_of_copy"]))
	{
		$error .= '<li>Book No. of Copy is required</li>';
	}
	else
	{
		$formdata['book_no_of_copy'] = trim($_POST["book_no_of_copy"]);
	}
	if(empty($_POST["publisher"]))
	{
		$error .= '<li>Publisher is required</li>';
	}
	else
	{
		$formdata['publisher'] = trim($_POST["publisher"]);
	}
	if(empty($_POST["publication_date"]))
	{
		$error .= '<li>Publication Date is required</li>';
	}
	else
	{
		$formdata['publication_date'] = trim($_POST["publication_date"]);
	}
	if(empty($_FILES["image_file"]))
	{
		$error .= '<li>Book Cover Image is required</li>';
	}
	else
	{
		$img_name = $_FILES['image_file']['name'];
		$tmp_name = $_FILES['image_file']['tmp_name'];
		$folder = "../asset/Uploads/";

		move_uploaded_file($tmp_name, $folder . $img_name);
		$formdata['image_file'] = $img_name;
	}

	if($error == '')
	{	
		if(!empty($_FILES['image_file']['name']))
		{
		$data = array(
			':category_id'			=>	$formdata['category_id'],
			':book_author'			=>	$formdata['book_author'],
			':location_rack_id'		=>	$formdata['location_rack_id'],
			':book_name'			=>	$formdata['book_name'],
			':book_isbn_number'		=>	$formdata['book_isbn_number'],
			':book_no_of_copy'		=>	$formdata['book_no_of_copy'],
			':publisher'			=>	$formdata['publisher'],
			':publication_date'		=>	$formdata['publication_date'],
			':image_file'			=>	$formdata['image_file'],			
			':book_id'				=>	$_POST["book_id"]
		);
		$query = "
		UPDATE lms_book 
        SET category_id = :category_id, 
        book_author = :book_author, 
        location_rack_id = :location_rack_id, 
        book_name = :book_name, 
        book_isbn_number = :book_isbn_number,
        book_no_of_copy = :book_no_of_copy,		
		publisher = :publisher,
		publication_date = :publication_date,
		image_file = :image_file
        WHERE book_id = :book_id
		";

		$statement = $connect->prepare($query);

		$statement->execute($data);

		header('location:book.php?msg=edit');
		}
		else if(empty($_FILES['image_file']['name']))
		{
		$data = array(
			':category_id'			=>	$formdata['category_id'],
			':book_author'			=>	$formdata['book_author'],
			':location_rack_id'		=>	$formdata['location_rack_id'],
			':book_name'			=>	$formdata['book_name'],
			':book_isbn_number'		=>	$formdata['book_isbn_number'],
			':book_no_of_copy'		=>	$formdata['book_no_of_copy'],
			':publisher'			=>	$formdata['publisher'],
			':publication_date'		=>	$formdata['publication_date'],			
			':book_id'				=>	$_POST["book_id"]
		);
		$query = "
		UPDATE lms_book 
        SET category_id = :category_id, 
        book_author = :book_author, 
        location_rack_id = :location_rack_id, 
        book_name = :book_name, 
        book_isbn_number = :book_isbn_number,
        book_no_of_copy = :book_no_of_copy,		
		publisher = :publisher,
		publication_date = :publication_date		
        WHERE book_id = :book_id
		";

		$statement = $connect->prepare($query);

		$statement->execute($data);

		header('location:book.php?msg=edit');
		}
}
}

if(isset($_GET["action"], $_GET["code"], $_GET["status"]) && $_GET["action"] == 'delete')
{
	$book_id = $_GET["code"];
	$status = $_GET["status"];

	$data = array(
		':book_status'		=>	$status,
		':book_id'			=>	$book_id
	);

	$query = "
	UPDATE lms_book 
    SET book_status = :book_status 
    WHERE book_id = :book_id
	";

	$statement = $connect->prepare($query);

	$statement->execute($data);

	header('location:book.php?msg='.strtolower($status).'');
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
                $category_id   = $line[0];
                $book_author  = $line[1];
                $location_rack_id  = $line[2];
                $book_name = $line[3];
                $book_isbn_number   = $line[4];
                $book_no_of_copy  = $line[5];
                $publisher  = $line[6];
                $publication_date = date('Y-m-d', strtotime($line[7]));
                $image_file  = $line[8];
                $book_status = $line[9];				
                
                // Check whether member already exists in the database with the same email
                $prevQuery = "SELECT book_id FROM lms_book WHERE book_isbn_number = '".$line[4]."'";
                $prevResult = $connect->query($prevQuery);
                
                if($prevResult->rowCount() > 0){
                    // Update member data in the database
					header('location:book.php?msg=edit');
                }else{
                    // Insert member data in the database
                    $connect->query("INSERT INTO lms_book (category_id, book_author, location_rack_id, book_name, book_isbn_number, book_no_of_copy, publisher, publication_date, image_file, book_status) 
					VALUES ('".$category_id."', '".$book_author."', '".$location_rack_id."', 
					'".$book_name."', '".$book_isbn_number."', '".$book_no_of_copy."', '".$publisher."', '".$publication_date."', '".$image_file."', '".$book_status."')");
                }
            }
            
            // Close opened CSV file
            fclose($csvFile);
            
            header('location:book.php?msg=add');
        }else{
			header('location:book.php?msg=invalid');
        }
    }else{
		header('location:book.php?msg=invalid');
    }
}


$query = "
	SELECT * FROM lms_book 
    ORDER BY book_id DESC
";

$statement = $connect->prepare($query);

$statement->execute();


include '../header.php';

?>

<div class="container-fluid py-4" style="min-height: 700px;">
	<h1>Books</h1>
	<?php 
	if(isset($_GET["action"]))
	{
		if($_GET["action"] == 'add')
		{
	?>

	<ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
		<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="book.php">Book Management</a></li>
        <li class="breadcrumb-item active">Add Book(s)</li>
    </ol>

    <?php 

    if($error != '')
    {
    	echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><ul class="list-unstyled">'.$error.'</ul> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    }

    ?>

    <div class="card mb-4">
    	<div class="card-header">
    		<i class="fas fa-book"></i> Add Book(s)
        </div>
        <div class="card-body">
        	<form method="post">
        		<div class="row">
        			<div class="col-md-6">
        				<div class="mb-3">
        					<label class="form-label">Book Title</label>
        					<input type="text" name="book_name" id="book_name" class="form-control" />
        				</div>
        			</div>
        			<div class="col-md-6">
        				<div class="mb-3">
        					<label class="form-label">Author(s)</label>
        					<input type="text" name="book_author" id="book_author" class="form-control" />
        				</div>
        			</div>
        		</div>
        		<div class="row">
        			<div class="col-md-6">
        				<div class="mb-3">
        					<label class="form-label">Select Category</label>
        					<select name="category_id" id="category_id" class="form-control">
        						<?php echo fill_category($connect); ?>
        					</select>
        				</div>
        			</div>
        			<div class="col-md-6">
        				<div class="mb-3">
        					<label class="form-label">Select Location Rack</label>
        					<select name="location_rack_id" id="location_rack_id" class="form-control">
        						<?php echo fill_location_rack($connect); ?>
        					</select>
        				</div>
        			</div>
        		</div>
        		<div class="row">
        			<div class="col-md-6">
        				<div class="mb-3">
        					<label class="form-label">ISBN</label>
        					<input type="text" name="book_isbn_number" id="book_isbn_number" class="form-control" />
        				</div>
        			</div>
					<div class="col-md-6">
        				<div class="mb-3">
        					<label class="form-label">Publisher</label>
        					<input type="text" name="publisher" id="publisher" class="form-control" />
        				</div>
        			</div>
        		</div>
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Publication Date</label>
							<input type="date" name="publication_date" id="publication_date" class="form-control" />
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Items Available</label>
							<input type="number" name="book_no_of_copy" id="book_no_of_copy" step="1" class="form-control" />
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Book Cover</label>
							<input type="file" accept=".jpg, .jpeg, .png" name="image_file" id="image_file" class="form-control" formenctype="multipart/form-data" />
						</div>
					</div>
				</div>
        		<div class="mt-4 mb-3 text-center">
        			<input type="submit" name="add_book" class="btn btn-success" value="Add" formenctype="multipart/form-data" />
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
					<form action="book.php" method="post" enctype="multipart/form-data">
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
			$book_id = $_GET["code"];

			if($book_id > 0)
			{
				$query = "
				SELECT * FROM lms_book 
                WHERE book_id = '$book_id'
				";

				$book_result = $connect->query($query);

				foreach($book_result as $book_row)
				{
	?>
	<ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
		<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="book.php">Book Management</a></li>
        <li class="breadcrumb-item active">Edit Book</li>
    </ol>
    <div class="card mb-4">
    	<div class="card-header">
    		<i class="fas fa-book"></i> Edit Book
       	</div>
       	<div class="card-body">
       		<form method="post">	
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<br>
       						<label class="form-label">Book Title</label>
       						<input type="text" name="book_name" id="book_name" class="form-control" value="<?php echo $book_row['book_name']; ?>" />
       						<label class="form-label">Author(s)</label>
       						<input type="text" name="book_author" id="book_author" class="form-control" value="<?php echo $book_row['book_author']; ?>" />
       						<label class="form-label">Select Category</label>
       						<select name="category_id" id="category_id" class="form-control">
       							<?php echo fill_category($connect); ?>
       						</select>
       						<label class="form-label">Select Location Rack</label>
       						<select name="location_rack_id" id="location_rack_id" class="form-control">
       							<?php echo fill_location_rack($connect); ?>
       						</select>
       					<div class="mb-3">
       						<label class="form-label">ISBN</label>
       						<input type="text" name="book_isbn_number" id="book_isbn_number" class="form-control" value="<?php echo $book_row['book_isbn_number']; ?>" readonly/>
       					</div>														
						</div>	
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<img src=../asset/Uploads//<?php echo  $book_row['image_file'];?>	name="image_file" id="image_file" width="380" height="380" border="1px" />
						</div>
					</div>					
				</div>			
       			<div class="row">
       				<div class="col-md-6">
       					<div class="mb-3">
       						<label class="form-label">Publisher</label>
       						<input type="text" name="publisher" id="publisher" class="form-control" value="<?php echo $book_row['publisher']; ?>" />
       					</div>
       				</div>
					<div class="col-md-6">
       					<div class="mb-3">
							<label class="form-label">Book Cover</label>
							<input type="file" accept=".jpg, .jpeg, .png" name="image_file" id="image_file" class="form-control" formenctype="multipart/form-data">
       					</div>
       				</div>
       			</div>
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Publication Date</label>
							<input type="date" name="publication_date" id="publication_date" class="form-control" value="<?php echo $book_row['publication_date']; ?>" />
						</div>
					</div>
					<div class="col-md-6">
       					<div class="mb-3">
       						<label class="form-label">Items Available</label>
       						<input type="number" min="0" name="book_no_of_copy" id="book_no_of_copy" class="form-control" step="1" value="<?php echo $book_row['book_no_of_copy']; ?>" />
       					</div>
       				</div>
				</div>
       			<div class="mt-4 mb-3 text-center">
       				<input type="hidden" name="book_id" value="<?php echo $book_row['book_id']; ?>" />
       				<input type="submit" name="edit_book" formenctype="multipart/form-data" class="btn btn-primary" value="Edit" />
       			</div>
       		</form>
       		<script>
       			document.getElementById('category_id').value = "<?php echo $book_row['category_id']; ?>";
       			document.getElementById('location_rack_id').value = "<?php echo $book_row['location_rack_id']; ?>";
       		</script>
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
		<li class="breadcrumb-item active">Book Management</li>
	</ol>
	<?php 

	if(isset($_GET["msg"]))
	{
		if($_GET["msg"] == 'add')
		{
			echo '<div class="alert alert-success alert-dismissible fade show" role="alert">New Book(s) Added<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
		}
		if($_GET['msg'] == 'edit')
		{
			echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Book Edited Successfully<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
		}
		if($_GET["msg"] == 'inactive')
		{
			echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Book Status changed to Inactive <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
		}
		if($_GET['msg'] == 'active')
		{
			echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Book Status changed to Active <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
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
					<i class="fas fa-table me-1"></i> Book Management
                </div>
                <div class="col col-md-6" align="right">
                	<a href="book.php?action=add" class="btn btn-success btn-sm">Add</a>
                </div>
            </div>
        </div>
        <div class="card-body">
		<table id="datatablesSimple">
        		<thead> 
        			<tr> 
						<th>Book Cover</th>
        				<th>Book Title</th>
        				<th>Status</th>
        				<th>Action</th>
        			</tr>
        		</thead>
        		<tfoot>
        			<tr>
						<th>Book Cover</th>
        				<th>Book Title</th>
        				<th>Status</th>
        				<th>Action</th>
        			</tr>
        		</tfoot>
        		<tbody>
        		<?php 

        		if($statement->rowCount() > 0)
        		{
        			foreach($statement->fetchAll() as $row)
        			{
        				$book_status = '';
        				if($row['book_status'] == 'Active')
        				{
        					$book_status = '<div class="badge bg-success">Active</div>';
        				}
        				else
        				{
        					$book_status = '<div class="badge bg-danger">Inactive</div>';
        				}
        				echo '
        				<tr>
							<td><img src="../asset/Uploads/'.$row["image_file"].'" width="70" align="center"/></td>
        					<td>'.$row["book_name"].'</td>
        					<td>'.$book_status.'</td>
        					<td>
        						<a href="book.php?action=edit&code='.$row["book_id"].'" class="btn btn-sm btn-primary">View</a>
        						<button type="button" name="delete_button" class="btn btn-danger btn-sm" onclick="delete_data(`'.$row["book_id"].'`, `'.$row["book_status"].'`)">Change</button>
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
    <script>

    	function delete_data(code, status)
    	{
    		var new_status = 'Active';
    		if(status == 'Active')
    		{
    			new_status = 'Inactive';
    		}

    		if(confirm("Change Status to "+new_status+"?"))
    		{
    			window.location.href = "book.php?action=delete&code="+code+"&status="+new_status+"";
    		}
    	}

    </script>
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