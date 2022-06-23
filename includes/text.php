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
if (strtolower($message['text']) == "text" || $message['text'] == "#文字") {
    $profile = $client->profile($event['source']['userId']);

    $client->replyMessage(array(
        'replyToken' => $event['replyToken'],
        'messages' => array(
            array(
                'type' => 'text', //訊息類型 (文字)
                'text' => "第一個文字"
                //'text' => 'Hello, world!'.$profile['displayName'] //回覆訊息
            )
        )
    ));

    $client->replyMessage(array(
        'replyToken' => $event['replyToken'],
        'messages' => array(
            array(
                'type' => 'image', //訊息類型 (圖片)
                'originalContentUrl' => 'https://api.reh.tw/images/gonetone/logos/icons/icon-256x256.png', //回覆圖片
                'previewImageUrl' => 'https://api.reh.tw/images/gonetone/logos/icons/icon-256x256.png' //回覆的預覽圖片
            )
        )
    ));
}