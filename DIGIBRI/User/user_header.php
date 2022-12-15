<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="generator" content="">
        <title>DIGIBRI</title>
        <link rel="canonical" href="">

        <link href="<?php echo base_url(); ?>asset/css/simple-datatables-style.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>asset/css/styles.css" rel="stylesheet" />
        <script src="<?php echo base_url(); ?>asset/js/font-awesome-5-all.min.js" crossorigin="anonymous"></script> 

        <link rel="apple-touch-icon" href="" sizes="180x180">
        <link rel="icon" href="" sizes="32x32" type="image/png">
        <link rel="icon" href="" sizes="16x16" type="image/png">
        <link rel="manifest" href="">
        <link rel="mask-icon" href="" color="#7952b3">
        <link rel="icon" href="">
        <meta name="theme-color" content="#7952b3">
        <style>
            .bd-placeholder-img {
                font-size: 1.125rem;
                text-anchor: middle;
                -webkit-user-select: none;
                -moz-user-select: none;
                user-select: none;
            }
            nav {
                background-color: #262626;
            }
            .nav-link {
                color: #FFFFFF;
            }
            .nav-link:hover {
                color: #F59292;
            }
            #sidebarToggle, #navbarDropdown {
                color: #FFFFFF;
            }
            @media (min-width: 768px) {
                .bd-placeholder-img-lg {
                    font-size: 3.5rem;
                }
            }
            @media (min-width: 992px) {
                #sidebarToggle {
                    padding-left: 230px;
                }
            }
        </style>
    </head>

    <?php 

    if(is_user_login())
    {

    ?>
    <body class="sb-nav-fixed">

        <nav class="sb-topnav navbar navbar-expand">

            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                
            </form>

            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>

        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <a class="navbar-brand ps-3" href="search_book.php"><img id="WHITE_LOGO"  src="../asset/LOGO_WHITE.png"
                            style="margin-left:30px; margin-bottom:20px;" width="120px" height="auto"></a>
                            <a class="nav-link" href="search_book.php"><i class="fa fa-book" aria-hidden="true"></i>&nbsp;Book</a>
							<a class="nav-link" href="borrowed_books.php"><i class="fa fa-book" aria-hidden="true"></i>&nbsp;Borrowed Books</a>
                            <a class="nav-link" href="FAQ.php"><i class="fa fa-question-circle" aria-hidden="true"></i>&nbsp;FAQ</a>

                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>


    <?php 
    }
    else
    {

    ?>

    <body>

    	<main>

    		<div class="container py-4">

    			<header class="pb-3 mb-4 border-bottom">
                    <div class="row">
        				<div class="col-md-6">
                            <a href="homepage.php" class="d-flex align-items-center text-dark text-decoration-none">
                                <span class="fs-4"><img src="../asset/LOGO_BLACK.png" alt="Logo"
                                width="150" height="auto"></span>
                            </a>
                        </div>
                    </div>

    			</header>
    <?php 
    }
    ?>
	
<script src="<?php echo base_url(); ?>asset/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="<?php echo base_url(); ?>asset/js/scripts.js"></script>
<script src="<?php echo base_url(); ?>asset/js/simple-datatables@latest.js" crossorigin="anonymous"></script>
<script src="<?php echo base_url(); ?>asset/js/datatables-simple-demo.js"></script>