	<div class="wrapper">
		<div class="row">
			<div class="col-12 col-m-12 col-sm-12">

				<div class="counter">
					<p>
						<em class="fas fa-mail-bulk"></em>
					</p>
					<h3>
						<?php echo $counts["categories"];?>
					</h3>
                    <p>Total Categories</p>
				</div>
			</div>	
		</div>
		<div class="row">
			<div class="col-12 col-m-12 col-sm-12">
				<div class="card">
					<div class="card-header">
						<h3>
							All Categories
						</h3>
						<a href="#addcat">Add Category</a>
						<div class="addcat" id="addcat">
							<form action="">
							<input type="text" placeholder="Enter new category"> 
							<button class="savebutton">Save</button>
							</form>
							<a href="#" ><button  class="removebutton">Cancel</button></a>
						</div>
					</div>
					<div class="card-content">
						<table aria-describedby="myTable">
							<thead>
								<tr>
									<th scope="col" >#</th>
									<th scope="col" >Categories</th>
									<th scope="col" >Date Created</th>
									<th scope="col" > Total Posts</th>
									<th scope="col" >Remove Category</th>
								</tr>
							</thead>
							<tbody>
							<?php $count = 0;
								foreach($categories as $category):
								$count++?>
								<tr>
									<td><?php echo $count;?></td>
									<td><a href="#"><?php echo $category["name"];?></a></td>
									<td><?php echo $category["created_at"];?></td>
									<td><?php echo $category["category_post_count"];?></td>
									<td><button type="submit" class="removebutton">Remove</button></td>
								</tr>
							</tbody>
							<?php endforeach;?>
						</table>
					</div>
				</div>
			</div>	
		</div>
	</div>