	<div class="wrapper">
		<div class="row">
			<div class="col-12 col-m-12 col-sm-12">

				<div class="counter">
					<p>
						<em class="fas fa-envelope"></em>
					</p>
					<h3>
						<?php echo $counts["posts"];?>
					</h3>
                    <p>Total Posts</p>
				</div>
			</div>
			
		</div>
		<div class="row">
			<div class="col-12 col-m-12 col-sm-12">
				<div class="card">
					<div class="card-header">
						<h3>
							All Posts
						</h3>
					</div>
					<div class="card-content">
						<table aria-describedby="myTable">
							<thead>
								<tr>
									<th scope="col" >#</th>
									<th scope="col" >Title Posts</th>
									<th scope="col" > Username</th>
                                    <th scope="col" >Comments</th>
                                    <th scope="col" >Likes</th>
                                    <th scope="col" >Dislikes</th>
                                    <th scope="col" >Report</th>
								</tr>
							</thead>
							<tbody>
							<?php $count = 0;
								foreach($posts as $post):
								$count++?>
								<tr>
									<td><?php echo $count;?></td>
									<td><?php echo $post["title"];?></td>
									<td><?php echo $post["username"];?></td>
                                    <td><?php echo $post["post_comment_count"];?></td>
                                    <td><?php echo $post["upvote"];?></td>
                                    <td><?php echo $post["downvote"];?></td>
                                    <td><?php echo $post["reports_count"];?></td>
								</tr>
							<?php endforeach;?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>