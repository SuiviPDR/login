<?php

session_start();

include_once('inc/connections.php');
if(isset($_POST['username']) && isset($_POST['password'])){
    //$username = stripcslashes(strtolower($_POST['username']));
    $md5_passe = md5($_POST['password']);
    //$username = filter_input(INPUT_POST,'username');
    //$password = stripcslashes(strtolower($_POST['password']));
    $username = htmlentities(mysqli_escape_string($conn,$_POST['username']));
    $passsword = htmlentities(mysqli_escape_string($conn,$_POST['password']));
    if(isset($_POST['keep'])){
        $keep = htmlentities(mysqli_escape_string($conn,$_POST['keep']));
        if($keep == 1){
            setcookie('username',$username,time()+ 3600,"/");
            setcookie("password",$passsword,time()+3600,"/");
        }
    }

if(empty($username)) {
    $user_error = '<p id="error"> Please enter your username </p><br>';
    $err_s = 1 ;
}
if(empty($passsword)){
    $pass_error = '<p id="error">Please insert password </p><br>';
    $err_s = 1 ;
    include_once('index.php');
}

}

if(!isset($err_s)){
    $sql = "SELECT id,username FROM users WHERE username = '$username' AND md5_passe = '$md5_passe' limit 1";
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_assoc($result);
    $num_rows = mysqli_num_rows($result);
    if($num_rows != 0){
        if($row['username'] === $username && $row['password'] === $password){
            $_SESSION['username'] = $row['username'];
            $_SESSION['id'] = $row['id'];
            header('Location:homme.php');
            exit();

    }



        }else{
            $user_error = '<p id="error"> worng username or password </p><br>';
            include_once('index.php');
            exit();
            }
    }else{
        include_once('index.php');
        exit();
}