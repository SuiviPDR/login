<?php
include('inc/connections.php');
if(isset($_POST['submit'])){
    $username = stripcslashes(strtolower($_POST['username']));
    $email =stripcslashes($_POST['email']);
    $password =stripcslashes($_POST['password']);

    if(isset($_POST['birthday_day']) && isset($_POST['birthday_month']) && isset($_POST['birthday_year'])){
        $birthday_day = (int) $_POST['birthday_day'];
        $birthday_month = (int) $_POST['birthday_month'];
        $birthday_year = (int) $_POST['birthday_year'];
        $birthday = htmlentities(mysqli_escape_string($conn, $birthday_day.'-'. $birthday_month.'-'. $birthday_year));

    }
    $username = htmlentities(mysqli_escape_string($conn,$_POST['username']));
    $email = htmlentities(mysqli_escape_string($conn,$_POST['email']));
    $password = htmlentities(mysqli_escape_string($conn,$_POST['password']));
    $md5_passe = md5($password);

if(isset($_POST['gender'])){
    $gender = ($_POST['gender']);
    $gender = htmlentities(mysqli_real_escape_string($conn,$_POST['gender']));

    if(!in_array($gender,['male','female'])){
        $gender_error = 'pleace chose gender not a text ! <br>';
        $err_s = 1 ;
    }
}


$check_user = "SELECT * FROM `users` WHERE username = '$username'";
$check_result = mysqli_query($conn,$check_user);
$num_rows = mysqli_num_rows($check_result);
if($num_rows != 0){
    $user_error = 'sorry username already exist change another one <br>';
    $err_s = 1;
}


if(empty($username)) {
    $user_error = 'Please enter your username <br>';
    $err_s = 1 ;
}elseif(strlen($username) < 6){
    $user_error = 'This username is invalid <br>';
    $err_s = 1 ;
}elseif(filter_var($username, FILTER_VALIDATE_INT)){
    $user_error = 'Please enter a valid username not a number <br>';
    $err_s = 1 ;
}

if(empty($email)) {
    $email_error = 'Please enter your email <br>';
    $err_s = 1 ;
}elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $email_error = 'Please in valid email <br>';
    $err_s = 1 ;
}

if(empty($gender)){
    $gender_error = 'Pleease choose gender <br>';
    $err_s = 1 ;
}

if(empty($birthday)){
    $birthday_error = 'Please insert date of birthday <br>';
    $err_s = 1 ;
}

if(empty($password)){
    $pass_error = 'Please insert password <br>';
    $err_s = 1 ;
    include('registrer.php');
}elseif(strlen($password) < 6) {
    $pass_error = 'This password is invalid <br>';
    $err_s = 1 ;
    include('registrer.php');
}

else{
    if(($err_s == 0) && ($num_rows == 0)){
        if($gender === 'male'){
            $picture = 'male.png';
        }elseif($gender === 'female'){
            $picture = 'female.png';
        }
        $sql = "INSERT INTO users (username,email,password,birthday,gender,md5_passe,profile_picture) 
        VALUES ('$username','$email','$password','$birthday','$gender','$md5_passe','$picture')";
        mysqli_query($conn,$sql);
        header('location:index.php');
    }else{
        include('registrer.php');
    }
}




}