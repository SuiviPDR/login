<?php
$conn = mysqli_connect('localhost','root','','myphp');
if(!$conn){
    die('Error' . mysqli_connect_error());   
}
