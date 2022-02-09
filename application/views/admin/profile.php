	<div class="wrapper">
		<div class="row">
			<div class="col-4 col-m-4 col-sm-4">
				<div class="card">
					<div class="cardprofile">
						<div class="content">
							<div>
								<h6>
									<?php echo $admin["username"];?>
								</h6>
								<h4>Admin</h4>
							</div>
						</div>
						<div class="cardprofile-image">
							<img src="<?php echo base_url();?>assets/image/user.png" alt="">
						</div>
					</div>
				</div>
			</div>

			<div class="col-8 col-m-8 	col-sm-8">
				<div class="card">
					<h3 class="profile_admin">Personal Information</h3>
					<div class="row">
						<div class="col-4 col-m-4 col-sm-4">
							<p>Username</p>
							<p>First Name:</p>
							<p>Last Name:</p>
							<p>Birthdate:</p>
							<p>Email:</p>
							<p>Account Created:</p>

						</div>
						<div class="col-8 col-m-8 col-sm-8">
							<p><?php echo $admin["username"];?></p>
							<p><?php echo $admin["firstname"];?></p>
							<p><?php echo $admin["lastname"];?></p>
							<p><?php echo $admin["birthdate"];?></p>
							<p><?php echo $admin["email"];?></p>
							<p><?php echo $admin["created_at"];?></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>