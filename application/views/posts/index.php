               <div class="row">
                    <div class="col-lg-6">
                        <div class="divcategor">
                            <p>Categories:</p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="divfilter">
                            <span class="labelfilter">Filter: </span>
                            <select name="" id="category_filter">
                                <option value="0">Show All</option>
                                <?php foreach ($categories as $category) :?>
                                    <option value="<?php echo $category["category_id"];?>"><?php echo $category["name"];?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div id="filterposting">
                    <?php foreach($categories as $category):?>
                    <?php if($category["name"])?>
                    <div class="categoriesdiv">
                        <h3><?php echo $category["name"];?></h3>
                    </div>
                    <?php if($category["category_post_count"] != 0) {?>
                    <?php foreach($posts as $post):?>
                    <?php if($post["name"] == $category["name"]):?>         
                    <div class="homethread">
                        <div class="toppost">
                            <div class="circleimage">
                                <?php if(!empty($post["user_profile_photo"])){ ?>
                                    <img style="border: 1px solid #000000;" src="<?php echo base_url().$post["user_profile_photo"];?>" class="userprofile">
                                <?php }
                                else{?>
                                    <img src="<?php echo base_url();?>assets/image/user.png" alt="" class="userprofile">
                                <?php } ?>
                            </div>

                            <div>
                                <h2><a href="<?php echo site_url("profiles/view/".$post["user_id"]);?>"><?php echo ucfirst($post["username"]);?></a></h2>
                                <h4><a href="<?php echo site_url("posts/".$post["id"]);?>"><?php echo $post["title"];?></a></h4>
                                <p> Posted on: <?php echo $post["post_created_at"];?></p>
                            </div>
                        </div> 
                    </div> 
                    <?php endif;?>
                    <?php endforeach;?>
                    <?php  }else {?>
                        <div class="toppost">
                            <h4>No post in this section.</h4>
                        </div>  
                    <?php } ?>  
                    <?php endforeach;?> 
                </div>    
            </div>
        </div>
    </div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>
        
        $(document).ready(function(){
            $("#category_filter").change(function(){
                let a = $(this).val();
                posting();
            })
        })
        function posting(){
            var cat = $("#category_filter").val();
            console.log(cat);
            $.ajax({
                url : "<?php echo base_url("posts/post_filter");?>",
                data : {
                    category : cat
                },
                beforeSend: function(){
                    $("#filterposting").html('<div class="loading loading--full-height"></div>');
                },
                success:function(data){
                    
                    let result = data.replace(/<!--  -->/g, "");
                    data = JSON.parse(result);
                    
                    
                    // check natin kung malaman si
                if(cat != 0){
                    // dito ko na ififilter ytung mga post nila
                    let posting = "";
                    let count = 0; // para magprint lnag si  category ng isang beses
                    data["posts"].forEach(element =>{
                        if(count == 0){
                            posting+= `<div class="categoriesdiv">
                                        <h3>${element["name"]}</h3>
                                        </div>`
                                        count++;}
                               
                             posting+=` <div class="homethread">
                            <div class="toppost">
                                <div class="circleimage">
                                            <img src="<?php echo base_url();?>assets/image/user.png" alt="" class="userprofile">
                                        </div>
                                <div>
                                    <h2><a href="<?php echo base_url()."profiles/view/"?>${element["user_id"]}">${element["username"]}</a></h2>
                                    <h4><a href="<?php echo base_url()."posts/"?>${element["id"]}">${element["title"]}</a></h4>
                                    <p> Posted on: ${element["post_created_at"]}</p>
                                </div>
                            </div> 
                        </div> `
                        });

                    $("#filterposting").html(posting);
                }else{
                    
                    let posting = "";
                     data["categories"].forEach(category =>{
                            if(category["name"])
                            posting +=`<div class="categoriesdiv">
                                        <h3>${category["name"]}</h3>
                                        </div>`
                              if(category["category_post_count"] != 0) {

                              data["posts"].forEach(post => {
                                if(post["name"] == category["name"]){
                                
                                    posting +=` <div class="homethread">
                            <div class="toppost">
                                <div class="circleimage">
                                    <img src="<?php echo base_url();?>assets/image/user.png" alt="" class="userprofile">
                                </div>
                                <div>
                                    <h2><a href="<?php echo base_url()."profiles/view/"?>${post["user_id"]}">${post["username"]}</a></h2>
                                    <h4><a href="<?php echo base_url()."posts/"?>${post["id"]}">${post["title"]}</a></h4>
                                    <p> Posted on: ${post["post_created_at"]}</p>
                                </div>
                            </div> 
                        </div> `
                             }
                         });
                        }else {
                               posting+=` <div class="row">
                                    <div class="mt-5">
                                         <h3 class="col-lg-12">No post in this section</h3>
                                    </div>
                                   
                                 </div>`;
                         }   
                        posting+=`</div>`;
                    });
                      $("#filterposting").html(posting);
                }
            }
            ,error: function (request, status, error) {
                 console.log(request.responseText);
             }

            });
        }
    </script>

    <script>
        $(document).ready(function(){
            $(".notification_icon .fa-bell").click(function(){
                $(".notifdropdown").toggleClass("active");
            })
        });
    </script>

