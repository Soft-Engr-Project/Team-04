<!DOCTYPE html>
<html>
<head>
	<title>Admin</title>

	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

	
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

	<link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@300&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/adminstyle.css">
</head>
<body class="overlay-scrollbar">
	<div class="navbar">
		<ul class="navbar-nav">
			<li class="nav-item">
				<a class="nav-link">
					<i class="fas fa-bars" onclick="collapseSidebar()"></i>
				</a>
			</li>
			<li class="nav-item">
				<!-- image logo -->
				<!-- <img src="assets/AT-pro-black.png" alt="ATPro logo" class="logo logo-light">
				<img src="assets/AT-pro-white.png" alt="ATPro logo" class="logo logo-dark"> -->

			</li>
		</ul>
		<form class="navbar-search">
			<input type="text" name="Search" class="navbar-search-input" placeholder="What you looking for...">
			<i class="fas fa-search"></i>
		</form>
		<ul class="navbar-nav nav-right">
			<li class="nav-item mode">
				<a class="nav-link" href="#" onclick="switchTheme()">
					<i class="fas fa-moon dark-icon"></i>
					<i class="fas fa-sun light-icon"></i>
				</a>
			</li>
		</ul>
	</div>
	<div class="sidebar">
		<ul class="sidebar-nav">
			<li class="sidebar-nav-item">
				<a href="<?php echo base_url();?>Admins/profile" class="sidebar-nav-link ">
					<div>
						<img src="<?php echo base_url();?>assets/image/user.png"  alt="">
					</div>
					<span>Profile</span>
				</a>
			</li>
			<li class="sidebar-nav-item">
				<a href="<?php echo base_url();?>Admins/dashboard" class="sidebar-nav-link active">
					<div>
						<i class="fas fa-tachometer-alt"></i>
					</div>
					<span>
						Dashboard
					</span>
				</a>
			</li>
			<li class="sidebar-nav-item">
				<a href="<?php echo base_url();?>Admins/users" class="sidebar-nav-link">
					<div>
						<i class="fas fa-users"></i>
					</div>
					<span>Users</span>
				</a>
			</li>
			<li  class="sidebar-nav-item">
				<a href="<?php echo base_url();?>Admins/categories" class="sidebar-nav-link">
					<div>
						<i class="fas fa-mail-bulk"></i>
					</div>
					<span>Categories</span>
				</a>
			</li>
            <li  class="sidebar-nav-item">
				<a href="<?php echo base_url();?>Admins/posts" class="sidebar-nav-link">
					<div>
						<i class="fas fa-envelope"></i>
					</div>
					<span>Posts</span>
				</a>
			</li>
			<li  class="sidebar-nav-item">
				<a href="<?php echo base_url();?>Logouts/admin_logout" class="sidebar-nav-link">
					<div>
						<i class="fas fa-sign-out"></i>
					</div>
					<span>Logout</span>
				</a>
			</li>
		</ul>
	</div>