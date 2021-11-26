<?php 
  if (isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "Please Logout First";
  	redirect("/pages/view");
  }
?>

<body id="passwordverify">
    <div class="squareyellow">
        <div class="card">
            <div class="row">
                <div class="col-lg-6">
                    <div class="myleftforgot">
                        <h1>Thinklik</h1>
                        <div class="form-group mb-3 col-md-12">
                           <a href="<?php echo base_url();?>"><input type="submit" class="button1" value="Sign In"></a>
                        </div>
                        <div class="form-group mb-3 col-md-12">
                            <a href="<?php echo site_url("postreg/register"); ?>"><input type="submit" class="button1" value="Sign Up"></a>
                        </div>
                    </div> 
                </div>
                <div class="col-lg-6">
                    <div class="myrightreset">
                        <h5>Registration Successful!</h5>
                        <p class="passverify">Please check your email to verify your account. Thank you.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
        
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    
</body>