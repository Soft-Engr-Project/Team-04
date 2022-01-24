<div onclick="checkMousePointer()">
    <div class="covermodal" id="coverpage">
            <div class="changecover_profile">
                <div class="navbarsmall"></div>
                <?php if(!empty($user["user_cover_photo"])){?>
                    <img src="<?php echo base_url().$user["user_cover_photo"];?>"id="smallcover" class="imagesmall">
                <?php }else{?>
                    <img src="<?php echo base_url();?>assets/image/defaultcover.png" alt="" id="smallcover" class="imagesmall">
                <?php } ?> 
                <div class="profilesmall">
                    <img src="" alt="">
                </div>
                <div class="smallcontent">
                    <h4>Change Cover Photo</h4>
                    <?php echo form_open_multipart("profiles/upload_image")?> 
                        <input type="file" id="filecover" name="userfile" size="20"> 
                        <input type="hidden" name="user_id" value="<?php echo $user["user_id"];?>">
                        <button class="smallbutton1">Save Changes</button>                    
                    </form>
                    <a href="#"><button class="smallbutton2" id="close" >Cancel</button></a>
                </div>
            </div>
        </div>

        <div class="covermodal" id="profilepage">
            <div class="changecover_profile">
                <div class="reviewprofile">
                    <?php if(!empty($user["user_profile_photo"])){?>
                        <img src="<?php echo base_url().$user["user_profile_photo"];?>" id="smallprofile">
                    <?php }else{?>
                        <img src="<?php echo base_url();?>assets/image/user.png" alt="" id="smallprofile">
                    <?php } ?>
                </div>
                <div class="smallcontent">
                    <h4>Change Profile Picture</h4>
                     <?php echo form_open_multipart("profiles/upload_profile")?>
                            <input type="file" id="filepro" name="userfile" size="20">
                            <input type="hidden" name="user_id" value="<?php echo $user["user_id"];?>">
                            <button class="smallbutton1">Save Changes</button>
                    </form>
                    <a href="#"><button class="smallbutton2" id="close" >Cancel</button></a>
                </div>
            </div>
        </div>
        
        <div class="cover">
            <?php if(!empty ($user["user_cover_photo"])){?> <img src="<?php echo base_url().$user ["user_cover_photo"];?>" id="coverphoto">
            <?php }else{?>
                <img src="<?php echo base_url();?>assets/image/defaultcover.png" alt="" id="coverphoto">
            <?php } ?>
            <?php if($user["user_id"] == $this->session->userdata("user_id")):?>
            <div class="bannercrud" >
                    <h6>Edit Banner</h6>
                    <img src="<?php echo base_url();?>assets/image/star.png" alt="starmenu"> 
                <ul class="photomenu">
                    <li><a href="#coverpage"> Upload </a> </li>
                    <li> 
                        <?php echo form_open_multipart("profiles/delete_image")?>
                            <input type="hidden" name="user_id" value="<?php echo $user["user_id"];?>">
                            <input type="hidden" name="cover_photo" value="<?php echo $user["user_cover_photo"];?>">
                            <button type="submit">Remove</button>
                        </form>
                    </li>
                </ul>
            </div>
            <?php endif;?>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4">
                    <div class="profile">
                        <div class="profileimage">
                        <?php if(!empty($user["user_profile_photo"])){?>
                            <img src="<?php echo base_url().$user["user_profile_photo"];?>" id="profilephoto">
                        <?php }else{?>
                             <img src="<?php echo base_url();?>assets/image/user.png" alt="" id="profilephoto">
                        <?php } ?>    
                        <?php if($user["user_id"] == $this->session->userdata("user_id")):?>                  
                        <div class="bannercrud">
                                <img src="<?php echo base_url();?>assets/image/star.png" alt="starmenu">
                                <h6>Edit Profile</h6>
                                <ul class="photomenu">
                                    <li><a href="#profilepage" > Upload </a> </li>
                                    <li>
                                        <?php echo form_open_multipart("profiles/delete_profile")?>
                                            <input type="hidden" name="profile_photo" value="<?php echo $user["user_profile_photo"];?>">
                                            <input type="hidden" name="user_id" value="<?php echo $user["user_id"];?>">
                                        <button type="submit">Remove</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        <?php endif;?>
                        </div>
                        <h2><?php echo $user["username"]?></h2>
                        <div class="profilecontent">
                            <h4>Post: <?php echo count($posts)?></h4>
                            <h4>Reactions: <?php echo $react_count?> </h4>
                        </div>
                    </div>

