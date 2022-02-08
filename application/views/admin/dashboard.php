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
					<h3>
						<?php echo $counts["categories"];?>
					</h3>
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
										<td class="user_report"><a href="<?php echo site_url("posts/".$report["post_id"]);?>">
											<?php echo $report["title"];?>
										</a></td>
									<?php elseif($report["comment_id"]):?>
										<td class="user_report"><a href="<?php echo site_url("posts/view_comment/".$report["comment_id"]);?>">
											<?php echo $report["content"];?>
											</a></td>
									<?php else:?>
										<td class="user_report"><a href="<?php echo site_url("posts/view_comment/".$report["subcomment_id"]);?>">
											<?php echo $report["reply"];?>
											</a></td>
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
												<?php echo form_open("posts/delete/".$report["post_id"]);?>
													<input type="submit" id="editpost">
														Delete Post
												</form>
												</li>
												</label>  

												<label for="remove">
												<li class="dropdown-item"> 
												<?php echo form_open("reports/delete/".$report["id"]);?>
													<input type="submit" id="remove" name = "report_id">
														Delete Report 
												</form>
												</li>
												</label> 

												<label for="suspend">
												<li class="dropdown-item"> 
													<input type="submit" id="suspend" value = "<?php echo $report["user_id"]?>">
														Suspend user
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

	<!-- Modal for suspend user -->
	<div class="modal fade" id="exampleModal"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog " >
			<div class="modal-content">
			
				<!-- Modal Header -->
				<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Suspend user until:</h5>
				</div>

				<!-- Modal Body -->
				<div class="modal-body">
					<div class="statusMsg"></div>
					<form>
						<input type="hidden" id="user_id" name="user_id" value="">
						<input type="datetime-local" name="suspendDate" class="form-control" id="suspendDate">
				</div>

				<!-- Modal Footer -->
				<div class="modal-footer">
				<!--  <button type="button" id="report_close" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
				<a type="submit" class="btn btn-secondary"  id="modalClose">Close</button>
				<a href="#" class="btn btn-primary" id="userSubmit">Confirm</a>
				</form>
				</div>
								
			</div>
		</div>
	</div>
										
	<script type="text/javascript">

		 function toastr_option(){
                  toastr.options = {
                  "closeButton": true,
                  "debug": false,
                  "newestOnTop": false,
                  "progressBar": true,
                  "positionClass": "toast-top-right",
                  "preventDuplicates": false,
                  "onclick": null,
                  "showDuration": "300",
                  "hideDuration": "1000",
                  "timeOut": "5000",
                  "extendedTimeOut": "1000",
                  "showEasing": "swing",
                  "hideEasing": "linear",
                  "showMethod": "fadeIn",
                  "hideMethod": "fadeOut"
                }
        } 

		$(document).on("click","#suspend",function(e){
			e.preventDefault();
			var user_id = $(this).attr("value"); // Get the ID of clicked user
			$(".modal-body #user_id").val(user_id);
		
			$("#exampleModal").modal("show");
   		})

		$(document).on("click","#userSubmit",function(e){
			e.preventDefault();
			user_id = $("#user_id").val();
			date = $("#suspendDate").val(); // Get the ID of clicked user
		
			$.ajax({
				url : "<?php echo base_url()?>admins/suspend",
				type : "post",
				data : {
					user_id : user_id,
					date : date
				},
				success : function(data){
					let result = data.replace(/<!--  -->/g, "");
					data = JSON.parse(result);
					console.log(data);
					if(data.response == "success") {
						$("#exampleModal").modal("hide");
						Command: toastr["success"](data.message)
						toastr_option();

					}else {
						Command: toastr["error"](data.message)
						toastr_option();
					}
				}
			});
		})

		$(document).on("click","#modalClose",function(e){
			e.preventDefault();
			$("#exampleModal").modal("hide");
   		})
	</script>