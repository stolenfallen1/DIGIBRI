<?php

//issue_book.php

include '../database_connection.php';

include '../function.php';

if(!is_admin_login())
{
	header('location:../index.php');
}

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
                    WHERE school_id = '".$formdata['user_id']."'
                    ";

                    $statement = $connect->prepare($query);

                    $statement->execute();

                    if($statement->rowCount() > 0)
                    {
                        foreach($statement->fetchAll() as $user_row)
                        {
								$copies = $formdata['no_of_copy'];								

                                $book_issue_limit = get_book_issue_limit_per_user($connect);

                                $total_book_issue = total_pend($connect, $formdata['user_id']) + total_borrow($connect, $formdata['user_id']) + total_late($connect, $formdata['user_id']);
								
								$acopies = $copies + $total_book_issue;								

                                if($total_book_issue < $book_issue_limit && $copies <= $book_issue_limit && $acopies <= $book_issue_limit)
                                {
                                    $total_book_issue_day = get_total_book_issue_day($connect);

                                    $today_date = date("Y-m-d H:i:s");

                                    $expected_return_date = date('Y-m-d H:i:s', strtotime($today_date. ' + '.$total_book_issue_day.' days'));

                                    $data = array(
                                        ':book_isbn_number'      =>  $formdata['book_id'],
                                        ':school_id'      =>  $formdata['user_id'],
                                        ':issue_date_time'  =>  $today_date,
                                        ':expected_return_date' => $expected_return_date,
                                        ':return_date_time' =>  '',
                                        ':book_fines'       =>  0,
										':no_of_copy'       =>  $formdata['no_of_copy'],										
                                        ':book_issue_status'    =>  'Borrowing'
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

                                    header('location:issue_book.php?msg=add');
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

if(isset($_POST["book_accept_button"]))
{
	    $total_book_issue_day = get_total_book_issue_day($connect);
		
        $today_date = date("Y-m-d H:i:s");
		
        $expected_return_date = date('Y-m-d H:i:s', strtotime($today_date. ' + '.$total_book_issue_day.' days'));
		
        $data = array(
            ':book_issue_status'    =>  'Borrowing',
            ':issue_date_time'  =>  $today_date,
			':expected_return_date' => $expected_return_date,
            ':issue_book_id'        =>  $_POST['issue_book_id']
			
        );  

        $query = "
        UPDATE lms_issue_book  
        SET book_issue_status = :book_issue_status,
		issue_date_time = :issue_date_time,
		expected_return_date = :expected_return_date
        WHERE issue_book_id = :issue_book_id
        ";

        $statement = $connect->prepare($query);

        $statement->execute($data);

        header("location:issue_book.php?msg=add");
}

if(isset($_POST["book_deny_button"]))
{
        $data = array(
            ':book_issue_status'    =>  'Denied',
			':no_of_copy'    =>  0,
            ':issue_book_id'        =>  $_POST['issue_book_id']
        );  

        $query = "
        UPDATE lms_issue_book 
        SET book_issue_status = :book_issue_status,
		no_of_copy = :no_of_copy
        WHERE issue_book_id = :issue_book_id
        ";

        $statement = $connect->prepare($query);

        $statement->execute($data);

        $query = "
        UPDATE lms_book 
        SET book_no_of_copy = book_no_of_copy + '".$_POST["no_of_copy"]."' 
        WHERE book_isbn_number = '".$_POST["book_isbn_number"]."'
        ";

        $connect->query($query);

        header("location:issue_book.php?msg=add");
}

if(isset($_POST["book_return_button"]))
{
	
    if(isset($_POST["book_return_confirmation"]))
    {
        $data = array(
            ':return_date_time'     =>  date("Y-m-d H:i:s"),
            ':book_issue_status'    =>  'Returned',
            ':issue_book_id'        =>  $_POST['issue_book_id']
        );  

        $query = "
        UPDATE lms_issue_book 
        SET return_date_time = :return_date_time, 
        book_issue_status = :book_issue_status 
        WHERE issue_book_id = :issue_book_id
        ";

        $statement = $connect->prepare($query);

        $statement->execute($data);

        $query = "
        UPDATE lms_book 
        SET book_no_of_copy = book_no_of_copy + '".$_POST["no_of_copy"]."' 
        WHERE book_isbn_number = '".$_POST["book_isbn_number"]."'
        ";

        $connect->query($query);

        header("location:issue_book.php?msg=return");
    }
    else
    {
        $error = 'Please first confirm returned book received by click on checkbox';
    }
}

   

$query = "
	SELECT * FROM lms_issue_book 
	INNER JOIN lms_book ON lms_book.book_isbn_number = lms_issue_book.book_isbn_number
	INNER JOIN lms_user ON lms_user.school_id = lms_issue_book.school_id	
	ORDER BY lms_issue_book.issue_book_id DESC
";

$statement = $connect->prepare($query);

$statement->execute();

include '../header.php';

?>
<div class="container-fluid py-4" style="min-height: 700px;">
	<h1>Issue Book Management</h1>
    <?php 

    if(isset($_GET["action"]))
    {
        if($_GET["action"] == 'add')
        {
    ?>
    <ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="issue_book.php">Issue Book Management</a></li>
        <li class="breadcrumb-item active">Issue Book(s)</li>
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
                    <i class="fas fa-book"></i> Issue Book(s)
                </div>
                <div class="card-body">
                    <form method="post">
                        <div class="mb-3">
                            <label class="form-label">Book ISBN</label>
                            <input type="text" name="book_id" id="book_id" class="form-control" />
                            <span id="book_isbn_result"></span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">School ID</label>
                            <input type="text" name="user_id" id="user_id" class="form-control" />
                            <span id="school_id_result"></span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No. of book(s) to borrow</label>
                            <input type="number" min="0" name="no_of_copy" id="no_of_copy" class="form-control" >
                            <span id="no_of_copy"></span>
                        </div>						
                        <div class="mt-4 mb-0">
                            <input type="submit" name="issue_book_button" class="btn btn-success" value="Issue" />
                        </div>  
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php 
        }
        else if($_GET["action"] == 'view')
        {
            $issue_book_id = $_GET["code"];

            if($issue_book_id > 0)
            {
                $query = "
                SELECT * FROM lms_issue_book 
                WHERE issue_book_id = '$issue_book_id'
                ";

                $result = $connect->query($query);

                foreach($result as $row)
                {
                    $query = "
                    SELECT * FROM lms_book 
                    WHERE book_isbn_number = '".$row["book_isbn_number"]."'
                    ";

                    $book_result = $connect->query($query);

                    $query = "
                    SELECT * FROM lms_user 
                    WHERE school_id = '".$row["school_id"]."'
                    ";

                    $user_result = $connect->query($query);

                    echo '
                    <ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="issue_book.php">Issue Book Management</a></li>
                        <li class="breadcrumb-item active">View Issue Book Details</li>
                    </ol>
                    ';

                    if($error != '')
                    {
                        echo '<div class="alert alert-danger">'.$error.'</div>';
                    }

                    foreach($book_result as $book_data)
                    {
                        echo '
                        <h2>Book Details</h2>
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%">Book ISBN</th>
                                <td width="70%">'.$book_data["book_isbn_number"].'</td>
                            </tr>
                            <tr>
                                <th width="30%">Book Title</th>
                                <td width="70%">'.$book_data["book_name"].'</td>
                            </tr>
                            <tr>
                                <th width="30%">Author</th>
                                <td width="70%">'.$book_data["book_author"].'</td>
                            </tr>
                        </table>
                        <br />
                        ';
                    }

                    foreach($user_result as $user_data)
                    {
                     $total_user_fine = get_total_fine_per_user($connect, $user_data['school_id']);
					 
					 if ($total_user_fine > 0)
						{					 
                        echo '
                        <h2>User Details</h2>
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%">School ID</th>
                                <td width="70%">'.$user_data["school_id"].'</td>
                            </tr>
                            <tr>
                                <th width="30%">User Name</th>
                                <td width="70%">'.$user_data["user_name"].'</td>
                            </tr>
                            <tr>
                                <th width="30%">Full Name</th>
                                <td width="70%">'.$user_data["user_fname"].' '.$user_data["user_lname"].'</td>
                            </tr>							
                            <tr>
                                <th width="30%">User Address</th>
                                <td width="70%">'.$user_data["user_address"].'</td>
                            </tr>
                            <tr>
                                <th width="30%">User Contact No.</th>
                                <td width="70%">'.$user_data["user_contact_no"].'</td>
                            </tr>
                            <tr>
                                <th width="30%">User Email Address</th>
                                <td width="70%">'.$user_data["user_email_address"].'</td>
                            </tr>
                            <tr>
                                <th width="30%">Total Fines</th>
                                <td width="70%">₱ '.$total_user_fine.'</td>
                            </tr>							
                        </table>
                        <br />
                        ';
						}
					else
					{
                        echo '
                        <h2>User Details</h2>
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%">School ID</th>
                                <td width="70%">'.$user_data["school_id"].'</td>
                            </tr>
                            <tr>
                                <th width="30%">User Name</th>
                                <td width="70%">'.$user_data["user_name"].'</td>
                            </tr>
                            <tr>
                                <th width="30%">Full Name</th>
                                <td width="70%">'.$user_data["user_fname"].' '.$user_data["user_lname"].'</td>
                            </tr>							
                            <tr>
                                <th width="30%">User Address</th>
                                <td width="70%">'.$user_data["user_address"].'</td>
                            </tr>
                            <tr>
                                <th width="30%">User Contact No.</th>
                                <td width="70%">'.$user_data["user_contact_no"].'</td>
                            </tr>
                            <tr>
                                <th width="30%">User Email Address</th>
                                <td width="70%">'.$user_data["user_email_address"].'</td>
                            </tr>
                            <tr>
                                <th width="30%">Total Fines</th>
                                <td width="70%">₱ 0</td>
                            </tr>							
                        </table>
                        <br />
                        ';						
					}
					}

                    $status = $row["book_issue_status"];

                    $form_item = '';

                    if($status == "Borrowing")
                    {
                        $status = '<span class="badge bg-warning">Borrowing</span>';

                        $form_item = '
                        <label><input type="checkbox" name="book_return_confirmation" value="Yes" /> I aknowledge that I have received the borrowed book</label>
                        <br />
                        <div class="mt-4 mb-4">
                            <input type="submit" name="book_return_button" value="Book Return" class="btn btn-primary" />
                        </div>
                        ';
                    }
					
                    if($status == "Pending")
                    {
                        $status = '<span class="badge bg-success">Pending</span>';

                        $form_item = '
                        <div class="mt-4 mb-4">
                            <input type="submit" name="book_accept_button" value="Accept" class="btn btn-primary" />
                            <input type="submit" name="book_deny_button" value="Deny" class="btn btn-danger" />							
                        </div>						
                        ';
                    }

                    if($status == 'Late')
                    {
                        $status = '<span class="badge bg-danger">Late</span>';

                        $form_item = '
                        <label><input type="checkbox" name="book_return_confirmation" value="Yes" /> I aknowledge that I have received Borrowed Book</label><br />
                        <div class="mt-4 mb-4">
                            <input type="submit" name="book_return_button" value="Book Return" class="btn btn-primary" />
                        </div>
                        ';
                    }
					
                    if($status == 'Denied')
                    {
                        $status = '<span class="badge bg-danger">Denied</span>';
                    }	

                    if($status == 'Cancelled')
                    {
                        $status = '<span class="badge bg-danger">Cancelled</span>';
                    }							

                    if($status == 'Returned')
                    {
                        $status = '<span class="badge bg-info">Returned</span>';
                    }

                    echo '
                    <h2>Issue Book Details</h2>
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Book Issue Date</th>
                            <td width="70%">'.$row["issue_date_time"].'</td>
                        </tr>
                        <tr>
                            <th width="30%">Book Return Date</th>
                            <td width="70%">'.$row["return_date_time"].'</td>
                        </tr>
                        <tr>
                            <th width="30%">No. of Copies Borrowed</th>
                            <td width="70%">'.$row["no_of_copy"].'</td>
                        </tr>
                        <tr>
                            <th width="30%">Book(s) Issue Status</th>
                            <td width="70%">'.$status.'</td>
                        </tr>
                        <tr>
                            <th width="30%">Fines</th>
                            <td width="70%">₱ '.$row["book_fines"].'</td>
                        </tr>
                    </table>
                    <form method="POST">
                        <input type="hidden" name="issue_book_id" value="'.$issue_book_id.'" />
                        <input type="hidden" name="book_isbn_number" value="'.$row["book_isbn_number"].'" />
						<input type="hidden" name="no_of_copy" value="'.$row["no_of_copy"].'" />
                        '.$form_item.'
                    </form>
                    <br />
                    ';

                }
            }
        }
    }
    else
    {
    ?>
	<ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
		<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
        <li class="breadcrumb-item active">Issue Book Management</li>
    </ol>

    <?php 
    if(isset($_GET['msg']))
    {
        if($_GET['msg'] == 'add')
        {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Book(s) Issued Successfully<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        }

        if($_GET["msg"] == 'return')
        {
            echo '
            <div class="alert alert-success alert-dismissible fade show" role="alert">Borrowed Book(s) Returned Successfully<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>
            ';
        }
    }
    ?>

    <div class="card mb-4">
    	<div class="card-header">
    		<div class="row">
    			<div class="col col-md-6">
    				<i class="fas fa-table me-1"></i> Issue Book Management
                </div>
                <div class="col col-md-6" align="right">
                    <a href="issue_book.php?action=add" class="btn btn-success btn-sm">Issue</a>
                </div>
            </div>
        </div>
        <div class="card-body">
        	<table id="datatablesSimple">
        		<thead>
        			<tr>
        				<th>Book Title</th>
                        <th>Library Patron</th>
                        <th>Issue Date</th>
						<th>Due Date</th>
                        <th>Return Date</th>
                        <th>Fines</th>
                        <th>Status</th>
                        <th>Action</th>
        			</tr>
        		</thead>
        		<tfoot>
        			<tr>
        				<th>Book Title</th>
                        <th>Library Patron</th>
                        <th>Issue Date</th>
						<th>Due Date</th>
                        <th>Return Date</th>
                        <th>Fines</th>
                        <th>Status</th>
                        <th>Action</th>
        			</tr>
        		</tfoot>
        		<tbody>
        		<?php
        		if($statement->rowCount() > 0)
        		{
        			$one_day_fine = get_one_day_fines($connect);

        			foreach($statement->fetchAll() as $row)
        			{
        				$status = $row["book_issue_status"];

        				$book_fines = $row["book_fines"];
						
						$book_copies = $row['no_of_copy'];

        				if($row["book_issue_status"] == "Borrowing")
        				{
        					$current_date_time = new DateTime(date("Y-m-d H:i:s"));
        					$expected_return_date = new DateTime(date($row["expected_return_date"]));

        					if($current_date_time > $expected_return_date)
        					{
        						$interval = $current_date_time->diff($expected_return_date);

        						$total_day = $interval->d;
								
								$fine = $book_copies * $one_day_fine;

        						$book_fines = $total_day * $fine;

        						$status = 'Late';

        						$query = "
        						UPDATE lms_issue_book 
													SET book_fines = '".$book_fines."', 
													book_issue_status = '".$status."' 
													WHERE issue_book_id = '".$row["issue_book_id"]."'
        						";

        						$connect->query($query);
        					}
        				}
						
        				if($row["book_issue_status"] == "Late")
        				{
        					$current_date_time = new DateTime(date("Y-m-d H:i:s"));
        					$expected_return_date = new DateTime(date($row["expected_return_date"]));

        					if($current_date_time > $expected_return_date)
        					{
        						$interval = $current_date_time->diff($expected_return_date);

        						$total_day = $interval->d;

								$fine = $book_copies * $one_day_fine;

        						$book_fines = $total_day * $fine;

        						$query = "
        						UPDATE lms_issue_book 
													SET book_fines = '".$book_fines."'  
													WHERE issue_book_id = '".$row["issue_book_id"]."'
        						";

        						$connect->query($query);
        					}
        				}						

        				if($status == 'Borrowing')
        				{
        					$status = '<span class="badge bg-warning">Borrowing</span>';
        				}
						
        				if($status == 'Pending')
        				{
        					$status = '<span class="badge bg-success">Pending</span>';
        				}

        				if($status == 'Denied')
        				{
        					$status = '<span class="badge bg-danger">Denied</span>';
        				}

        				if($status == 'Cancelled')
        				{
        					$status = '<span class="badge bg-danger">Cancelled</span>';
        				}						

        				if($status == 'Late')
        				{
        					$status = '<span class="badge bg-danger">Late</span>';
        				}

        				if($status == 'Returned')
        				{
        					$status = '<span class="badge bg-info">Returned</span>';
        				}

        				echo '
        				<tr>
        					<td>'.$row["book_name"].'</td>
        					<td>'.$row["user_fname"].' '.$row["user_lname"].'</td>
        					<td>'.$row["issue_date_time"].'</td>
							<td>'.$row["expected_return_date"].'</td>
        					<td>'.$row["return_date_time"].'</td>
        					<td>₱ '.$book_fines.'</td>
        					<td>'.$status.'</td>
        					<td>
                                <a href="issue_book.php?action=view&code='.$row["issue_book_id"].'" class="btn btn-primary btn-sm">View</a>
                            </td>
        				</tr>
        				';
        			}
        		}
        		else
        		{
        			echo '
        			<tr>
        				<td colspan="7" class="text-center">No Data Found</td>
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

