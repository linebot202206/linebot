<?php

/*
$sql = "SELECT * FROM `config` WHERE `name` = '".strtolower($message['text'])."'";
$retval = mysqli_query( $conn, $sql );
if($retval) {
  $row = mysqli_fetch_array($retval, MYSQLI_ASSOC);
	$config = $row;
}
*/

$command = explode(" ",$message['text']);

$sql = "SELECT * FROM `config`";
$retval = mysqli_query( $conn, $sql );
if($retval) {
    while ($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {
        $data[$row['name']] = $row;
    }

    $type = $data[$command[0]]['label'];
	$name = isset($command[1])?$command[1]:$command[0];
}

?>