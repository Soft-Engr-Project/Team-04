<div class="container">
<br>
<br>
<br>
<br>
<h3><?php echo $post["title"];?></h3>
	<!-- image -->
	<?php if(isset($post["post_image"])):?>
			<img src="<?php echo base_url();?>assets/images/posts/<?php echo $post["post_image"];?>" alt="" width="300">
	<?php endif;?>
	<!-- who post and when  and what category-->
	<small class="post-date">Posted on : <?php echo $post["post_created_at"];?> in <?php echo $post["name"];?></small>
	<small>Created by : <?php echo ucfirst($post["username"]);?></small>
	<!-- body -->
	<h4><?php echo $post["body"];?></h4>
	<?php if($this->session->userdata("user_id") == $post["user_id"]) :?>
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
    <button type="button" name="report" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal" data-type="posts">Report</button>
    
    <!-- Modal for report action -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" >
      <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Report</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body">
        <div class="statusMsg"></div>
        <form role="form">
          <div class="form-group">
            <input type="hidden" id="id" name="id" value="<?php echo $post['id'];?>">	
            <input type="hidden" id="type" name="type" value="posts">
            <label for="message-text" class="col-form-label">Reason:</label>
            <textarea name = "reason" class="form-control" id="message-text"></textarea>
          </div>
        </form>
      </div>

      <!-- Modal Footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="userSubmit" >Submit</button>
        </form>
      </div>
      </div>
    </div>
    </div>
	<?php endif;?>

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

    // Actions on modal show and hidden events
    $(function(){
        $('#exampleModal').on('show.bs.modal', function(e){
    
            var type = $(e.relatedTarget).attr('data-type');
            var userFunc = "userReport('posts');";
            $('#exampleModalLabel').text('Report post');
            if(type == 'discussion'){
                userFunc = "userReport('discussion');";
                var comment_id = $(this).attr("value");
				        $(".modal-body #id").val(comment_id);
                $(".modal-body #type").val('discussion');
                // var rowId = $(e.relatedTarget).attr('rowID');
                // editUser(rowId);
                $('#exampleModalLabel').text('Report comment');
            }
            $('#userSubmit').attr("onclick", userFunc);
        });
        
        // Clear text area after hiding
        $('#exampleModal').on('hidden.bs.modal', function(){
            $('#userSubmit').attr("onclick", "");
            $(this).find('form')[0].reset();
            $(this).find('.statusMsg').html('');
          
        });
    });

    // Send CRUD requests to the server-side script
    function userReport(type){
      
        var userData = '1', frmElement = '';
        if(type == 'posts'){
            frmElement = $("#exampleModal");
            userData = frmElement.find('form').serialize();
        }else if (type == 'discussion'){
            frmElement = $("#exampleModal");
            userData = frmElement.find('form').serialize();
        }else{
            frmElement = $(".row");
            userData = 'id='+id;
        }
        frmElement.find('.statusMsg').html('');
        $.ajax({
            type: 'post',
            url: "<?php echo base_url();?>posts/reports",
            data: userData,
            beforeSend: function(){
              
                frmElement.find('form').css("opacity", "0.5");
            },
            success:function(data){
              $("exampleModal").modal('hide');
              console.log(data);
              let result = data.replace(/<!--  -->/g, "");
                    data = JSON.parse(result);
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
              if(data.status == 1){
                    frmElement.find('form')[0].reset();
                    

                    // COMMENT MUNA, PANG UPDATE KO TO SA BUTTON getUsers();
                }
                frmElement.find('form').css("opacity", "");
                
            },
            error: function () {
              console.log("hello");
            },
        });
    }

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

               commentbody += "<div class='card bg-primary'>";
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
                        
                else if("<?php echo $this->session->userdata("user_id");?>" != element["user_id"]){
                   commentbody += `<button name="report" type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal" data-type="discussion" value="${element['comment_id']}">Report</button>`;  
            
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