<?php

include '../database_connection.php';

include '../function.php';


if(!is_user_login())
{
	header('location:user_login.php');
}

include 'user_header.php';

?>
<html>
	<head>
		<style>
			.faq-container
			{
				-webkit-border-radius: 17px;
				border-radius: 20px;
				background: #f59292;
				-webkit-box-shadow: 5px 5px 9px #ac6666, -5px -5px 9px #ffbebe;
				box-shadow: 5px 5px 9px #ac6666, -5px -5px 9px #ffbebe;
				opacity: 75%;
				padding: 20px;
				margin: 50px 30px 15px 30px;
			}
			.faq-header {
				color: #000000;
				opacity: 100%;
			}
			.faq-div {
				-webkit-border-radius: 47px;
				border-radius: 20px;
				background: #accbdc;
				-webkit-box-shadow: 5px 5px 10px #96b1bf, -5px -5px 10px #c2e5f9;
				box-shadow: 5px 5px 10px #96b1bf, -5px -5px 10px #c2e5f9;
				padding: 20px;
				margin: 0 30px 50px 30px;
			}
			.faq-div img {
				width: 100%;
			}
		</style>
	</head>
	<body>
		<div class="container-fluid py-4" style="min-height: 700px;">
			<h1>FAQ</h1>
			<section class="faq-container">
				<h2 class="faq-header">What does DIGIBRI provide?</h2>
			</section>
			<div class="faq-div">
				<p>DIGIBRI provides library patrons a way to search and borrow books from the library through their computer/phones in the comfort of their home.</p>
			</div>
			<section class="faq-container">
			<h2 class="faq-header">How to Borrow Books?</h2>
			</section>
			<div class="faq-div">
				<img src="./Images/BrowseBookImage.png"><br><br>
				<p><i class="fa fa-arrow-right" aria-hidden="true"></i> 
				Browse the book of your liking.</p><br>
				<img src="./Images/SearchBookImage.png"><br><br>
				<p><i class="fa fa-arrow-right" aria-hidden="true"></i> 
				Search Book title of your liking, Click borrow if you want to borrow it or 
				view if you want to look at books details further.</p><br>
				<img src="./Images/BorrowBookImage1.png"><br><br>
				<p><i class="fa fa-arrow-right" aria-hidden="true"></i> 
				After clicking the View button, Click the Borrow button if you have decided 
				to borrow it.</p><br>
				<img src="./Images/BorrowBookImage2.png"><br><br>
				<p><i class="fa fa-arrow-right" aria-hidden="true"></i> 
				Then finally press the borrow to send a request to the librarian that you are 
				interested to borrow the choosen book. Input the number of copies you want to
				borrow.</p><br>
				<img src="./Images/PendingStatus.png"><br><br>
				<p><i class="fa fa-arrow-right" aria-hidden="true"></i> Now the request has 
				been sent, go to the borrowed books page by clicking it and as you can see 
				your request has been sent and still on pending.</p><br>
				<img src="./Images/RequestSend.png"><br><br>
				<p><i class="fa fa-arrow-right" aria-hidden="true"></i> 
				Now in the librarian's web application POV he/she can see your request that 
				is still on pending and accept it.</p><br>
				<img src="./Images/BookBorrowed.png"><br><br>
				<p><i class="fa fa-arrow-right" aria-hidden="true"></i> Right after it, you 
				may claim the book by presenting your ID, and the status of the book at the 
				borrowed books page will automatically display "borrowing" meaning you are 
				already borrowing the book.</p><br>				
			</div>
			<section class="faq-container">
			<h2 class="faq-header">How to Cancel Borrow Requests?</h2>
			</section>
			<div class="faq-div">
				<img src="./Images/tocancel.png"><br><br>
				<p><i class="fa fa-arrow-right" aria-hidden="true"></i> 
				Click the View button of the borrow request you wish to cancel. Make sure the 
				request is still pending or you won't be able to cancel the request.</p><br>		
				<img src="./Images/tocancel1.png"><br><br>
				<p><i class="fa fa-arrow-right" aria-hidden="true"></i> 
				Click the Cancel Request button to cancel the book request.</p><br>
				<img src="./Images/cancelled.png"><br><br>
				<p><i class="fa fa-arrow-right" aria-hidden="true"></i> 
				The status will become "cancelled" after cancelling the request to borrow.</p><br>				
			</div>			
			<!--
			<section class="faq-container">
			<h2 class="faq-header">Question 3</h2>
			</section>
			<div class="faq-div">
				<p></p>
			</div> -->
		</div>
	</body>
</html>