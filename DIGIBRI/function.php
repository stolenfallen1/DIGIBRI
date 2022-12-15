<?php

function base_url()
{
	return 'http://localhost/DIGIBRI/';
}

function is_admin_login()
{
	if(isset($_SESSION['admin_id']))
	{
		return true;
	}
	return false;
}

function is_user_login()
{
	if(isset($_SESSION['user_id']))
	{
		return true;
	}
	return false;
}

function is_librarian_login()
{
	if(isset($_SESSION['librarian_id']))
	{
		return true;
	}
	return false;
}

function total_book($connect)
{
	$total = 0;

	$query = "
	SELECT COUNT(book_id) AS Total FROM lms_book 
	";

	$result = $connect->query($query);

	foreach($result as $row)
	{
		$total = $row["Total"];
	}

	return $total;
}

function active_book($connect)
{
	$total = 0;

	$query = "
	SELECT COUNT(book_id) AS Total FROM lms_book 
	WHERE book_status = 'Active' 
	";

	$result = $connect->query($query);

	foreach($result as $row)
	{
		$total = $row["Total"];
	}

	return $total;
}

function active_user($connect)
{
	$total = 0;

	$query = "
	SELECT COUNT(user_id) AS Total FROM lms_user 
	WHERE user_status = 'Active'
	";

	$result = $connect->query($query);

	foreach($result as $row)
	{
		$total = $row["Total"];
	}
	return $total;
}

function total_user($connect)
{
	$total = 0;

	$query = "
	SELECT COUNT(user_id) AS Total FROM lms_user 
	";

	$result = $connect->query($query);

	foreach($result as $row)
	{
		$total = $row["Total"];
	}
	return $total;
}

function books_issued($connect)
{
	$total = 0;

	$query = "
	SELECT COUNT(issue_book_id) AS Total FROM lms_issue_book
	";

	$result = $connect->query($query);

	foreach($result as $row)
	{
		$total = $row["Total"];
	}
	return $total;
}

function books_returned($connect)
{
	$total = 0;

	$query = "
	SELECT COUNT(issue_book_id) AS Total FROM lms_issue_book WHERE book_issue_status = 'Returned'
	";

	$result = $connect->query($query);

	foreach($result as $row)
	{
		$total = $row["Total"];
	}
	return $total;
}

function books_pending($connect)
{
	$total = 0;

	$query = "
	SELECT COUNT(issue_book_id) AS Total FROM lms_issue_book WHERE book_issue_status = 'Pending'
	";

	$result = $connect->query($query);

	foreach($result as $row)
	{
		$total = $row["Total"];
	}
	return $total;
}

function book_borrowed($connect)
{
	$total = 0;

	$query = "
	SELECT COUNT(issue_book_id) AS Total FROM lms_issue_book 
	WHERE book_issue_status = 'Borrowing'
	";

	$result = $connect->query($query);

	foreach($result as $row)
	{
		$total = $row["Total"];
	}
	return $total;
}

function unreturned($connect)
{
	$total = 0;

	$query = "
	SELECT COUNT(issue_book_id) AS Total FROM lms_issue_book 
	WHERE book_issue_status = 'Late'
	";

	$result = $connect->query($query);

	foreach($result as $row)
	{
		$total = $row["Total"];
	}
	return $total;
}

function total_fine($connect)
{
	$total = 0;

	$query = "
	SELECT SUM(book_fines) AS Total FROM lms_issue_book 
	WHERE book_issue_status = 'Returned'
	";

	$result = $connect->query($query);

	foreach($result as $row)
	{
		$total = $row["Total"];
	}

	return $total;
}

function fill_category($connect)
{
	$query = "
	SELECT category_id, category_name 
	FROM lms_category 
	WHERE category_status = 'Active' 
	ORDER BY category_name ASC
	"; 

	$result = $connect->query($query);

	$output = '<option value="">Select Category</option>';

	foreach($result as $row)
	{
		$output .= '<option value="'.$row["category_id"].'">'.$row["category_name"].'</option>';
	}

	return $output;
}

function fill_location_rack($connect)
{
	$query = "
	SELECT location_rack_id, location_rack_name 
	FROM lms_location_rack 
	WHERE location_rack_status = 'Active' 
	ORDER BY location_rack_name ASC
	";

	$result = $connect->query($query);

	$output = '<option value="">Select Location Rack</option>';

	foreach($result as $row)
	{
		$output .= '<option value="'.$row["location_rack_id"].'">'.$row["location_rack_name"].'</option>';
	}

	return $output;
}


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////



/////////////////////////////////////////////////////////////////////////////////////////////////////////////

function get_book_issue_limit_per_user($connect)
{
	$output = '';
	$query = "
	SELECT library_issue_total_book_per_user FROM lms_setting 
	LIMIT 1
	";
	$result = $connect->query($query);
	foreach($result as $row)
	{
		$output = $row["library_issue_total_book_per_user"];
	}
	return $output;
}

function total_pend($connect, $school_id)
{
	$output = 0;

	$query = "
	SELECT SUM(no_of_copy) AS Total FROM lms_issue_book 
	WHERE (school_id = '".$school_id."' AND book_issue_status = 'Pending')
	";

	$result = $connect->query($query);

	foreach($result as $row)
	{
		$output = $row["Total"];
	}
	return $output;
}

function total_borrow($connect, $school_id)
{
	$output = 0;

	$query = "
	SELECT SUM(no_of_copy) AS Total FROM lms_issue_book 
	WHERE (school_id = '".$school_id."' AND book_issue_status = 'Borrowing')
	";

	$result = $connect->query($query);

	foreach($result as $row)
	{
		$output = $row["Total"];
	}
	return $output;
}

function total_late($connect, $school_id)
{
	$output = 0;

	$query = "
	SELECT SUM(no_of_copy) AS Total FROM lms_issue_book 
	WHERE (school_id = '".$school_id."' AND book_issue_status = 'Late')
	";

	$result = $connect->query($query);

	foreach($result as $row)
	{
		$output = $row["Total"];
	}
	return $output;
}

function get_total_fine_per_user($connect, $school_id)
{
	$output = 0;

	$query = "
	SELECT SUM(book_fines) AS Total FROM lms_issue_book 
	WHERE school_id = '".$school_id."' 
	AND book_issue_status = 'Late'
	";

	$result = $connect->query($query);

	foreach($result as $row)
	{
		$output = $row["Total"];
	}
	return $output;
}

function get_total_book_issue_day($connect)
{
	$output = 0;

	$query = "
	SELECT library_total_book_issue_day FROM lms_setting 
	LIMIT 1
	";

	$result = $connect->query($query);

	foreach($result as $row)
	{
		$output = $row["library_total_book_issue_day"];
	}
	return $output;
}


////////////////////////////////////////////////////////////////////////////////////////////////////////

function get_one_day_fines($connect)
{
	$output = 0;
	$query = "
	SELECT library_one_day_fine FROM lms_setting 
	LIMIT 1
	";
	$result = $connect->query($query);
	foreach($result as $row)
	{
		$output = $row["library_one_day_fine"];
	}
	return $output;
}

function notify($connect)
{
	$total = 0;
	$blank;
	$query = "
	SELECT COUNT(issue_book_id) AS Total FROM lms_issue_book WHERE book_issue_status = 'Pending'
	";

	$result = $connect->query($query);

	foreach($result as $row)
	{
		$total = $row["Total"];
	}
	return $total;
	

}
?>