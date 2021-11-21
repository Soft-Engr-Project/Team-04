<?php
if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
    // Verify data
    $email1 = mysql_escape_string($_GET['email']); // Set email variable
    $hash1 = mysql_escape_string($_GET['hash']); // Set hash variable
}
$email = $this->input->post('email'); //Get user email input


if ($email == $email1 && $hash==$hash1 ){ //Compare the values in link
    echo site_url("postreg/login");
}
?>

             
