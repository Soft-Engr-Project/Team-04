<div class="container">
<br>
<br>
<br>
<br>
<h1>Do you want to
	 <?=$title?>
?</h1>
<p>You can always log back in at any time. </p>
<a href="<?php echo base_url();?>pages/view" class="btn btn-primary">Cancel</a>

<a href="<?= base_url();?>Logouts/logout" class="btn btn-danger">Log out</a>
</div>
<script>
    const rgbaColor = <?php echo json_encode($_SESSION["bgColor"]); ?>; 
    document.querySelector('body').style.background = rgbaColor;
</script>