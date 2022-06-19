<?php
/**
 * Copyright 2020 GoneTone
 *
 * Line Bot
 * 範例 Example Bot (Text)
 *
 * 此範例 GitHub 專案：https://github.com/GoneToneStudio/line-example-bot-tiny-php
 * 此範例教學文章：https://blog.reh.tw/archives/988
 *
 * 官方文檔：https://developers.line.biz/en/reference/messaging-api#text-message
 */

/*
陣列輸出 Json
==============================
{
    "type": "text",
    "text": "Hello, world!"
}
==============================
*/
global $client, $message, $event;
if (strtolower($message['text']) == "text" || $message['text'] == "文字") {
    $profile = json_decode($client-> profile(), true);
    if($profile['displayName']){
        $check = "OK";
    }else{
        $check = "NO";
    }
    $client->replyMessage(array(
        'replyToken' => $event['replyToken'],
        'messages' => array(
            array(
                'type' => 'text', //訊息類型 (文字)
                'text' => $event['source']['userId']."===".$check //回覆訊息
                //'text' => 'Hello, world!'.$a //回覆訊息
            )
        )
    ));
}
