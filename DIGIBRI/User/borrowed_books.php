<?php


include '../database_connection.php';

include '../function.php';

if(!is_user_login())
{
	header('location:user_login.php');
}

$error = '';

if(isset($_POST["cancel_button"]))
{
        $data = array(
            ':book_issue_status'    =>  'Cancelled',
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

        header("location:borrowed_books.php?msg=add");
}

$query = "
	SELECT * FROM lms_issue_book 
	INNER JOIN lms_book 
	ON lms_book.book_isbn_number = lms_issue_book.book_isbn_number 
	WHERE lms_issue_book.school_id = '".$_SESSION['user_id']."' 
	ORDER BY lms_issue_book.issue_book_id DESC
";

$statement = $connect->prepare($query);

$statement->execute();

include 'user_header.php';

?>
<div class="container-fluid py-4" style="min-height: 700px;">
	<h1>Borrowed Books</h1>
    <?php 

    if(isset($_GET["action"]))
    {
		if($_GET["action"] == 'view')
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

                    echo '
                    <ol class="breadcrumb mt-4 mb-4 bg-light p-2 border">
                        <li class="breadcrumb-item"><a href="borrowed_books.php">Borrowed Books</a></li>
                        <li class="breadcrumb-item active">View Borrowed Book(s)</li>
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

                    $status = $row["book_issue_status"];

                    $form_item = '';

                    if($status == "Borrowing")
                    {
                        $status = '<span class="badge bg-warning">Borrowing</span>';
                    }
					
                    if($status == "Pending")
                    {
                        $status = '<span class="badge bg-success">Pending</span>';

                        $form_item = '
                        <div class="mt-4 mb-4">
                            <input type="submit" name="cancel_button" value="Cancel Request" class="btn btn-danger" />							
                        </div>						
                        ';
                    }

                    if($status == 'Late')
                    {
                        $status = '<span class="badge bg-danger">Late</span>';
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
                            <th width="30%">Book Issue Status</th>
                            <td width="70%">'.$status.'</td>
                        </tr>
                        <tr>
                            <th width="30%">Total Fines</th>
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
        <li class="breadcrumb-item active">Borrowed Books</li>
    </ol>

    <?php 
    if(isset($_GET['msg']))
    {
        if($_GET['msg'] == 'add')
        {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Borrowing Request Cancelled<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        }
    }
    ?>

    <div class="card mb-4">
    	<div class="card-header">
    		<div class="row">
    			<div class="col col-md-6">
    				<i class="fas fa-table me-1"></i> Borrowed Books
                </div>
            </div>
        </div>
        <div class="card-body">
        	<table id="datatablesSimple">
        		<thead>
        			<tr>
						<th>Book Title</th>
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

        				if($row["book_issue_status"] == "Borrowing")
        				{
        					$current_date_time = new DateTime(date("Y-m-d H:i:s"));
        					$expected_return_date = new DateTime(date($row["expected_return_date"]));

        					if($current_date_time > $expected_return_date)
        					{
        						$interval = $current_date_time->diff($expected_return_date);

        						$total_day = $interval->d;

        						$book_fines = $total_day * $one_day_fine;

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
							<td>'.$row["issue_date_time"].'</td>
							<td>'.$row["expected_return_date"].'</td>							
							<td>'.$row["return_date_time"].'</td>
							<td>₱ '.$row["book_fines"].'</td>
							<td>'.$status.'</td>
        					<td>
                                <a href="borrowed_books.php?action=view&code='.$row["issue_book_id"].'" class="btn btn-primary btn-sm">View</a>
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
