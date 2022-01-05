    <div class="cover">
        <?php if(!empty($user["user_cover_photo"])){?>
            <img src="<?php echo base_url().$user["user_cover_photo"];?>" id="coverphoto">
        <!-- <input type="file" id="filecover"> -->
        <?php }else{?>
            <img src="<?php echo base_url();?>assets/image/defaultcover.png" alt="" id="coverphoto">
        <!-- <input type="file" id="filecover"> -->
        <?php } ?>
    <?php if($user["user_id"] == $this->session->userdata("user_id")):?>
        <div class="banner" >
            <h6>Edit Banner</h6>
            <img src="<?php echo base_url();?>assets/image/star.png" alt="starmenu">
            <div class="sub-menu-1">    
                <ul>
                    <!-- <li><label for="filecover" id="uploadcover">Upload </label></li> -->
                    <li>
                        <?php echo form_open_multipart("profiles/upload_image")?>
                            <input type="file" name="userfile" size="20">
                            <input type="hidden" name="user_id" value="<?php echo $user["user_id"];?>">
                            <button type="submit">Upload</button>
                        </form>
                    </li>
                    <li><!-- <label for="file" id="removecover">Remove </label> -->
                        <?php echo form_open_multipart("profiles/delete_image")?>
                            <input type="hidden" name="user_id" value="<?php echo $user["user_id"];?>">
                            <input type="hidden" name="cover_photo" value="<?php echo $user["user_cover_photo"];?>">
                            <button type="submit">Remove</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
         <?php endif;?>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4">
                <div class="profile">
                    <div class="profileimage">
                        <?php if(!empty($user["user_profile_photo"])){?>
                            <img src="<?php echo base_url().$user["user_profile_photo"];?>" id="coverphoto">
                        <!-- <input type="file" id="filecover"> -->
                        <?php }else{?>
                             <img src="<?php echo base_url();?>assets/image/user.png" alt="" id="profilephoto">
                        <?php } ?>
                        <!-- <input type="file" id="fileprofile"> -->
                        <?php if($user["user_id"] == $this->session->userdata("user_id")):?>
                        <div class="profilemenu">
                            <img src="<?php echo base_url();?>assets/image/star.png" alt="starmenu">
                            <div class="profilelabel">
                                <ul>
                                    <li> <!-- <label for="fileprofile" id="uploadprofile"> Upload</label>  -->
                                         <?php echo form_open_multipart("profiles/upload_profile")?>
                                            <input type="file" name="userfile" size="20">
                                            <input type="hidden" name="user_id" value="<?php echo $user["user_id"];?>">
                                            <button type="submit">Upload</button>
                                        </form>
                                    </li>
                                    <li> <!-- <label for="file" id="removeprofile"> Remove</label> --> 
                                            <?php echo form_open_multipart("profiles/delete_profile")?>
                                                <input type="hidden" name="profile_photo" value="<?php echo $user["user_profile_photo"];?>">
                                                <input type="hidden" name="user_id" value="<?php echo $user["user_id"];?>">
                                                <button type="submit">Remove</button>
                                            </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    <?php endif;?>
                    </div>
                    
                    <h2><?php echo $user["username"]?></h2>
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

