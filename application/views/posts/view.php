<div style="width: 100vw; height: 100vh;"class="container-fluid">
        <div class="row">
            <div class="col-lg-3">
                <div class="viewthreadpic">
                    <?php if(!empty($post["user_profile_photo"])){ ?>
                        <img  src="<?php echo base_url().$post["user_profile_photo"];?>" alt="Profile Pic">
                    <?php }
                    else{?>
                        <img src="<?php echo base_url();?>assets/image/user.png" alt="Profile Pic">
                    <?php } ?>

                </div>
                <div class="threadcreatorname">
                    <h3><?php echo ucfirst($post["username"]);?></h3>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="threadspost">
                    <div class="row">
                        <div class="col-lg-10">
                            <h1><?php echo $post["title"];?></h1>
                            <?php if(isset($post["post_image"]) && !empty($post["post_image"])):?>
      <img src="<?php echo base_url().$post["post_image"];?>" alt="" width="300"> 
      <?php endif;?>
                        </div>
                        <div class="col-lg-1">
                          <?php if($this->session->userdata("user_id") == $post["user_id"] || $this->session->userdata("admin") == true ) :?>
                            <div class="dropdown">
                                <button type="button" class="profilebutton" id="buttonmenu" data-bs-toggle="dropdown">
                                        <img src="<?php echo base_url();?>assets/image/menudot.png" alt="menu">
                                </button>
                                <ul class="dropdown-menu">
                                    <li class="dropdown-item">

                                      <?php echo form_open("posts/edit/".$post["id"]);?>
                                        <input type="submit" id="editpost">
                                            <label for="editpost">Edit</label>  
                                      </form>
                                    </li>
                                    <li class="dropdown-item"> 
                                      <?php echo form_open("posts/delete/".$post["id"]);?>
                                        <input type="submit" id="remove">
                                            <label for="remove">Remove</label>  
                                      </form>
                                    </li>
                                </ul>
                            </div>

                          <?php elseif($this->session->userdata("user_id") != $post["user_id"]) :?>
                            <div class="dropdown">
                                <button type="button" class="profilebutton" id="buttonmenu" data-bs-toggle="dropdown">
                                        <img src="<?php echo base_url();?>assets/image/menudot.png" alt="menu">
                                </button>
                                <ul class="dropdown-menu">
                                    <li class="dropdown-item">
                                            <a href="#" id="report_button" name="thread" value= "<?php echo $post["id"]?>">Report</a>
                                    </li>
                                </ul>
                            </div>
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


                        </div>
                    </div>
                    <div>
                        <img src="" alt="">
                        <h3><?php echo $post["body"];?></h3>
                    </div>
                    <h6>Posted on: <?php echo $post["created_at"];?></h6>    
                    
                    <div class="threadmore">
                        <div class="reaction">
                            <div class="upbutton">
                              <?php echo form_open("posts/reaction/".$post["id"]);?>
                              <button name="submit" type="submit" value="up_react">
                                <i class="fa fa-thumbs-up fa-lg"></i>
                              <input type="hidden" name="react_id" value="<?php echo $post["react_id"];?>">
                                <input type="numberlike" value="<?php echo $post["upvote"] ;?>">
                              </button>
                            </form>
                            </div>

                            <div class="downbutton">
                              <?php echo form_open("posts/reaction/".$post["id"]);?>
                                <button name="submit" type="submit" value="down_react">
                                    <i class="fa fa-thumbs-down fa-lg"></i>
                                    <input type="hidden" name="react_id" value="<?php echo $post["react_id"];?>">
                                    <input type="numberlike" value="<?php echo $post["downvote"];?>">
                                </button>
                              </form>
                            </div>
                        </div> 
                        <div class="totalcomments">
                            <img src="<?php echo base_url();?>assets/image/comment.png" alt="">
                            <input type="numberlike" id="input1" value="0" name="">

                        </div>
                        <div class="whatcategory">
                            <h4>Categories: </h4>
                            <a href=""><?php echo $post["name"];?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr class="between">

        <div class="row">
            <div class="col-lg-3">
                <div class="randomthreadtitle">
                    <div class="top">
                        <h2>Random Threads</h2>
                    </div>
                    <div class="categories">
                        <a href="#"><p>Anime </p></a>
                    </div>
                </div>
        
            </div>
            <div class="col-lg-9">
                <div class="discussion">
                    <h3>Discussion</h3>
                    
                    <div id="comments"></div> 
                                        
                    <div class="comments">
                        <div class="row">
                            <div class="col-lg-2">
                                <div class="circleimage">
                                <?php if(!empty($post["user_profile_photo"])){ ?>
                                    <img  class="userprofile" src="<?php echo base_url().$post["user_profile_photo"];?>" alt="Profile Pic">
                                <?php }
                                else{?>
                                    <img class="userprofile" src="<?php echo base_url();?>assets/image/user.png" alt="Profile Pic">
                                <?php } ?>    
                                </div>         
                            </div>
                            <div class="col-lg-9">
                                <div class="commentuser">
                                    <form action="" method="POST" id="create_form"> 
                                        <input type="hidden" id="create_post_id" value="<?php echo $post["id"];?>" >
                                        <textarea class="text" type="comment" id="create_comment" placeholder="Write a Comment"></textarea>
                                        <button type="submit" id="create">Comment</button>
                                    </form>
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
  <script>
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

        function showcomment(){
                $("#containeredit"+comment_id).children("#textarea_container").css("display","none");
                $("div[name ='delete_edit']").show();
                $("#edit_container"+comment_id).children("#comment_owner").show();
                $("#edit_container1"+comment_id).children("#comment_reaction").show();
        }

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
                  toastr_option();
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
                   toastr_option();

              }
              else{
                  Command: toastr["error"](data.message)
                  toastr_option();
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
                commentbody+= `
                <div class="comments">`;
              }


              commentbody += `<div class="circleimage">
                            <img src="<?php echo base_url();?>assets/image/user.png" class="userprofile">                                
                            </div>
                            <div class="row"> 
                            <div class="col-lg-3">    
                                <a href=""><h2>${element["username"]}</h2></a>
                            </div>  
                            <div class="col-lg-9">    
                                <div class="commentdropdown">` ;
              if("<?php echo $this->session->userdata("user_id");?>" == element["user_id"] || Boolean(<?php echo $this->session->userdata("admin");?>) == true){
                commentbody += `<div class="dropdown" name="delete_edit">
                                        <button type="button" class="profilebutton" id="buttonmenu" data-bs-toggle="dropdown"> 
                                                <img src="<?php echo base_url();?>assets/image/menudot.png" alt="menu">
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li class="dropdown-item">
                                                <input type="submit" id="edit" >
                                                <label for="edit" id="edit" name="delete_edit" value="${element['comment_id']}">Edit</label>
                                            </li>
                                            <li class="dropdown-item"> 
                                                <input type="submit" id="remove">
                                                    <label for="remove"  id = "del" name="delete_edit" value="${element['comment_id']}">Remove</label>  
                                            </li>
                                        </ul>
                                    </div>`;
                }
                
              else if(<?php echo $this->session->userdata("user_id");?> != element["user_id"]){
                    commentbody += `<div class="dropdown">
                                <button type="button" class="profilebutton" id="buttonmenu" data-bs-toggle="dropdown">
                                        <img src="<?php echo base_url();?>assets/image/menudot.png" alt="menu">
                                </button>
                                <ul class="dropdown-menu">
                                    <li class="dropdown-item">
                                            <a href="#" id="report_button" name="discussion"  value="${element['comment_id']}">Report</a>
                                    </li>
                                </ul>
                            </div>`;}

            commentbody += `   </div>                              
                            </div>  
                        </div> `
                
                commentbody += `<div id='containeredit${element["comment_id"]}'>`;  

                commentbody+= `
                 <div class="comment_edit" style="display:none;" id="textarea_container">
                    <form action="" method="POST" id="edit_form">
                    <input type="hidden" id="edit_id" value="">
                            <textarea  class="text" id="edit_textarea${element['comment_id']}" name="edit_comment"></textarea>
                            <button class="button1" id="update_comment">Update</button>
                            <button id="back_comment">Cancel</button>
                    </form>
                </div> 
                </div>`;

            commentbody += `<div class="commentuser" id='edit_container${element["comment_id"]}'>`;
            commentbody += `<p id="comment_owner">${element["content"]}</p>                     
                            </div> `

            commentbody += `<div id='edit_container1${element["comment_id"]}'>`;
            commentbody +=`    
                        <div class="threadmore" id="comment_reaction">
                            <div class="reaction">
                                    <button id="upvote_comment" name="upvote_downvote" value="${element["comment_id"]}">
                                        <i class="fa fa-thumbs-up fa-lg"></i>                               
                                        <input type="numberlike" id="input1" value="${element["upvote"]}" name="">
                                    </button>
    
                                    <button id="downvote_comment" name="upvote_downvote" value="${element["comment_id"]}" >
                                        <i class="fa fa-thumbs-down fa-lg" ></i>
                                        <input type="numberlike" id="input1" value="${element["downvote"]}" name="">
                                    </button>
                            </div> 
                            <div class="totalcomments">
                                <img src="<?php echo base_url();?>assets/image/comment.png" alt="">
                                <input type="numberlike" id="input1" value="0" name="">
    
                            </div>
                            <div class="whatcategory">
                                <h4>Commented on: </h4>
                            </div>
                        </div>
                    </div>
                    </div>`; });
            
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
                        toastr_option();
                    }
                    else{
                        Command: toastr["error"](data.message)
                        toastr_option();
                    }
                },
                error: function (request, error) {
                    alert("AJAX Call Error: " + error);
                }
            });
    
        $("#create_form")[0].reset(); // Clear input area
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
                $("#containeredit"+comment_id).children("#textarea_container").css("display","block");
                $("div[name ='delete_edit']").hide();
                $("#edit_container"+comment_id).children("#comment_owner").hide();
                $("#edit_container1"+comment_id).children("#comment_reaction").hide();
                $("#edit_id").val(data.message.comment_id);
                $("#edit_textarea"+comment_id).text(data.message.content);         
              }
              else{
                  Command: toastr["error"](data.message)
                  toastr_option();
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
              showcomment();
              Command: toastr["success"](data.message)
                toastr_option();
            }
            else{
              showcomment();
              Command: toastr["error"](data.message)
                  toastr_option();
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
                    showcomment();
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
