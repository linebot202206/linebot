<?php
$dbhost = 'remotemysql.com:3306';
$dbuser = '9b3cxQX9UY';
$dbpass = '3EdzRNODN8';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass);
 
if(! $conn ) {
   die('Could not connect: ' . mysqli_error());
}
mysqli_select_db($conn, '9b3cxQX9UY');
//mysqli_close($conn);
$a = 123;
?>