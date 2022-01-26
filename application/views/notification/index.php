<h2><?=$title?></h2>
<div class="row">
	<?php if(!empty($notification)){?>
<?php foreach ($notification as $notify): ?>
		<?php if($notify["type_of_notif"] == "comment"){?>
				
				<div>
					<p><a href="<?php echo site_url("posts/view/".$notify["post_id"]);?>"><?php echo $notify["username"]?> commented in your post</a></p>
				</div>
				
			
		<?php }elseif($notify["type_of_notif"] == 'react'){?>
			<div>
				<p><a href="<?php echo site_url("posts/view/".$notify["post_id"]);?>"><?php echo $notify["username"]?> reacted to your comment</a></p>
			</div>
		<?php } elseif($notify["type_of_notif"] == 'reply') { ?>
			<div>
				<p><a href="<?php echo site_url("subcomments/view/".$notify["post_id"]);?>"><?php echo $notify["username"]?> reply to your comment</a></p>
			</div>
		<?php } elseif($notify["type_of_notif"] == 'reply_react') { ?>
			<div>
				<p><a href="<?php echo site_url("subcomments/view/".$notify["post_id"]);?>"><?php echo $notify["username"]?> reacted to your comment</a></p>
			</div>
		<?php } ?>
<?php endforeach ?>
<?php }else{?>
	<div>
		<p>No Notification Found</p>
	</div>

<?php }?>
</div>