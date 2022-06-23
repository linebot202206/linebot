<?php

/*
$sql = "SELECT * FROM `config` WHERE `name` = '".strtolower($message['text'])."'";
$retval = mysqli_query( $conn, $sql );
if($retval) {
  $row = mysqli_fetch_array($retval, MYSQLI_ASSOC);
	$config = $row;
}
*/
global $client, $message, $event;
if (strpos( $message['text'], "#" ) === 0) {
	$client->replyMessage(array(
        'replyToken' => $event['replyToken'],
        'messages' => array(
            array(
                'type' => 'text', //訊息類型 (文字)
                'text' => $message['text']
                //'text' => 'Hello, world!'.$profile['displayName'] //回覆訊息
            )
        )
    ));
}
$command = explode(" ",$message['text']);

$sql = "SELECT * FROM `config`";
$retval = mysqli_query( $conn, $sql );
if($retval) {
    while ($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {
        $data[$row['name']] = $row;
    }

    $type = $data[$command[0]]['type'];
	$name = isset($command[1])?$command[1]:$command[0];
}

?>