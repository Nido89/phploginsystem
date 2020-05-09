<?php
/*
This file contains database connection config assuming 
root user and password ""
*/
define('DB_SERVER','localhost');
define('DB_USERNAME','root');
define('DB_PASSWORD','');
define('DB_NAME','login');


//try establishing database connection
$conn = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);


//Checking the connection
if($conn == false){
    dir('Error: Can not connect');
}
?>