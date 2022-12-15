<?php

include '../database_connection.php';

include '../function.php';


if(!is_librarian_login())
{
	header('location:librarian_login.php');
}

include 'librarian_header.php';

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
				<p>DIGIBRI provides library patrons a way to search and borrow books from the library through their computer/phones in the comfort of their home.
				It helps librarians manage books in the library and borrow requests from library patrons to promote a new and modern approach in managing a library.</p>
			</div>
			<section class="faq-container">
			<h2 class="faq-header">About Book Management</h2>
			</section>
			<div class="faq-div">
				<img src="./Images/a.png"><br><br>
				<p><i class="fa fa-arrow-right" aria-hidden="true"></i> 
				Book management is where you can add, view, edit, and change the status of books in the library.<br>
				Click the Add button if you want to add new books to the library.<br>
				Search a specific book using the search bar.<br>
				Click the View button to view details of a specific book.<br>
				Click the Change button to change the status of a book if its available or not.</p>					
			</div>
			
			<section class="faq-container">
			<h2 class="faq-header">How to Add Books?</h2>
			</section>
			<div class="faq-div">
				<img src="./Images/c.png"><br><br>
				<p><i class="fa fa-arrow-right" aria-hidden="true"></i> 
				After clicking the Add button, you will be sent here where you can add new books. 
				Click the Add button after filling the necessary details to add new books to the library.</p>				
			</div>

			<section class="faq-container">
			<h2 class="faq-header">How to Edit Books?</h2>
			</section>
			<div class="faq-div">
				<img src="./Images/b.png"><br><br>
				<p><i class="fa fa-arrow-right" aria-hidden="true"></i> 
				After clicking the View button, you will be sent here where you can edit the details of a book. 
				After changing book details, click the Edit button to confirm the changes made.</p>					
			</div>

			<section class="faq-container">
			<h2 class="faq-header">Category and Location Rack Management</h2>
			</section>
			<div class="faq-div">
				<p><i class="fa fa-arrow-right" aria-hidden="true"></i> 
				The process is the same with Book Management. Add, view, edit, and change the status of the category or location racks in the library.</p>					
			</div>	

			<section class="faq-container">
			<h2 class="faq-header">Issue Book Management</h2>
			</section>
			<div class="faq-div">
				<img src="./Images/d.png"><br><br>
				<p><i class="fa fa-arrow-right" aria-hidden="true"></i> 
				Issue Book Management is where you can issue books and manage book requests.<br>
				Click the Issue button to issue/lend books to library patrons.<br>
				Search a specific issue book entry using the search bar.<br>
				Click the view button to view more details of a specific issue book entry.</p>					
			</div>		

			<section class="faq-container">
			<h2 class="faq-header">How to Issue Books?</h2>
			</section>
			<div class="faq-div">
				<img src="./Images/e.png"><br><br>			
				<p><i class="fa fa-arrow-right" aria-hidden="true"></i> 
				After clicking the Issue button, you will be sent here where you can issue books. 
				Click the Issue button after filling the necessary details to issue books to library patrons.</p>					
			</div>

			<section class="faq-container">
			<h2 class="faq-header">Dealing with Book Returns and Book Requests</h2>
			</section>
			<div class="faq-div">
				<img src="./Images/f.png"><br><br>			
				<p><i class="fa fa-arrow-right" aria-hidden="true"></i> 
				After clicking the View button, you will be sent here where you will have varying actions based on the status of the issue book entry.<br> 
				This is where you will confirm that borrowed books have been returned to the library.<br>
				This is where you will accept or deny a request to borrow books from library patrons.</p>					
			</div>	

			<section class="faq-container">
			<h2 class="faq-header">Library Patron Management</h2>
			</section>
			<div class="faq-div">
				<img src="./Images/g.png"><br><br>
				<p><i class="fa fa-arrow-right" aria-hidden="true"></i> 
				Library Patron Management is where you can add, view, and edit library patrons.<br>
				Click the Register button to register new library patrons.<br>
				Search a specific library patron using the search bar.<br>
				Click the view button to view more details of a specific library patron.</p>
			</div>

			<section class="faq-container">
			<h2 class="faq-header">How to Register Library Patrons?</h2>
			</section>
			<div class="faq-div">
				<img src="./Images/h.png"><br><br>
				<p><i class="fa fa-arrow-right" aria-hidden="true"></i> 
				After clicking the Register button, you will be sent here where you can register new library patrons.<br> 
				Click the Register button after filling the necessary details to register new library patrons.</p>				
			</div>

			<section class="faq-container">
			<h2 class="faq-header">How to Change Settings?</h2>
			</section>
			<div class="faq-div">
				<img src="./Images/i.png"><br><br>
				<p><i class="fa fa-arrow-right" aria-hidden="true"></i> 
				Click on the icon at the top right then click settings to access DIGIBRI settings.<br>
				Click the Save button after changing the settings to save changes made.</p>				
			</div>			
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