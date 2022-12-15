<?php 


include '../database_connection.php';

if(isset($_POST["action"]))
{
	if($_POST["action"] == 'search_book_isbn')
	{
		$query = "
		SELECT book_isbn_number, book_name FROM lms_book 
		WHERE book_isbn_number LIKE '%".$_POST["request"]."%' 
		AND book_status = 'Active'
		";

		$result = $connect->query($query);

		$data = array();

		foreach($result as $row)
		{
			$data[] = array(
				'isbn_no'		=>	str_replace($_POST["request"], '<b>'.$_POST["request"].'</b>', $row["book_isbn_number"]),
				'book_name'		=>	$row['book_name']
			);
		}
		echo json_encode($data);
	}
	
	if($_POST["action"] == 'search_user_id')
	{
		$query = "
		SELECT school_id, user_name FROM lms_user 
		WHERE school_id LIKE '%".$_POST["request"]."%' 
		";

		$result = $connect->query($query);

		$data = array();

		foreach($result as $row)
		{
			$data[] = array(
				'school_id'	=>	str_replace($_POST["request"], '<b>'.$_POST["request"].'</b>', $row["school_id"]),
				'user_name'			=>	$row["user_name"]
			);
		}

		echo json_encode($data);
	}		
}

?>