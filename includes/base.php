<?php

$sql = "SELECT * FROM `config` WHERE `name` = '".strtolower($message)."'";
$retval = mysqli_query( $conn, $sql );
if($retval) {
  $row = mysqli_fetch_array($retval, MYSQLI_ASSOC);
	$config = $row;
}

?>