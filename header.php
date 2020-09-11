<?php
/*require_once("functions.php");

checkMaintenanceMode();*/

//include("connection.php");
$request_page_name = isset($page_name) ? $page_name : null;
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo(isset($page_title) ? $page_title : "Engineering Technology Innovation Center - University of Peradeniya") ?></title>
	<meta charset="UTF-8">
	<meta name="description" content="Unica University Template">
	<meta name="keywords" content="event, unica, creative, html">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Favicon -->   
	<link href="assets/img/favicon.ico" rel="shortcut icon"/>

	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i" rel="stylesheet">

	<!-- Stylesheets -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="assets/css/consult_modal.css" >
    <link rel="stylesheet" href="assets/css/font-awesome.min.css"/>
	<link rel="stylesheet" href="assets/css/themify-icons.css"/>
	<link rel="stylesheet" href="assets/css/animate.css"/>
	<link rel="stylesheet" href="assets/css/owl.carousel.css"/>
	<link rel="stylesheet" href="assets/css/style.css"/>
    <link rel="stylesheet" href="assets/css/menu.css"/>
    <link rel="stylesheet" href="assets/css/icofont.min.css"/>
    <link rel="stylesheet" href="assets/css/back-to-top.css"/>


    <!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

</head>
<body>
	<!-- Page Preloder -->
	<div id="preloder">
		<div class="loader"></div>
	</div>

    <!-- Back to top button -->
    <a id="bttButton"></a>

	<!-- header section -->
	<header class="header-section" style="background-color:#FFFFFF;">
		<div class="container">
			<!-- logo -->
			<a href="index.php" class="site-logo"><img src="assets/img/logoetic.png" alt=""></a>
			<div class="nav-switch">
				<i class="fa fa-bars"></i>
			</div>
		</div>
	</header>
	<!-- header section end-->


	<!-- Header section  -->
	<nav class="nav-section">
		<div class="container">
			<ul class="main-menu">
                <li <?php if ($request_page_name == 'home') {
                    echo('class="active"');
                } ?>><a href="index.php">Home</a></li>
                <li <?php if ($request_page_name == 'about_etic' || $request_page_name == 'etic_team' || $request_page_name == 'management_board') {

                } ?> class="dropdown">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle">About Us</a>
                    <ul class="dropdown-menu">
                        <li><a href="about-etic.php">About ETIC</a></li>
                        <li><a href="etic-team.php">ETIC Team</a></li>
                        <li><a href="management-board.php">Board of Management</a></li>
                    </ul>
                </li>
                <li <?php if ($request_page_name == 'operation') {
                    echo('class="active"');
                } ?>><a href="operation.php">Operation</a></li>
                <li <?php if ($request_page_name == 'projects') {
                    echo('class="active"');
                } ?>><a href="projects.php">Projects</a></li>
                <li <?php if ($request_page_name == 'news') {
                    echo('class="active"');
                } ?>><a href="news.php">News</a></li>
                <li <?php if ($request_page_name == 'contact') {
                    echo('class="active"');
                } ?>><a href="contact.php">Contact</a></li>
			</ul>
		</div>
	</nav>
	<!-- Header section end -->



