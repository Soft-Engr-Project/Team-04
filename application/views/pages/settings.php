<div onclick="checkMousePointer()">
<div style="width: 100vw;
    height: 100vh;"class="container">
<br>
<br>
<br>
<br>
<h2><?= $title ?></h2>
<?php if($this->session->userdata("admin") != true) :?>
<div class="btn btn-outline-info">
    <a href="<?php echo site_url("PersonalInfo/update")?>">Personal Information</a>
</div>
<?php endif;?>
<br>
<br>
<div class="btn btn-outline-success">
    <a href="<?php echo site_url("customization/view")?>">Customization</a>
</div>
<br>
<br>
<?php if($this->session->userdata("admin") == true) :?>
<div class="btn btn-outline-danger">
    <a href="<?php echo base_url("Reports/view");?>">Report Logs</a>
</div>
<?php endif;?>
</div>