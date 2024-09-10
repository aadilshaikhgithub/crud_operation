<?php
$hostname ="localhost";
$username = "root";
$password = "";
$tablename ="php_test";

$conn = mysqli_connect($hostname, $username, $password, $tablename);

if (!$conn){
    die("Connection failed: " .mysqli_connect_error()) ;
}
?>