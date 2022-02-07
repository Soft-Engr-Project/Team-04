                <div class="col-lg-8">
                    <div class="row">
                        <div class="threads">
                            <h1><?=$title?></h1>
                            <hr>
                        </div>
                        <div id="profilePosting">

                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
 
<script type="text/javascript">

     $(document).on("click","#upvote_post",function(e){
        e.preventDefault();
        var post_id = $(this).val();
    
        $.ajax({
            url : "<?php echo base_url()?>posts/reaction",
            type : "post",
            data : {
              post_id : post_id,
              type_of_vote : "up_react"
            },
            success : function(data){   
                posting();
            }
        });
     });
     $(document).on("click","#downvote_post",function(e){
        e.preventDefault();
        var post_id = $(this).val();
        $.ajax({
            url : "<?php echo base_url()?>posts/reaction",
            type : "post",
            data : {
              post_id : post_id,
              type_of_vote : "down_react"
            },
            success : function(data){   
                posting();
            }
        });

     });
     function posting(){

            $.ajax({
                url : "<?php echo base_url();?>posts/getPostProfile",
                data : {
                   userID : <?php echo $user["user_id"];?>
                },
                type:"POST",
                success:function(data){
                    let result = data.replace(/<!--  -->/g, "");
                    data = JSON.parse(result);
                    let profilePost = "";
                    if(data != "") {
                    data.forEach(post => {
                        profilePost += `
                        <div class="threadscontent">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-2">
                                        <div class="circleimage">
                                        <?php if(!empty($user["user_profile_photo"])){ ?>
                                            <img style="border: 1px solid #000000;" src="<?php echo base_url().$user["user_profile_photo"]?>" class="userprofile" alt="Profile Photo">
                                        <?php }
                                        else{?>
                                            <img style="border: 1px solid #000000;" src="<?php echo base_url();?>assets/image/user.png" alt="Profile Photo" class="userprofile">
                                         <?php } ?>
                                        </div>
                                        <?php if($user["user_id"] == $this->session->userdata("user_id")):?>
                                        <div class="dropdown">
                                            <button type="button" class="profilebutton" id="buttonmenu" data-bs-toggle="dropdown"> 
                                                <img src="<?php echo base_url();?>assets/image/menudot.png" alt="menu">
                                            </button>
                                            <ul class="dropdown-menu">
                                                <label for="edit">
                                                    <li class="dropdown-item">
                                                        <form action="<?php echo base_url()?>posts/edit/${post["id"]}">
                                                            <input type="submit" id="edit">
                                                             Edit
                                                        </form> 
                                                    </li> 
                                                </label>
                                                <label for="remove" >
                                                    <button id="del" class="bg-transparent" value="${post["id"]}" >
                                                    <li class="dropdown-item"> 
                                                        Remove
                                                    </li>
                                                    </button>
                                                </label>  
                                            </ul>
                                        </div>
                                        <?php endif;?> 
                                    </div>
                        `;
                        profilePost +=`
                                     <div class="col-lg-10">
                                        <h2><a href="<?php echo base_url();?>profiles/view/${post["user_id"]}"><?php echo $user["username"]?> </a></h2>
                                        <h4><a href="<?php echo base_url();?>/posts/view/${post["id"]}"> ${post["title"]}</a></h4>
                                        <h6>`;
                                       
                                        if(post["post_image"] != "") {
                                             profilePost +=`<img src="<?php echo base_url();?>${post["post_image"]}" alt="Post image"> </h6>`;
                                            }     
                                        if(post["body"].length > 10) {
                                            post["body"] = post["body"].substring(0,300);
                                            profilePost +=`<h6>${post["body"]}</h6>`;
                                        }else {
                                            profilePost +=`<h6>${post["body"]}</h6>`;
                                        }
                                        profilePost +=`
                                        <h5>Posted on: ${post["post_created_at"]}</h5>
                                        <div class="threadmore">
                                            <div class="profilereaction">
                                                <div class="upbutton" id="like">
                                                    <button id="upvote_post" value="${post["id"]}">
                                                        <em class="fa fa-thumbs-up" style="font-size:24px"></em>                              
                                                        <input type="numberlike" id="input1" value="${post["upvote"]}" name="">
                                                    </button>
                                                </div>
                                                <div class="downbutton" id="dislike" >
                                                    <button id="downvote_post" value="${post["id"]}">
                                                        <em class="fa fa-thumbs-down" style="font-size:24px"></em>
                                                        <input type="numberlike" value="${post["downvote"]}"  name="">
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="totalcomments">
                                                <img src="<?php echo base_url();?>assets/image/comment.png" alt="comment">
                                                <input type="numberlike" value="${post["post_comment_count"]}" name="">
                    
                                            </div>
                                            <div class="whatcategory">
                                                <h4>Categories: </h4>
                                                <a href="">${post["name"]}</a>
                                            </div>
                                        </div> 
                                        </div>                         
                                </div>
                            <hr>
                            </div>
                        </div>
                                        `;
                        

                    }); 
                    } else {
                        profilePost+=`
                       
                            <h3 style="display:flex; justify-Content:center;">No post in this section</h3>
                        `
                    }  
                    $("#profilePosting").html(profilePost);
                }

            });
        }
    posting();
    $(document).on("click","#del",function(e){
      e.preventDefault();
      var postId = $(this).attr("value");
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
              url : "<?php echo base_url()?>profiles/delete",
              type : "post",
              data : {
                postId : postId
              },
              success : function(data){
                posting();
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
    
    </script>