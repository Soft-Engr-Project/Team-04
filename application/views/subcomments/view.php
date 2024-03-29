<div class="subcomment">
      <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-m-3 col-sm-3">
                <div class="subcommentpost">
                    <div class="viewsubpic">
                      <?php 
                        if(!empty($post["user_profile_photo"]))
                        { 
                      ?>
                          <img  src="<?php echo base_url().$post["user_profile_photo"];?>" alt="Profile Pic">
                      <?php 
                      }
                      else{?>
                          <img src="<?php echo base_url();?>assets/image/user.png" alt="Profile Pic">
                      <?php } ?>
                    </div>
                     <div class="viewcreatorname">
                        <h3><a href="<?php echo base_url()."profiles/view/".$post["user_id"];?>"><?php echo ucfirst($post["username"]);?></a></h3>                
                    </div>
                     <h1><a href="#"><?php echo $post["title"];?></a></h1>
                     <h5><?php echo $post["body"];?></h5>
                     <h6>Posted on: <?php echo $post["post_created_at"];?></h6>
                </div>

            </div>
            <div class="col-lg-9 col-m-9 col-sm-9">
                <div class="discussion">
                    <h3 class="discusheader">Comment</h3>
                    <div class="comments">
                        <div class="circleimage">
                        <img src="<?php echo base_url();?>assets/image/user.png" class="userprofile" alt="Profile Photo" >
                        </div>
                        <div class="row"> 
                            <div class="col-lg-3">    
                                <a href=""><h2><?php echo $comments["username"]?></h2></a>
                            </div>  
                            <div class="col-lg-9">    
                                <div class="commentdropdown">
                                <?php 
                                if($this->session->userdata("user_id") != $comments["user_id"]) { ?>
                                    <div class="dropdown">
                                      <button type="button" class="profilebutton" id="buttonmenu" data-bs-toggle="dropdown">
                                          <img src="<?php echo base_url();?>assets/image/menudot.png" alt="menu">
                                      </button>
                                      <ul class="dropdown-menu">
                                        <li class="dropdown-item">
                                                <a href="#" id="report_button" name="discussion"  value="<?php echo $comments['comment_id']?>">Report</a>
                                        </li>
                                      </ul>
                                    </div>
                                <?php } ?>  
                                </div>                              
                            </div>  
                          </div>

                          <div id='containeredit<?php echo $comments["comment_id"]?>'>
                            <div class="comment_edit" style="display:none;" id="textarea_container">
                              <form action="" method="POST" id="edit_form">
                              <input type="hidden" id="edit_id" value="">
                                      <textarea  class="text" id="edit_textarea<?php echo $comments['comment_id']?>" name="edit_comment"></textarea>
                                      <button class="button1" id="update_comment">Update</button>
                                      <button id="back_comment">Cancel</button>
                              </form>
                            </div> 
                          </div>

                        <div class="commentuser" id='edit_container${element["comment_id"]}'>
                          <p id="comment_owner"><?php echo $comments["content"]?></p>                     
                        </div>
                        <div id='edit_container1$<?php echo $comments["comment_id"]?>'>
                          <div class="threadmore" id="discussion_reaction">
                          </div>
                        </div>
                    </div> 
                    <h3 class="discusheader">Replies</h3>
                    <div id="subcomments_container">

                    </div> 
                    
                    <div class="comments">
                        <div class="row">
                            <div class="col-lg-2">
                                <div class="circleimage">
                                  <?php if(!empty($user["user_profile_photo"])){ ?>
                                      <img  class="userprofile" src="<?php echo base_url().$user["user_profile_photo"];?>" alt="Profile Pic">
                                  <?php }
                                  else{?>
                                      <img class="userprofile" src="<?php echo base_url();?>assets/image/user.png" alt="Profile Pic">
                                  <?php } ?>
                                </div>
                            </div>
                            <div class="col-lg-9">
                            
                                <div class="commentuser">
                                  <form action="" method="POST" id="create_form"> 
                                          <input type="hidden" id="create_post_id"   name="comment_id" value="<?php echo $commentId;?>" >
                                          <textarea class="text" type="comment" id="create_comment" name="reply" placeholder="Repy to this Comment"></textarea>
                                          <button type="submit" id="create">Reply</button>
                                  </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>        
    </div>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha384-oqVuAfXRKap7fdgcCY5uykM6+R9GqQ8K/uxy9rx7HNQlGYl1kPzQho1wx4JwY8wC"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11" integrity="sha384-oqVuAfXRKap7fdgcCY5uykM6+R9GqQ8K/uxy9rx7HNQlGYl1kPzQho1wx4JwY8wC"></script>
    <script type="text/javascript">
      const rgbaColor = <?php echo json_encode($_SESSION["bgColor"]); ?>; 
      document.querySelector('body').style.background = rgbaColor;
    </script>
    <script>
         function showcomment(editSubcommentId) {
                $("#containeredit"+editSubcommentId).children("#textarea_container").css("display","none");
                $(`div[name ='delete_edit']`).show();
                $("#edit_container"+editSubcommentId).children("#comment_owner").show();
                $("#edit_container1"+editSubcommentId).children("#comment_reaction").show();
        }
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
        url : "<?php echo base_url();?>subcomments/fetch",
        type : "post",
        data :{
            comments : <?php echo $commentId;?>
        },
        success : function(data){
             let result = data.replace(/<!--  -->/g, "");
                    data = JSON.parse(result);
                    subcommentbody = "";
                    data.forEach(element => {
                        if ("<?php echo $reported_id?>" == element["subcomment_id"]){
                            
                            subcommentbody += "<div class='card bg-danger'>";
                        }
                        else {
                            subcommentbody+= `
                            <div class="comments">`;
                        }
                        subcommentbody += `<div class="circleimage">
                            <img src="<?php echo base_url();?>assets/image/user.png" class="userprofile">                                
                            </div>
                            <div class="row"> 
                            <div class="col-lg-3"> 
                            
                                <a href="<?php echo base_url()?>profiles/view/${element["user_id"]}"><h2>${element["username"]}</h2></a>
                            </div>  
                            <div class="col-lg-9">    
                                <div class="commentdropdown">` ;
                 if("<?php echo $this->session->userdata("user_id");?>" == element["user_id"] || Boolean(<?php echo $this->session->userdata("admin");?>) == true){
                    subcommentbody += `<div class="dropdown" name="delete_edit">
                                        <button type="button" class="profilebutton" id="buttonmenu" data-bs-toggle="dropdown"> 
                                                <img src="<?php echo base_url();?>assets/image/menudot.png" alt="menu">
                                        </button>
                                        <ul class="dropdown-menu">
                                        <label for="edit" id="edit_sub" name="delete_edit" value="${element['subcomment_id']}">
                                              <li class="dropdown-item">
                                                  <input type="submit" id="edit" >
                                                  Edit
                                              </li>
                                        </label>
                                            <label for="remove"  id = "del_sub" name="delete_edit" value="${element['subcomment_id']}">
                                              <li class="dropdown-item"> 
                                                  <input type="submit" id="remove">
                                                    Remove
                                              </li>
                                            </label>  
                                        </ul>
                                    </div>`;
                } else if(<?php echo $this->session->userdata("user_id");?> != element["user_id"]){
                    subcommentbody += `<div class="dropdown">
                                <button type="button" class="profilebutton" id="buttonmenu" data-bs-toggle="dropdown">
                                        <img src="<?php echo base_url();?>assets/image/menudot.png" alt="menu">
                                </button>
                                <ul class="dropdown-menu">
                                    <li class="dropdown-item">
                                            <a href="#" id="report_button" name="reply"  value="${element['subcomment_id']}">Report</a>
                                    </li>
                                </ul>
                            </div>`;
                    }
                    subcommentbody += `   </div>                              
                            </div>  
                        </div> `
                
                    subcommentbody += `<div id='containeredit${element["subcomment_id"]}'>`;  

                    subcommentbody+= `
                 <div class="comment_edit" style="display:none;" id="textarea_container">
                    <form action="" method="POST" id="edit_form">
                            <input type="hidden" id="edit_id" value="">
                            <textarea  class="text" id="edit_textarea${element['subcomment_id']}" name="edit_reply"></textarea>
                            <button class="button1" type ="submit" id="update_subcomment">Update</button>
                            <button id="back_comment">Cancel</button>
                    </form>
                </div> 
                </div>`;
                subcommentbody += `<div class="commentuser" id='edit_container${element["subcomment_id"]}'>`;
                subcommentbody += `<p id="comment_owner">${element["reply"]}</p>                     
                            </div> `

                subcommentbody += `<div id='edit_container1${element["subcomment_id"]}'>`;
                subcommentbody +=`    
                        <div class="threadmore" id="comment_reaction">
                            <div class="reaction">
                                    <button id="upvote_subcomment" name="upvote_downvote" value="${element["subcomment_id"]}">
                                        <em class="fa fa-thumbs-up fa-lg"></em>                               
                                        <input type="numberlike" id="input1" value="${element["sub_upvote"]}" name="">
                                    </button>
    
                                    <button id="downvote_subcomment" name="upvote_downvote" value="${element["subcomment_id"]}" >
                                        <em class="fa fa-thumbs-down fa-lg" ></em>
                                        <input type="numberlike" id="input1" value="${element["sub_downvote"]}" name="">
                                    </button>
                            </div> 
                            <div class="whatcategory">
                                <h4>Commented on: ${element["sub_create_at"]}</h4>
                            </div>
                        </div>
                    </div>
                    </div>`;
                
                    });
                    $("#subcomments_container").html(subcommentbody);         
        }
    });
    }
    fetch();
    $(document).on("click","#create",function(e){
        e.preventDefault();
        var commentId = $("#create_post_id").attr("value");
        var  reply = $("#create_comment").val();
            
            $.ajax({
                url : "<?php echo base_url();?>subcomments/create",
                type : "post",
                data : {
                    commentId : commentId,
                    reply : reply
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

    // Funtion fot edit button in comment
    $(document).on("click","#edit_sub",function(e){
      e.preventDefault();
      
      var subcomment_id = $(this).attr("value");
      
      if(subcomment_id == ""){
          alert("Edit id is required");
        }else{
          $.ajax({
            url : "<?php echo base_url()?>subcomments/edit",
            type : "post",
            data : {
                subcomment_id : subcomment_id
            },
            success : function(data){
               let result = data.replace(/<!--  -->/g, "");
               data = JSON.parse(result);
               
              if(data.response == "success"){
                $("#containeredit"+subcomment_id).children("#textarea_container").css("display","block");
                $("div[name ='delete_edit']").hide();
                $("#edit_container"+subcomment_id).children("#comment_owner").hide();
                $("#edit_container1"+subcomment_id).children("#comment_reaction").hide();
                $("#edit_id").val(data.message.subcomment_id);
                $("#edit_textarea"+subcomment_id).text(data.message.reply);         
              }
              else{
                  Command: toastr["error"](data.message)
                  toastr_option();
              }
            }

          });
        }
     });
    
     $(document).on("click","#update_subcomment",function(e){
        e.preventDefault();
        var editSubcommentId = $("#edit_id").val();
        
        var editSubcommentReply = $("#edit_textarea"+editSubcommentId).val();
        
        if(editSubcommentId == "" ){
          alert("Comment is not detected");
        }else{
          $.ajax({
            url : "<?php echo base_url();?>subcomments/update",
            type : "post",
            data : {
                editSubcommentId : editSubcommentId,
                editSubcommentReply : editSubcommentReply
            },
            success : function(data){
            fetch();
            let result = data.replace(/<!--  -->/g, "");
               data = JSON.parse(result);
               
            if(data.response =="success"){
              showcomment(editSubcommentId);
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

        // Function for create comment
    
    $(document).on("click","#upvote_subcomment",function(e){
        e.preventDefault();
        var subcommentId = $(this).attr("value");
        
        $.ajax({
            url : "<?php echo base_url()?>subcomments/reaction",
            type : "post",
            data : {
              subcommentId : subcommentId,
              type_of_vote : "up_react"
            },
            success : function(data){
              
               fetch();
            }
        })
     })
     $(document).on("click","#downvote_subcomment",function(e){
        e.preventDefault();
        var subcommentId = $(this).attr("value");
        $.ajax({
            url : "<?php echo base_url()?>subcomments/reaction",
            type : "post",
            data : {
              subcommentId : subcommentId,
              type_of_vote : "down_react"
            },
            success : function(data){
               fetch();
            }
        })

     })
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
         
                if(type == 'discussion') { 
                  $(".modal-body #content_id").val(content_id);
                  $(".modal-body #report_type").val("discussion");
                  $('#exampleModalLabel').text('Report comment');
                }
                else if(type == "thread") {
                  $(".modal-body #content_id").val(content_id);
                  $(".modal-body #report_type").val("thread");
                  $('#exampleModalLabel').text('Report post');
                }
                else{
                  $(".modal-body #content_id").val(content_id);
                  $(".modal-body #report_type").val("reply");
                  $('#exampleModalLabel').text('Report comment');
                }
               
                // Show modal
                $("#exampleModal").modal("show");
               
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
    });
    comment_fetch();
    //  para sa comment reactiong
    function comment_fetch(){
        $.ajax({
        url : "<?php echo base_url();?>subcomments/fetchSpecificComment",
        type : "post",
        data :{
            comments : <?php echo $commentId;?>
        },
        success:function(data){
            let result = data.replace(/<!--  -->/g, "");
            data = JSON.parse(result);
            
            var post = "";
            post += `

                          <div class="reaction">
                            <button name="submit" id="upvote_post" value="${data["comment_id"]}">
                                <em class="fa fa-thumbs-up fa-lg"></em>
                                <input type="numberlike" value="${data["upvote"]}">
                            </button>

                            <button name="submit" id="downvote_post" value="${data["comment_id"]}">
                              <em class="fa fa-thumbs-down fa-lg"></em>
                              <input type="numberlike" value="${data["downvote"]}">
                            </button>
                          </div> 
                            <div class="totalcomments">
                              <img src="<?php echo base_url();?>assets/image/comment.png" alt="">
                              <input type="numberlike" id="input1" value="${data["subcomment_count"]}" name="">
                            </div>
                            <div class="whatcategory">
                                <h4>Commented on: 2022-01-01 14:42:47 </h4>
                            </div>
            `;
            $("#discussion_reaction").html(post);
           
        }
      });
    }
    $(document).on("click","#upvote_post",function(e){
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
              comment_fetch();
            },
             error: function (request, error) {
                    alert("AJAX Call Error: " + error);
                }
        })
     })
     $(document).on("click","#downvote_post",function(e){
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
              
              comment_fetch();
            },
            error: function (request, error) {
                    alert("AJAX Call Error: " + error);
                }
        })

     })

    </script>