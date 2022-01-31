	<div class="wrapper">
		<div class="row">
			<div class="col-12 col-m-12 col-sm-12">

				<div class="counter">
					<p>
						<i class="fas fa-users"></i>
					</p>
					<h3><?php echo $counts["users"];?></h3>
                    <p>Total User</p>
				</div>
			</div>
			
		</div>
		<div class="row">
			<div class="col-12 col-m-12 col-sm-12">
				<div class="card">
					<div class="card-header">
						<h3>
							All Users
						</h3>
					</div>
					<div class="card-content">
						<table>
							<thead>
								<tr>
									<th>#</th>
									<th>Username</th>
									<th>First Name</th>
									<th>Last Name</th>
									<th>Birthdate</th>
                                    <th>Status</th>
								</tr>
							</thead>
							<tbody>
							<?php $count = 0;
								foreach($users as $user):
								$count++?>
								<tr>
									<td><?php echo $count;?></td>
									<td><a href="#usermodalid"><?php echo $user["username"];?></a></td>
									<td><?php echo $user["firstname"];?></td>
                                    <td><?php echo $user["lastname"];?></td>
                                    <td><?php echo $user["birthdate"];?></td>
									<td>
										<span class="dot">
											<i class="bg-success"></i>
                                            Online
										</span>
									</td>
								</tr>
                            <?php endforeach;?>
							</tbody>
						</table>
					</div>
				</div>
			</div>	
			<div class="usermodal" id="usermodalid">
				<div class="row">
					<div class="col-4 col-m-4 col-sm-4">
						<div class="card">
							<div class="cardprofile">
								<div class="content">
									<div>
										<h6>username</h6>
										<h4>User</h4>	
									</div>
								</div>
								<div class="cardprofile-image">
									<img src="p.jpg" alt="">
								</div>
							</div>
							<a href="#" class="connectprofile"> View Profile</a>
						</div>
					</div>
					<div class="col-8 col-m-8 	col-sm-8">
						<div class="card">
							<h3 class="profile_admin">Personal Information</h3>
							<a href="#"><i class="fas fa-arrow-left"></i></a>
							<div class="row">
								<div class="col-4 col-m-4 col-sm-4">
									<p>Username</p>
									<p>First Name:</p>
									<p>Last Name:</p>
									<p>Birthdate:</p>
									<p>Total Posts:</p>
									<p>Total Likes:</p>
									<p>Total Disikes:</p>
									<p>Total Comments:</p>
									<p>Total Reported:</p>
									<p>Account Created:</p>
		
								</div>
								<div class="col-8 col-m-8 col-sm-8">
									<p>Test palang</p>
									<p>Hello</p>
									<p>Try</p>
									<p>03/07/2001</p>
									<p>30</p>
									<p>30</p>
									<p>50</p>
									<p>10</p>
									<p>10</p>
									<p>10</p>
								</div>
							</div>
						</div>
					</div>	
				</div>		
			</div>
		</div>
	</div>

	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>	
	<script type="text/javascript">

		function fetchUser(){
			$.ajax({
	        url : "<?php echo base_url();?>admins/fetchUser",
	        type : "post",
	        success:function(data){
	        let result = data.replace(/<!--  -->/g, "");
            data = JSON.parse(result);
            userBody = "";
            let count = 0;
	        	data["users"].forEach(user => {
	        				count++;
							 userBody += `	<tr>
									<td>${count}</td>
									<td><a href="#usermodalid">${user["username"]}</a></td>
									<td>${user["firstname"]}</td>
                                    <td>${user["lastname"]}</td>
                                    <td>${user["birthdate"]}</td>
									<td>
										<span class="dot">`;
											if(user["isLogin"] == 1){
										userBody += `<i class="bg-success"></i>
                                           	 Online`
											}else {
												userBody += `<i style="background-color:grey;"></i>
                                           	 Offline`;
											}
										userBody += `	
										</span>
									</td>
								</tr>`;
	        	});
							
                $("tbody").html(userBody);     
	        }
	       });
		}
 fetchUser();
 setInterval("fetchUser()",2000);
	</script>