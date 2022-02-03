<a href="<?php echo base_url();?>profiles/view">
    <em class="fas fa-arrow-circle-left btn btn-secondary btn-lg px-3 py-1"></em>
</a>
<h1><?=$title;?></h1>
<small class="post-date">Posted on <?php echo $post["created_at"];?></small>
<div class="post-body">
    <p><?php echo $post["body"];?></p>
</div>

<script>
const rgbaColor = <?php echo json_encode($_SESSION["bgColor"]); ?>; 
document.querySelector('body').style.background = rgbaColor;
</script>
<!--  pag gusto mo mag navigate sa controller -->