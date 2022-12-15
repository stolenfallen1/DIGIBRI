<?php

session_start();

unset($_SESSION['librarian_id']);

header('location:homepage.php');

?>