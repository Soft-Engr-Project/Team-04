<h2><?=$title?></h2>

<div class="container">
	<?php foreach ($categories as $category): ?>
		<h3>
			<a href="<?php echo site_url("categories/view/".$category["name"]);?>">
				<?php echo $category["name"];?>
			</a>
	</h3>
	<?php endforeach ?>

</div>