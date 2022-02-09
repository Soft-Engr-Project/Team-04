<p>
  <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
    Filter
  </a>
</p>
<div class="collapse" id="collapseExample">
  <div class="card card-body">
    <p>Category</p>
    <?php foreach ($categories as $category): ?>
      <a href="<?php echo site_url("categories/view/".$category["name"]);?>">
        <?php echo $category["name"];?>
      </a>
    <?php endforeach ?>
      <a href="<?php echo site_url("pages/view");?>">All</a>
  </div>
</div>