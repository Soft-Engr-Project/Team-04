<?php 
  if (isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "Please Logout First";
  	redirect("/pages/view");
  }
?>


Password changed! <br>
  
<a href="<?php echo site_url("/");?>">Return to Login</a>
             
