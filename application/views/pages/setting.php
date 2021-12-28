<div class="container">
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
<div class="btn btn-primary">
    <a href="<?php echo site_url("customization/view")?>">Customization</a>
</div>
<br>
<br>
<div class="btn btn-danger">
    <a href="<?php echo base_url();?>pages/view">Home</a>
</div>
</div>