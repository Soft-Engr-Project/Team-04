<?php 
  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";
  	redirect("/");
  }
?>


<h2><?= $title?></h2>
<p>Welcome to Microblogging App</p>

