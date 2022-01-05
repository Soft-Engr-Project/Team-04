<div onclick="checkMousePointer()">
<div class="container">
<br>
<br>
<br>
<br>
<h3><?php echo $post["title"];?></h3>
	<!-- image -->
	<?php if(isset($post["post_image"]) && !empty($post["post_image"])):?>
			<img src="<?php echo base_url().$post["post_image"];?>" alt="" width="300">
	<?php endif;?>
	<!-- who post and when  and what category-->
	<small class="post-date">Posted on : <?php echo $post["created_at"];?> in <?php echo $post["name"];?></small>
	<small>Created by : <?php echo ucfirst($post["username"]);?></small>
	<!-- body -->
	<h4><?php echo $post["body"];?></h4>
	<?php if($this->session->userdata("user_id") == $post["user_id"] || $this->session->userdata("admin") == true ) :?>
			<?php echo form_open("posts/delete/".$post["id"]);?>
				<input type="hidden" name="category" value="<?php echo $post["category_id"]?>">
                <button class="btn btn-primary">Delete</button>
			</form>
			<?php echo form_open("posts/edit/".$post["id"]);?>
                <input type="hidden" name="category" value="<?php echo $post["category_id"]?>">
				<button class="btn btn-secondary" type="submit">Edit</button>
			</form>
    
  <!-- Show report button if it is other user post -->
  <?php elseif($this->session->userdata("user_id") != $post["user_id"]) :?>
		
    <!-- Report button for posts -->
    <a href="#" id="report_button"  class="btn btn-danger" name="thread" value= "<?php echo $post["id"]?>">Report</a>
    
    
	<?php endif;?>
  <!-- Modal for report action -->
    <div class="modal fade" id="exampleModal"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" >
        <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Report</h5>
        </div>

        <!-- Modal Body -->
        <div class="modal-body">
          <div class="statusMsg"></div>
          <form role="form" id="report_form">
            <div class="form-group">
            <input type="hidden" id="content_id" name="id" value="">
              <input type="hidden" id="report_type" name="report_type" value="">
              <label for="message-text" class="col-form-label">Reason:</label>
              <textarea name = "reason" class="form-control" id="message-text"></textarea>
            </div>
          </form>
        </div>

        <!-- Modal Footer -->
        <div class="modal-footer">
        <!--  <button type="button" id="report_close" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
          <a href="#" class="btn btn-secondary" id="report_close">Close</a>
          <a href="#" class="btn btn-primary" id="userSubmit" value="<?php echo $post["id"];?>">Submit</a>
          </form>
        </div>
      </div>
    </div>
  </div>

	<?php echo form_open("posts/reaction/".$post["id"]);?>
		<input type="hidden" name="vote" value="1">
		<input type="hidden" name="react_id" value="<?php echo $post["react_id"];?>">
		<button class="btn btn-outline-primary bg-light text-primary" name="submit" type="submit" value="up_react">Upvote</button>
    </form>
	<p><?php echo $post["upvote"] ;?></p>
		<?php echo form_open("posts/reaction/".$post["id"]);?>
		    <input type="hidden" name="vote" value="1">
		    <input type="hidden" name="react_id" value="<?php echo $post["react_id"];?>">
			<button class="btn btn-outline-primary bg-light text-primary" name="submit" type="submit" value="down_react">Downvote</button>
		</form>
	<p><?php echo $post["downvote"];?></p>
	<!-- button delete -->
	<hr>
	<h3>Comments : </h3>
		
	<div id="comments">
		   
	</div>  

 	<?php echo validation_errors();?>
 	<form action="" method="POST" id="create_form"> 
		<input type="hidden" id="create_post_id" value="<?php echo $post["id"];?>">
		<div class="form-group">
			  <label>Comment :</label>
			  <textarea  class="form-control" id="create_comment"></textarea>
		</div>
		<button type="submit" class="btn btn-primary" id="create">Comment</button>
	</form>
	</div>
	<br>
	
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script>

    // ginagawa nito:
    // 1. tiga show ng modal  at inistore yung id don sa form
    // 2. gumawa din ako ng function na report_post_info para makolekta ko yung nireport na post
    $(document).on("click","#report_button",function(e){
        e.preventDefault();
        var content_id = $(this).attr("value"); // Get the ID of post/discussion on button
        var type = $(this).attr("name"); // Get the ID of post/discussion on button
        
        if(content_id == ""){
          alert("Edit id is required");
        }else{
          
          $.ajax({
            url : "<?php echo base_url()?>reports/check_post",
            type : "post",
            data : {
              content_id : content_id,
              type:type
            },
            success : function(data){
              let result = data.replace(/<!--  -->/g, "");
              data = JSON.parse(result);

              // Action if id is valid
              if(data.response == "success"){
                // Adjust value of modal if post or comment
         
                if(type == 'discussion'){ 
                  $(".modal-body #content_id").val(content_id);
                  $(".modal-body #report_type").val("discussion");
                  $('#exampleModalLabel').text('Report comment');
                
                }
                else{
                  $(".modal-body #content_id").val(content_id);
                  $(".modal-body #report_type").val("thread");
                  $('#exampleModalLabel').text('Report post');
                }
               
                // Show modal
                $("#exampleModal").modal("show");
                console.log (content_id);
              }

              // Show error message
              else{
                
                  Command: toastr["error"](data.message)
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
            }

          });
        }
    })

    // close button para lang mawala yung report log 
    $(document).on("click","#report_close",function(e){
      e.preventDefault();
       $("#exampleModal").modal("hide");
       // nireset ko para di magretain yung previous na report
       $("#report_form")[0].reset();
    });

    // submit mode
    $(document).on("click","#userSubmit",function(e){
      e.preventDefault();
      content_id = $("#content_id").val();
      report_type = $("#report_type").val();
      reason = $("#message-text").val();
      // check kung may laman yung post_id ,type and reason
      if(content_id == "" || report_type == "" || reason == ""){
        alert("Please Fill all the required form");
      }
      else{
        $.ajax({
            url : "<?php echo base_url()?>reports/submit_reports",
            type : "post",
            data : {
              content_id : content_id,
              report_type: report_type,
              reason: reason
            },
            success : function(data){
              let result = data.replace(/<!--  -->/g, "");
              data = JSON.parse(result);
              if(data.response == "success"){
                 $("#exampleModal").modal("hide");
                  Command: toastr["success"](data.message)
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
              else{
                  Command: toastr["error"](data.message)
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
            }

          });
      }
      
     $("#report_form")[0].reset();
    })



    function fetch(){
        $.ajax({
        url : "<?php echo base_url();?>comments/fetch",
        type : "post",
        data :{
            post_id : <?php echo $post["id"];?>
        },
        success : function(data){
            let result = data.replace(/<!--  -->/g, "");
            data = JSON.parse(result);
            var commentbody = "";
            data.forEach(element => {

              if ("<?php echo $reported_id?>" == element["comment_id"]){
                console.log('ew')
                commentbody += "<div class='card bg-danger'>";
              }
              else {
                console.log('hi')
                commentbody += "<div class='card bg-primary'>";
              }

              commentbody += `<div class='card-body text-white' id='edit_container${element["comment_id"]}'>`;
              commentbody += `<h5 id="comment_owner">${element["content"]}[by <strong>${element["username"]}</strong>]</h5>`;
              if("<?php echo $this->session->userdata("user_id");?>" == element["user_id"] || Boolean(<?php echo $this->session->userdata("admin");?>) == true){
                commentbody += `<a href="#" id = "del" name="delete_edit" value="${element['comment_id']}" class="btn btn-outline-primary bg-light text-primary">Delete</a>`;  
                commentbody += `<a href="#" id = "edit" name="delete_edit" value="${element['comment_id']}" class="btn btn-outline-primary bg-light text-primary">Edit</a>`;
                commentbody+= `
                <div style="display:none;" id="textarea_container">
                <h4>Edit Comment</h4>
                  <form action="" method="POST" id="edit_form">
                  <input type="hidden" id="edit_id" value="">
                  <div class="input-group">
                      <textarea id="edit_textarea${element['comment_id']}" name="edit_comment" class="form-control" aria-label="With textarea" required></textarea>
                    </div>
                    <br>
                    <button class="btn btn-danger" id="back_comment">Back</button>
                    <button class="btn btn-success" id="update_comment">Update</button>
                </form>
                </div>`;
                }
                
              else if(<?php echo $this->session->userdata("user_id");?> != element["user_id"]){
                   commentbody += `<a href="#" id="report_button" class="btn btn-danger" name="discussion"  value="${element['comment_id']}">Report</a>`;  
                  
                }
                  commentbody += `<div class="mt-4"> 
                         <a href="#" id="upvote_comment" name="upvote_downvote" value="${element["comment_id"]}" class="btn btn-success">Upvote</a>`;
                  commentbody += `<p name="upvote_downvote">${element["upvote"]}</p>`;
                  commentbody += `<a href="#" name="upvote_downvote" id="downvote_comment" value="${element["comment_id"]}" class="btn btn-success">Downvote</a>`;
                  commentbody += ` <p name="upvote_downvote">${element["downvote"]}</p></div> `;
                  commentbody += '</div>';
                  commentbody += '</div>';
                  commentbody += '<br>';

            });
            
            
            $("#comments").html(commentbody);
          }
          });
        }

        // Function for create comment
    fetch();
      $(document).on("click","#create",function(e){
        e.preventDefault();
        var post_id = $("#create_post_id").attr("value");
        var comment = $("#create_comment").val();
            $.ajax({
                url : "<?php echo base_url();?>comments/create",
                type : "post",
                data : {
                    post_id : post_id,
                    comment : comment
                },
                success : function(data){
                    fetch();
                    let result = data.replace(/<!--  -->/g, "");
                    data = JSON.parse(result);
                    if(data.response == "success"){
                        Command: toastr["success"](data.message)
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
                    else{
                        Command: toastr["error"](data.message)
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
                },
                error: function (request, error) {
                    alert("AJAX Call Error: " + error);
                }
            });
    
        $("#create_form")[0].reset();	// Clear input area
    });

      // Function for delete button on comment
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
                console.log(data);

                // Action success dialog
                if(data.response == "success"){
                  swalWithBootstrapButtons.fire(
                  'Deleted!',
                  'Your file has been deleted.',
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
              'Your imaginary file is safe :)',
              'error'
            )
          }
        })
      }
    });
     
    // Funtion fot edit button in comment
     $(document).on("click","#edit",function(e){
      e.preventDefault();
      
      var comment_id = $(this).attr("value");
      if(comment_id == ""){
          alert("Edit id is required");
        }else{
          $.ajax({
            url : "<?php echo base_url()?>comments/edit",
            type : "post",
            data : {
              comment_id : comment_id
            },
            success : function(data){
               let result = data.replace(/<!--  -->/g, "");
               data = JSON.parse(result);
               
              if(data.response == "success"){
                $("#edit_container"+comment_id).children("#textarea_container").css("display","block");
                $("a[name ='delete_edit']").hide();
                $("#edit_container"+comment_id).children("#comment_owner").hide();
                $("#edit_container"+comment_id).children("#del").hide();
                $("a[name='upvote_downvote']").hide();
                $("p[name='upvote_downvote']").hide();
                $("button[name='report']").hide();
                $("#edit_id").val(data.message.comment_id);
                $("#edit_textarea"+comment_id).text(data.message.content);         
              }
              else{
                  Command: toastr["error"](data.message)
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
            }

          });
        }
     });
     $(document).on("click","#update_comment",function(e){
        e.preventDefault();
        var edit_id = $("#edit_id").val();
        var edit_comment = $("#edit_textarea"+edit_id).val();
       
        if(edit_id == ""){
          alert("Comment is not detected");
        }else{
          $.ajax({
            url : "<?php echo base_url();?>comments/update",
            type : "post",
            data : {
              edit_id : edit_id,
              edit_comment : edit_comment
            },
            success : function(data){
            fetch();
            let result = data.replace(/<!--  -->/g, "");
               data = JSON.parse(result);
            if(data.response =="success"){
               $("#edit_container"+edit_id).children("#textarea_container").css("display","none");
                $("a[name ='delete_edit']").show();
                $("#edit_container"+edit_id).children("#comment_owner").show();
                $("#edit_container"+edit_id).children("#del").show();
                $("a[name='upvote_downvote']").show();
                $("p[name='upvote_downvote']").show();
                $("button[name='report']").show();
              Command: toastr["success"](data.message)
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
            else{
              $("#edit_container"+edit_id).children("#textarea_container").css("display","none");
                $("a[name ='delete_edit']").show();
                $("#edit_container"+edit_id).children("#comment_owner").show();
                $("#edit_container"+edit_id).children("#del").show();
                $("a[name='upvote_downvote']").show();
                $("p[name='upvote_downvote']").show();
                $("button[name='report']").show();
              Command: toastr["error"](data.message)
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
            }
          });
        }
      });
     $(document).on("click","#back_comment",function(e){
        e.preventDefault();
           edit_id =  $("#edit_id").val();
              $.ajax({
                url : "<?php echo base_url()?>comments/cancel_update",
                type : "post",
                success : function(data){
                  fetch();
                   let result = data.replace(/<!--  -->/g, "");
                 data = JSON.parse(result);
                  if(data.response == "success"){
      

                $("#edit_container"+edit_id).children("#textarea_container").css("display","none");
                $("a[name ='delete_edit']").show();
                $("#edit_container"+edit_id).children("#comment_owner").show();
                $("#edit_container"+edit_id).children("#del").show();
                $("a[name='upvote_downvote']").show();
                $("p[name='upvote_downvote']").show();
                $("button[name='report']").show();
                  }
                }
              });
     })

     $(document).on("click","#upvote_comment",function(e){
        e.preventDefault();
        var comment_id = $(this).attr("value");
        $.ajax({
            url : "<?php echo base_url()?>comments/reaction",
            type : "post",
            data : {
              comment_id : comment_id,
              type_of_vote : "up_react"
            },
            success : function(data){
               fetch();
            }
        })

     })
     $(document).on("click","#downvote_comment",function(e){
        e.preventDefault();
        var comment_id = $(this).attr("value");
        $.ajax({
            url : "<?php echo base_url()?>comments/reaction",
            type : "post",
            data : {
              comment_id : comment_id,
              type_of_vote : "down_react"
            },
            success : function(data){
               fetch();
            }
        })

     })
    </script>