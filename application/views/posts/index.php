<h1><?=$title?></h1>
<?php foreach($posts as $post):?>
    
    <div class="dropdown">
            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
            
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="<?php echo site_url("/posts/".$post["slug"]);?>">
                <div>
                    Read More
                </div> 
            </a></li>
            <li><a class="dropdown-item">
             <!--  pag gusto mo mag navigate sa controller  
            gagamit ka ng site_url("(kung saan controller)/(function ni controller)")-->
            <?php echo form_open('/posts/delete/'.$post['id']);?>
                <input type="submit" class="btn btn-default p-0 text-dark" value="Delete">
            </form>
            </a></li>
            <li><a class="dropdown-item">
                <?php echo form_open('/posts/edit/'.$post['slug']);?>
                    <input type="submit" class="btn btn-default p-0 text-dark" value="Edit">
                </form>
            </a></li>
        </ul>
    </div>
    <h3><?php echo $post["title"];?></h3> 
    <small class="post-date">Posted on <?php echo $post["created_at"];?> in <?php echo $post["name"];?></small>
    <p><?php echo character_limiter($post["body"],400);?></p>
   
    
<?php endforeach;?>