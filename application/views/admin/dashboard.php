	<div class="wrapper">
		<div class="row">
			<div class="col-3 col-m-6 col-sm-6">
				<a href="users_adminview.html">
				<div class="counter">
					<p>
						<em class="fas fa-users"></em>
					</p>
					<h3>
						<?php echo $counts["users"];?>
					</h3>
					<p>Total Users</p>
				</div>
				</a>
			</div>
			<div class="col-3 col-m-6 col-sm-6">
				<div class="counter">
					<p>
						<em class="fas fa-mail-bulk"></em>
					</p>
					<h3><?php echo $counts["categories"];?></h3>
					<p>Total Categories</p>
				</div>
			</div>
			<div class="col-3 col-m-6 col-sm-6">
				<a href="#">
				<div class="counter">
					<p>
						<em class="fas fa-envelope"></em>
					</p>
					<h3>
						<?php echo $counts["posts"];?>
					</h3>
					<p>Total Posts</p>
				</div>
				</a>
			</div>
			<div class="col-3 col-m-6 col-sm-6">
				<a href="#report">
				<div class="counter">
					<p>
						<em class="fas fa-flag"></em>
					</p>
					<h3>
						<?php echo $counts["reports"];?>
					</h3>
					<p>Total Reports</p>
				</div>
				</a>
			</div>
		</div>
		<div class="row">
			<div class="col-12 col-m-12 col-sm-12">
				<div class="card" id="report">
					<div class="card-header">
						<h3>Reports</h3>
						<em class="fas fa-ellipsis-h"></em>
					</div>
					<div class="card-content">
						<table aria-describedby="myTable">
							<thead>
								<tr>
									<th scope="col" >#</th>
									<th class="user_report" scope="col" >Reports</th>
									<th class="user_report" scope="col" > Reasons</th>
									<th scope="col" >Complainant</th>
									<th scope="col" >Date</th>
									
								</tr>
							</thead>
							<tbody>
								<?php $count = 0;
								foreach($reports as $report):
								$count++?>
									<tr>
									
									<td><?php echo $count;?></td>
									<?php if($report["post_id"]):?>
										<td class="user_report"><a href="<?php echo site_url("posts/".$report["post_id"]);?>"><?php echo $report["title"];?></a></td>
									<?php else:?>
										<td class="user_report"><a href="<?php echo site_url("posts/view_comment/".$report["comment_id"]);?>"><?php echo $report["content"];?></a></td>
									<?php endif;?>
									<td class="user_report"><?php echo $report["reason"];?> </td>
									<td class="user_report"><a href="#"><?php echo $report["complainant"];?> <?php echo $report["username"];?> </a></td>
									<td><?php echo $report["created_at"];?> </td>

									<td> 
										<div class="dropdown">
											<button type="button" class="profilebutton" id="buttonmenu" data-bs-toggle="dropdown">
											<em class="fas fa-ellipsis-h"></em>
											</button>
											<ul class="dropdown-menu">
												<label for="editpost">
												<li class="dropdown-item">
												<?php echo form_open("posts/edit/".$post["id"]);?>
													<input type="submit" id="editpost">
														Edit
												</form>
												</li>
												</label>  

												<label for="remove">
												<li class="dropdown-item"> 
												<?php echo form_open("posts/delete/".$post["id"]);?>
													<input type="submit" id="remove">
														Remove 
												</form>
												</li>
												</label> 
											</ul>
                            			</div>
									</td>
									
									</tr>
									<?php endforeach;?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			
		</div>
	</div>