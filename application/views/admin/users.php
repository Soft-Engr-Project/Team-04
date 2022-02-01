	<div class="wrapper">
		<div class="row">
			<div class="col-12 col-m-12 col-sm-12">

				<div class="counter">
					<p>
						<em class="fas fa-users"></em>
					</p>
					<h3>
						<?php echo $counts["users"];?>
					</h3>
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
						<table aria-describedby="myTable">
							<thead>
								<tr>
									<th scope="col" >#</th>
									<th scope="col" >Username</th>
									<th scope="col" >First Name</th>
									<th scope="col" >Last Name</th>
                                    <th scope="col" >Status</th>
								</tr>
							</thead>
							<tbody>
							<?php $count = 0;
								foreach($users as $user):
								$count++?>
								<tr>
									
									<td><?php echo $count;?></td>
									<td><a href="#modal"><?php echo $user["username"];?></a></td>
									<td><?php echo $user["firstname"];?></td>
                                    <td><?php echo $user["lastname"];?></td>
									<td>
										<span class="dot">
											<em class="bg-success"></em>
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
										<h6 id = "username">username</h6>
										<h4>User</h4>	
									</div>
								</div>

								<div class="cardprofile-image">
								
										<img id = "profile_photo" src="" alt="Profile Photo">
									
								</div>
							</div>
							<a href="#" class="connectprofile"> View Profile</a>
						</div>
					</div>

					<div class="col-8 col-m-8 	col-sm-8">
						<div class="card">
						<h3><a href="#"><em class="fas fa-arrow-left"></em></a></h3>
							<h3 class="profile_admin">Personal Information</h3>
							<div class="row">
								<div class="col-4 col-m-4 col-sm-4">
									<p>Username</p>
									<p>Last Name:</p>
									<p>Birthdate:</p>
									<p>Email:</p>
									<p>Account Created:</p>
		
								</div>
								<div class="col-8 col-m-8 col-sm-8">
									<p id = "username1">username</p>
									<p id = "firstname">firstname</p>
									<p id = "lastname">lastname</p>
									<p id = "birthdate">birthdate"</p>
									<p id = "email">email</p>
									<p id = "created_at">created_at</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
		
	<script type="text/javascript">
		function fetchUser(){
			$.ajax({
	        url : "<?php echo base_url();?>admins/fetchUsers",
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
									<td><a href="#usermodalid" id="modal" value= "${user["user_id"]}">${user["username"]}</a></td>
									<td>${user["firstname"]}</td>
                                    <td>${user["lastname"]}</td>
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
	top.location.href = '#'; // Reload the page to original url (closes the modal)
	fetchUser();
	setInterval("fetchUser()",2000);

	$(document).on("click","#modal",function(e){
		e.preventDefault();
		var user_id = $(this).attr("value"); // Get the ID of clicked user
		
		$.ajax({
			url : "<?php echo base_url();?>admins/fetchUserInfo",
			type : "post",
			data : {
				user_id : user_id,
		
			},
			success : function(data){
			let result = data.replace(/<!--  -->/g, "");
			data = JSON.parse(result);
			url = "<?php echo base_url()?>"
			
			// Change the values of the modal to user infos
			if(data['user']['user_profile_photo']){
				$("#profile_photo").attr('src', url+data['user']['user_profile_photo']) 
			}else {
				$("#profile_photo").attr('src', url+"assets/image/user.png")
			}
			$('#username').text(data['user']['username']);
			$('#username1').text(data['user']['username']);
			$('#firstname').text(data['user']['firstname']);
			$('#lastname').text(data['user']['lastname']);
			$('#birthdate').text(data['user']['birthdate']);
			$('#created_at').text(data['user']['created_at']);

			top.location.href = '#usermodalid'; // Works like and href in <a>
			
			}

		});
        
    })
	</script>
