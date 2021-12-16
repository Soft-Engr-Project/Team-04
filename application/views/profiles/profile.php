    <div class="cover">
        <img src="<?php echo base_url();?>assets/image/defaultcover.png" alt="" id="coverphoto">
        <input type="file" id="filecover">

        <div class="banner" >
            <h6>Edit Banner</h6>
            <img src="<?php echo base_url();?>assets/image/star.png" alt="starmenu">
            <div class="sub-menu-1">    
                <ul>
                    <li><label for="filecover" id="uploadcover">Upload </label></li>
                    <li><label for="file" id="removecover">Remove </label></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4">
                <div class="profile">
                    <div class="profileimage">
                        <img src="<?php echo base_url();?>assets/image/user.png" alt="" id="profilephoto">
                        <input type="file" id="fileprofile">

                        <div class="profilemenu">
                            <img src="<?php echo base_url();?>assets/image/star.png" alt="starmenu">
                            <div class="profilelabel">
                                <ul>
                                    <li> <label for="fileprofile" id="uploadprofile"> Upload</label> </li>
                                    <li> <label for="file" id="removeprofile"> Remove</label> </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <h2><?php echo $this->session->userdata("username");?></h2>
                    <div class="profilecontent">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-5">
                                    <h4>Posts: <?php echo count($posts)?></h4>
                                </div>
    
                                <div class="col-lg-7">
                                    <h4>Reactions: <?php echo $react_count?></h4>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>

