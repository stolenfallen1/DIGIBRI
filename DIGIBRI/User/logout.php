<?php 


session_start();

unset($_SESSION['user_id']);

header('location:homepage.php');
?>