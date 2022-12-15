<?php

include '../database_connection.php';

include '../function.php';


if(!is_user_login())
{
	header('location:user_login.php');
}

$message = '';
$error = '';


if(isset($_POST["issue_book_button"]))
{
    $formdata = array();

    if(empty($_POST["book_id"]))
    {
        $error .= '<li>Book ISBN is required</li>';
    }
    else
    {
        $formdata['book_id'] = trim($_POST['book_id']);
    }

    if(empty($_POST["user_id"]))
    {
        $error .= '<li>School ID is required</li>';
    }
    else
    {
        $formdata['user_id'] = trim($_POST['user_id']);
    }
	
    if(empty($_POST["no_of_copy"]))
    {
        $error .= '<li>No. of books to borrow is required</li>';
    }
    else
    {
        $formdata['no_of_copy'] = trim($_POST['no_of_copy']);
    }

    if($error == '')
    {
        //Check Book Available or Not

        $query = "
        SELECT * FROM lms_book 
        WHERE book_isbn_number = '".$formdata['book_id']."'
        ";

        $statement = $connect->prepare($query);

        $statement->execute();

        if($statement->rowCount() > 0)
        {
            foreach($statement->fetchAll() as $book_row)
            {
                //check book is available or not
                if($book_row['book_status'] == 'Active' && $book_row['book_no_of_copy'] > 0)
                {
                    //Check User is exist

                    $query = "
                    SELECT * FROM lms_user 
                    WHERE school_id = '".$_SESSION['user_id']."'
                    ";

                    $statement = $connect->prepare($query);

                    $statement->execute();

                    if($statement->rowCount() > 0)
                    {
                        foreach($statement->fetchAll() as $user_row)
                        {
                                //Check User Total issue of Book
								$copies = $formdata['no_of_copy'];
								
                                $book_issue_limit = get_book_issue_limit_per_user($connect);

                                $total_book_issue = total_pend($connect, $formdata['user_id']) + total_borrow($connect, $formdata['user_id']) + total_late($connect, $formdata['user_id']);
							
								$acopies = $copies + $total_book_issue;

                                if($total_book_issue < $book_issue_limit && $copies <= $book_issue_limit && $acopies <= $book_issue_limit)
                                {

                                    $data = array(
                                        ':book_isbn_number'      =>  $formdata['book_id'],
                                        ':school_id'      =>  $formdata['user_id'],
                                        ':issue_date_time'  =>  '',
                                        ':expected_return_date' => '',
                                        ':return_date_time' =>  '',
                                        ':book_fines'       =>  0,
										':no_of_copy'       =>  $formdata['no_of_copy'],										
                                        ':book_issue_status'    =>  'Pending'
                                    );

                                    $query = "
                                    INSERT INTO lms_issue_book 
                                    (book_isbn_number, school_id, issue_date_time, expected_return_date, return_date_time, book_fines, no_of_copy, book_issue_status) 
                                    VALUES (:book_isbn_number, :school_id, :issue_date_time, :expected_return_date, :return_date_time, :book_fines, :no_of_copy, :book_issue_status)
                                    ";

                                    $statement = $connect->prepare($query);

                                    $statement->execute($data);

                                    $query = "
                                    UPDATE lms_book 
                                    SET book_no_of_copy = book_no_of_copy - $copies
                                    WHERE book_isbn_number = '".$formdata['book_id']."' 
                                    ";

                                    $connect->query($query);

                                    header('location:search_book.php?msg=add');
                                }
                                else
                                {
                                    $error .= 'User has already reached Book Issue Limit';
                                }
                        }
                    }
                    else
                    {
                        $error .= '<li>User not Found</li>';
                    }
                }
                else
                {
                    $error .= '<li>Book not Available</li>';
                }
            }
        }
        else
        {
            $error .= '<li>Book not Found</li>';
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

	header('location:search_book.php?msg='.strtolower($status).'');
}


$query = "
	SELECT * FROM lms_book 
    ORDER BY book_id DESC
";

$statement = $connect->prepare($query);

$statement->execute();

$query = "
	SELECT * FROM lms_user 
	WHERE school_id = '".$_SESSION['user_id']."'
";

$result = $connect->query($query);

include 'user_header.php';

?>

<div class="container-fluid py-4" style="min-height: 700px;">
	<h1>Books</h1>
    <?php 

    if(isset($_GET["action"]))
    {
        if($_GET["action"] == 'borrow')
        {
			$book_id = $_GET["code"];

			if($book_id > 0)
			{
				$query = "
				SELECT * FROM lms_book 
                WHERE book_id = '$book_id'
				";

				$book_result = $connect->query($query);
				
				$query = "
				SELECT * FROM lms_user 
				WHERE school_id = '".$_SESSION['user_id']."'
				";

				$user_result = $connect->query($query);				

				foreach($book_result as $book_row)
				{
				foreach($user_result as $user_row)
				{					
			
    ?>
    <ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
        <li class="breadcrumb-item"><a href="search_book.php">Search Book</a></li>
        <li class="breadcrumb-item active">Borrow Book(s)</li>
    </ol>
	
    <div class="row">
        <div class="col-md-6">
            <?php 
            if($error != '')
            {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><ul class="list-unstyled">'.$error.'</ul> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            ?>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-book"></i> Borrow Book(s)
                </div>
                <div class="card-body">
                    <form method="post">
                        <div class="hide">
                            <input type="hidden" name="book_id" id="book_id" class="form-control" value="<?php echo $book_row['book_isbn_number']; ?>" readonly/>
                            <span id="book_isbn_result"></span>
                        </div>							
                        <div class="hide">
                            <input type="hidden" name="user_id" id="user_id" class="form-control"/ value="<?php echo $user_row['school_id']; ?>" readonly/>
                            <span id="school_id_result"></span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Book Title</label>
                            <input name="book_name" id="book_name" class="form-control" value="<?php echo $book_row['book_name']; ?>" readonly/>
                            <span id="book_name"></span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No. of Copies</label>
                            <input name="book_copies" id="book_copies" class="form-control" value="<?php echo $book_row['book_no_of_copy']; ?>" readonly/>
                            <span id="book_copies"></span>
                        </div>						
                        <div class="mb-3">
                            <label class="form-label">No. of book(s) to borrow</label>
                            <input type="number" min="0" name="no_of_copy" id="no_of_copy" class="form-control" >
                            <span id="no_of_copy"></span>
                        </div>							
                        <div class="mt-4 mb-0">
                            <input type="submit" name="issue_book_button" class="btn btn-success" value="Borrow" />
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
		
	if(isset($_GET["action"]))
	{
		if($_GET["action"] == 'edit')
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
        <li class="breadcrumb-item"><a href="search_book.php">Search Book</a></li>
        <li class="breadcrumb-item active">View Book</li>
    </ol>
    <div class="card mb-4">
    	<div class="card-header">
    		<i class="fas fa-book"></i> View Book
       	</div>
       	<div class="card-body">
       		<form method="post">
       			<div class="row">
       				<div class="col-md-6">
       					<div class="mb-3">
       						<label class="form-label">Book Title</label>
       						<input disabled="disabled" name="book_name" id="book_name" class="form-control" value="<?php echo $book_row['book_name']; ?>" />
       						<label class="form-label">Author(s)</label>
       						<input disabled="disabled" name="book_author" id="book_author" class="form-control" value="<?php echo $book_row['book_author']; ?>" />							
       						<label class="form-label">Category</label>
       						<select disabled="category_id" id="category_id" class="form-control">
       							<?php echo fill_category($connect); ?>
       						</select>
       						<label class="form-label">Location Rack</label>
       						<select disabled="location_rack_id" id="location_rack_id" class="form-control">
       							<?php echo fill_location_rack($connect); ?>
       						</select>
       						<label class="form-label">ISBN</label>
       						<input disabled="disabled" name="book_isbn_number" id="book_isbn_number" class="form-control" value="<?php echo $book_row['book_isbn_number']; ?>" />
       						<label class="form-label">Publisher</label>
       						<input disabled="disabled" name="publisher" id="publisher" class="form-control" value="<?php echo $book_row['publisher']; ?>" />
       					</div>
       				</div>				
       				<div class="col-md-6">
       					<div class="mb-3">
							<label class="form-label">Book Cover</label><br>
							 <img src=../asset/Uploads/<?php echo  $book_row['image_file'];?>	name="image_file" id="image_file" width="380" height="390" border="1px" />
       					</div>
					</div>
       			</div>			
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Publication Date</label>
							<input disabled="disabled" name="publication_date" id="publication_date" class="form-control" value="<?php echo $book_row['publication_date']; ?>" />
						</div>
					</div>
					<div class="col-md-6">
       					<div class="mb-3">
       						<label class="form-label">Items Available</label>
       						<input disabled="disabled" name="book_no_of_copy" id="book_no_of_copy" class="form-control" step="1" value="<?php echo $book_row['book_no_of_copy']; ?>" />
       					</div>
       				</div>
				</div>
				
					<div class="text-center mt-15 mb-2">
							<a href="search_book.php?action=borrow&code=<?php echo $book_row['book_id']; ?>" class="btn btn-sm btn-success">Borrow</a>
					</div>				
				
				
       		</form>
       		<script>
       			document.getElementById('book_author').value = "<?php echo $book_row['book_author']; ?>";
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
	}
	else
	{	
	?>
	<ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
		<li class="breadcrumb-item active">Search Book</li>
	</ol>
	
    <?php 
    if(isset($_GET['msg']))
    {
        if($_GET['msg'] == 'add')
        {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Borrowing Request Sent<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        }
    }
    ?>

	<div class="card mb-4">
		<div class="card-header">
			<div class="row">
				<div class="col col-md-6">
					<i class="fas fa-table me-1"></i> Search Book
                </div>
                <div class="col col-md-6" align="right">
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
        						<a href="search_book.php?action=edit&code='.$row["book_id"].'" class="btn btn-sm btn-primary">View</a>
        						<a href="search_book.php?action=borrow&code='.$row["book_id"].'" class="btn btn-success btn-sm">Borrow</a>							
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