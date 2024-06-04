<?php
include_once('inc/connections.php');


if(empty($_POST['file'])){
    $error = '<div class="error"><p id="eroor">pleace choose photo to upload ! </p></div>';
    include_once('homme.php');
}else{
    session_start();
}


if(isset($_SESSION['id']) && isset($_SESSION['username'])){
    $username = $_SESSION['username'];

if(isset($_POST['submit'])){
    $file = $_FILES['file'];
    $file_name = $_FILES['file']['name'];
    $file_size = $_FILES['file']['size'];
    $file_error = $_FILES['file']['error'];
    $file_type = $_FILES['file']['type'];
    $file_tmp = $_FILES['file']['tmp_name'];


    $file_ext = explode('.', $file_name);
    $file_actual_ext = strtolower(end($file_ext));
    $allowed = array('jpg','jpge','png','svg','icon');
    if(in_array($file_actual_ext, $allowed)){
        if($file_error === 0){
            if($file_size < 3000000){
                $file_new_name = uniqid('',true).'.'.$file_actual_ext ;
                $target = 'image/'. $file_new_name;
                $sql = "UPDATE users SET profile_picture = '$file_new_name' WHERE username = '$username'";
                mysqli_query($conn, $sql);
                move_uploaded_file($file_tmp,$target);
                header('location:homme.php');

            }else{
                $error = '<p id="eroor">Your photo is too big!</p>';
                include_once('homme.php');
            }

        }else{
            $error = '<p id="eroor">Error in upload photo !</p>';
            include_once('homme.php');
        }

    }else{
        $error = 'You cannot upload photo of thid type ! ';
        include_once('homme.php');
    }



}

    








}
?>

<style>
    .error{
        color: crimson;
    }
</style>