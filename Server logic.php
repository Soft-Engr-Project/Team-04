//Server Logic
<?php
session_start();

//initialization of var

$username = "";
$email = "";

//connect to db

$db = mysqli_connect('localhost', 'root', '', 'users') or die("Could not establish connection with database");

//register

$username = mysqli_real_escape_string($db, $_POST['username']);
$email = mysqli_real_escape_string($db, $_POST['email']);
$password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
$password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

//validate form

if(empty($username)) {array_push($errors, "Username must be input")};
if(empty($email)) {array_push($errors, "Email must be input")};
if(empty($password_1)) {array_push($errors, "Password must be input")};

if($password_1 != $password_2){array_push($errors, "Password must match")};

// check the db for existing username

$user_check_query = "SELECT * FROM user WHERE username = '$username' or email = '$email' LIMIT 1";

$results = mysqli_query($db, $user_check_query);
$user = mysqli_fetch_assoc($result);

if($user){

if($user['username'] === $username){array_push($errors, "Username is already in use");}
if($user['email'] === $email){array_push($errors, "Email is already in use");}


} 

// User Registration with no error 

if(count($errors) == 0) {
    $password = password_hash($password_1, PASSWORD_DEFAULT); // hash the password
    $query = "INSERT INTO user (username, email, password) VALUES ('$username', '$email', '$password')";

    mysqli_query($db, $query);
    $_SESSION['username'] = $username;
    $_SESSION['success'] = "You are now logged in";

    header('location: index.php');

}

// LOGIN LOGIC
if(isset($_POST['login_user'])) {

	$username = mysqli_real_escape_string($db, $_POST['username']);
	$password = mysqli_real_escape_string($db, $_POST['password']);

    if(empty($username)) {
        array push($errors, "Username must be input");

    }
   if(empty($password)) {
        array push($errors, "Password required!");

    }

    if(count($errors) == 0) {   

        $password = password_hash($password, PASSWORD_DEFAULT); // store hashed password

        $query = "SELECT * FROM user WHERE username = '$username' AND password = '$password'"; 
        $results = mysqli_query($db, $query);

        if(mysqli_num_rows($results)) {

            $_SESSION['username'] = $username;
            $_SESSION['success'] = "Login success";

            header('location: index.php');
        } else {
            array_push($errors, "Wrong username/password! Please try again.");
        }
    }
}


?>