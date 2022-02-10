	<div class="wrapper">
		<div class="row">
			<div class="col-3 col-m-6 col-sm-6">
				<a href="<?php echo base_url();?>admins/users">
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
				<a href="<?php echo base_url();?>admins/categories">
				<div class="counter">
					<p>
						<em class="fas fa-mail-bulk"></em>
					</p>
					<h3>
						<?php echo $counts["categories"];?>
					</h3>
					<p>Total Categories</p>
				</div>
				</a>
			</div>
			<div class="col-3 col-m-6 col-sm-6">
				<a href="<?php echo base_url();?>admins/posts">
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
				<a href="<?php echo base_url();?>admins/dashboard">
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
							<tbody id="bodyReport">
							
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal for suspend user -->
	<div class="modal fade" id="exampleModal" 
		tabindex="-1" role="dialog" 
		aria-labelledby="exampleModalLabel" aria-hidden="true">

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
        function fetch(){
        	$.ajax({
				url : "<?php echo base_url()?>admins/fetchDashboard",
				type : "post",
				success : function(data){
				
					data = JSON.parse(data);
				
					arr = Object.keys(data);
					let count = 0;
					let reportBody="";
					// data["message"].forEach(report => {
						for(i = 0 ;i< arr.length;i++){
	
							count++;
                                   reportBody+=`<tr>
                                    <td>${count}</td>`
                                    if(data[arr[i]]["post_id"]) {
                         reportBody+=`   <td class="user_report">
                                            ${data[arr[i]]["title"]}
                                          </td>`;
                                    }
                                    else if(data[arr[i]]["comment_id"]) {
										reportBody+=` <td class="user_report">
                                            ${data[arr[i]]["content"]}
                                            </td>`;
                                    } else {
										reportBody+= `<td class="user_report">
                                            ${data[arr[i]]["reply"]}
                                            </td>`
									}
									reportBody +=`
									<td class="user_report">${data[arr[i]]["reason"]}</td>
                                    <td class="user_report">
                                        <a href="#">${data[arr[i]]["complainant"]}
                                        ${data[arr[i]]["username"]}</a>
                                    </td>
                                    <td>${data[arr[i]]["created_at"]}</td>`;
									reportBody +=`
									<td>
                                        <div class="dropdown">
                                            <button type="button" class="profilebutton" id="buttonmenu" data-bs-toggle="dropdown">
                                            <em class="fas fa-ellipsis-h"></em>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <label for="editpost">
                                                <li class="dropdown-item">`;
												if(data[arr[i]]["post_id"] != null &&data[arr[i]]["comment_id"] == null && data[arr[i]]["subcomment_id"] == null) {
													reportBody+=`<a id="deletePost" value="${data[arr[i]]["post_id"]}">Delete Post</a>`;
												} else if(data[arr[i]]["post_id"] == null &&data[arr[i]]["comment_id"] != null && data[arr[i]]["subcomment_id"] == null) {
													reportBody+=`<a id="del" value="${data[arr[i]]["comment_id"]}">Delete Comment</a>`;
												} else {
													reportBody+=`<a id="del_sub" value="${data[arr[i]]["subcomment_id"]}">Delete Reply</a>`;
												}
                                            
                                                reportBody+=`</li>
                                                </label>`;
												reportBody += `
													<label for="remove">
													<li class="dropdown-item">
													<form action="<?php echo base_url()?>reports/delete/${data[arr[i]]["id"]}" method="POST">
														<input type="submit" id="remove" name = "report_id">
															Delete Report
													</form>
													</li>
													</label>
												`;
												reportBody +=`
															<label for="suspend">
															<li class="dropdown-item">
																<input type="submit" id="suspend" value = "${data[arr[i]]["user_id"]}">
																	Suspend user
															</li>
															</label>
														</ul>
													</div>
												</td>
												
												</tr>
												`;
									
						}
					$("#bodyReport").html(reportBody);
				}
			});
        }
		fetch();

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

   		$(document).on("click","#deletePost",function(e){
        e.preventDefault();
        let postId = $(this).attr("value");

      if(postId == ""){
        alert("Delete id required");
      }else{
        const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger me-3'
          },
          buttonsStyling: false
        })

        // Confirmation alert
        swalWithBootstrapButtons.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, delete it!',
          cancelButtonText: 'No, cancel!',
          reverseButtons: true
        }).then((result) => {
          
          // If user confirmed the deletion
          if (result.isConfirmed) {
            $.ajax({
              url : "<?php echo base_url()?>posts/delete",
              type : "post",
              data : {
                postId : postId
              },
              success : function(data){
                let result = data.replace(/<!--  -->/g, "");
                data = JSON.parse(result);
                
                // Action success dialog
                if(data.response == "success"){
                  swalWithBootstrapButtons.fire(
                  'Deleted!',
                  'Your post has been deleted.',
                  'success'
                  );
                }
              }
            });
            // If user canceled the action
          } else if (
            /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.cancel
          ) {
            swalWithBootstrapButtons.fire(
              'Cancelled',
              'Your post is safe :)',
              'error'
            )
          }
        })
      }
     })

	   $(document).on("click","#del",function(e){
      e.preventDefault();
      var comment_id = $(this).attr("value");
      if(comment_id == ""){
        alert("Delete id required");
      }else{
        const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger me-3'
          },
          buttonsStyling: false
        })

        // Confirmation alert
        swalWithBootstrapButtons.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, delete it!',
          cancelButtonText: 'No, cancel!',
          reverseButtons: true
        }).then((result) => {
          
          // If user confirmed the deletion
          if (result.isConfirmed) {
            $.ajax({
              url : "<?php echo base_url()?>comments/delete",
              type : "post",
              data : {
                comment_id : comment_id
              },
              success : function(data){
                fetch();
                let result = data.replace(/<!--  -->/g, "");
                data = JSON.parse(result);
                

                // Action success dialog
                if(data.response == "success"){
                  swalWithBootstrapButtons.fire(
                  'Deleted!',
                  'Your comment has been deleted.',
                  'success'
                  )
                }
                
              }
            });
            // If user canceled the action
          } else if (
            /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.cancel
          ) {
            swalWithBootstrapButtons.fire(
              'Cancelled',
              'Your comment is safe :)',
              'error'
            )
          }
        })
      }
    });
	$(document).on("click","#del_sub",function(e){
      e.preventDefault();
      var subcomment_id = $(this).attr("value");
      
      if(subcomment_id == ""){
        alert("Delete id required");
      }else{
        const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger me-3'
          },
          buttonsStyling: false
        })

        // Confirmation alert
        swalWithBootstrapButtons.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, delete it!',
          cancelButtonText: 'No, cancel!',
          reverseButtons: true
        }).then((result) => {
          
          // If user confirmed the deletion
          if (result.isConfirmed) {
            $.ajax({
              url : "<?php echo base_url()?>subcomments/delete",
              type : "post",
              data : {
                subcomment_id : subcomment_id
              },
              success : function(data){
                fetch();
                let result = data.replace(/<!--  -->/g, "");
                data = JSON.parse(result);
                

                // Action success dialog
                if(data.response == "success"){
                  swalWithBootstrapButtons.fire(
                  'Deleted!',
                  'Your comment has been deleted.',
                  'success'
                  )
                }
              }
            });
            // If user canceled the action
          } else if (
            /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.cancel
          ) {
            swalWithBootstrapButtons.fire(
              'Cancelled',
              'Your comment is safe :)',
              'error'
            )
          }
        })
      }
    });
	</script>