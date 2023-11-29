<?php

$hostName = "localhost";
$dbuser = "root";
$dbPassword ="";
$dbName = "userinfo";
$conn = mysqli_connect($hostName, $dbuser, $dbPassword, $dbName);
if(!$conn){
    die('Etwas ist schiefgelaufen!');
}
?>