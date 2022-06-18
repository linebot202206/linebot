<?php
require_once('includes/connection.php');
/**
 * Copyright 2021 GoneTone
 *
 * Line Bot
 * 範例 Example Bot (Flex)
 *
 * 此範例 GitHub 專案：https://github.com/GoneToneStudio/line-example-bot-tiny-php
 * 此範例教學文章：https://blog.reh.tw/archives/988
 *
 * 官方文檔：https://developers.line.biz/en/reference/messaging-api/#flex-message
 */

/*
 * 可以使用 Line 官方提供的 Flex Message Simulator 排版
 * https://developers.line.biz/flex-simulator/
 *
 * Flex Message Simulator 是生成 Json，可以利用下方網頁快速轉換成陣列，當然你要手動寫也是可XDD
 * https://www.appdevtools.com/json-php-array-converter
 */

/*
陣列輸出 Json
==============================
{
    "type": "flex",
    "altText": "Example flex message template",
    "contents": {
        "type": "bubble",
        "hero": {
            "type": "image",
            "url": "https://api.reh.tw/images/gonetone/logos/icons/icon-256x256.png",
            "aspectRatio": "16:9",
            "size": "full",
            "aspectMode": "cover"
        },
        "body": {
            "type": "box",
            "layout": "vertical",
            "contents": [
                {
                    "type": "text",
                    "text": "Hello, world!",
                    "weight": "bold",
                    "size": "xl",
                    "margin": "md",
                    "wrap": true
                },
                {
                    "type": "text",
                    "text": "你好，世界！",
                    "wrap": true,
                    "color": "#e96bff"
                }
            ]
        },
        "footer": {
            "type": "box",
            "layout": "vertical",
            "contents": [
                {
                    "type": "button",
                    "action": {
                        "type": "uri",
                        "label": "教學文章",
                        "uri": "https://blog.reh.tw/archives/988#Flex-%E8%A8%8A%E6%81%AF"
                    },
                    "style": "secondary",
                    "color": "#FFD798"
                },
                {
                    "type": "button",
                    "action": {
                        "type": "uri",
                        "uri": "https://github.com/GoneToneStudio/line-example-bot-tiny-php",
                        "label": "GitHub"
                    }
                }
            ]
        },
        "size": "giga"
    }
}
==============================
*/
global $client, $message, $event;
if (strtolower($message['text']) == "flex") {

    $client->replyMessage(array(
        'replyToken' => $event['replyToken'],
        'messages' => array(
            array(
                'type' => 'text',
                'text' => '開始'
            )
        )
    ));

    /* 注意，Flex Message Simulator 生成並轉換的陣列貼在這邊 */
    $name = "2023跨年";
    $contentsArray = output($name);

    if(!$contentsArray){
        $client->replyMessage(array(
            'replyToken' => $event['replyToken'],
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => '失敗'
                )
            )
        ));
    }

    $client->replyMessage(array(
        'replyToken' => $event['replyToken'],
        'messages' => array(
            array(
                'type' => 'flex', //訊息類型 (flex)
                'altText' => 'Example flex message template', //替代文字
                'contents' => $contentsArray //Flex Message 內容
            )
        )
    ));
}

function output($name)
{
    return;
    //取得table
    $sql = "SELECT * FROM `config` WHERE `name` = '$name'";
    //$sql = 'SELECT * FROM travel20221231 ORDER BY day ASC, num ASC';
    $retval = mysqli_query( $conn, $sql );
    if(!$retval ) {
       die('Could not get data: ' . mysqli_error());
    }
    $row = mysqli_fetch_array($retval, MYSQLI_ASSOC);
    $table = $row['table'];

    
    $sql = "SELECT * FROM $table ORDER BY day ASC, num ASC";
    $retval = mysqli_query( $conn, $sql );
  
    if(!$retval ) {
       die('Could not get data: ' . mysqli_error());
    }

    while ($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {
        // 每跑一次迴圈就抓一筆值，最後放進data陣列中
        $data[] = $row;
    }
    $type = "travel";
  
    switch ($type) {
        case 'travel':
           $bubble = travel($name, $data);
           return $bubble;
           echo json_encode($bubble);
           break;
    }
    //mysqli_close($conn);
}

function travel($name, $data)
{
    //echo json_encode($data);
    //把資料依照day整理
    $list = [];
    foreach ($data as $value) {
        $list[$value['day']][] = $value;
    }
    $days = array_keys($list);
    //echo $list[0]['label'];

    $dots = [
       "type" => "box",
       "layout" => "vertical",
       "contents" => [
          ["type" => "filler"],
          [
             "type" => "box",
             "layout" => "vertical",
             "contents" => [],
             "cornerRadius" => "30px",
             "height" => "12px",
             "width" => "12px",
             "borderColor" => "#4B656C",
             "borderWidth" => "2px",
             "backgroundColor" => "#4B656C",
          ],
          ["type" => "filler"],
       ],
       "flex" => 0,
    ];

    $spaceLeft = [
       "type" => "box",
       "layout" => "baseline",
       "contents" => [],
       "flex" => 1,
    ];

    $filler = [
       "type" => "box",
       "layout" => "vertical",
       "contents" => [
          [
             "type" => "box",
             "layout" => "horizontal",
             "contents" => [
                   ["type" => "filler"],
                   [
                      "type" => "box",
                      "layout" => "vertical",
                      "contents" => [],
                      "width" => "2px",
                      "backgroundColor" => "#4B656C"
                   ],
                   ["type" => "filler"],
                ],
             "flex" => 1,
          ],
       ],
       "width" => "12px",
    ];

    $spaceRight = [
       "type" => "box",
       "layout" => "baseline",
       "contents" => [],
       "flex" => 4,
    ];

    $fillerBox = [
       "type" => "box",
       "layout" => "horizontal",
       "contents" => [$spaceLeft, $filler, $spaceRight],
       "spacing" => "lg",
       "height" => "20px"
    ];

    //$days = [1];

    foreach ($days as $day) {
    //$day = 1;
        $start = reset($list[$day])['county'];
        $end = end($list[$day])['county'];

        $bubbleContents = [];
        $header = [
            "type" => "box",
            "layout" => "vertical",
            "contents" => [
              [
                "type" => "box",
                "layout" => "vertical",
                "contents" => [
                  [
                    "type" => "text",
                    "text" => $name,
                    "color" => "#D7DBCB",
                    "size" => "sm",
                    "weight" => "bold"
                  ],
                  [
                    "type" => "text",
                    "text" => "Day ".$day,
                    "color" => "#ffffff",
                    "size" => "xl",
                    "flex" => 4,
                    "weight" => "bold"
                  ]
                ]
              ],
              [
                "type" => "box",
                "layout" => "vertical",
                "contents" => [
                  [
                    "type" => "text",
                    "text" => "$start - $end",
                    "color" => "#D7DBCB",
                    "size" => "sm",
                    "weight" => "bold"
                  ]
                ]
              ]
            ],
            "paddingAll" => "20px",
            "backgroundColor" => "#4B656C",
            "spacing" => "md",
            "height" => "110px",
            "paddingTop" => "22px"
        ];

        foreach ($list[$day] as $placeData) {
            //print_r($place);
            $label = [
               "type" => "text",
               "text" => $placeData['label'],
               "size" => "sm",
               "gravity" => "center",
               "color" => "#686868",
               "weight" => "bold",
            ];

            $place = [
               "type" => "text",
               "text" => $placeData['name'],
               "gravity" => "center",
               "flex" => 4,
               "size" => "sm",
               "color" => "#0FAFBB",
               "weight" => "bold",
            ];

            $placeBox = [
                "type" => "box",
                "layout" => "horizontal",
                "contents" => [$label, $dots, $place],
                "spacing" => "lg",
                "cornerRadius" => "30px",
            ];
            $bubbleContents[] = $placeBox;
            if(end($list[$day]) != $placeData){
                $bubbleContents[] = $fillerBox;
                /*
                print_r(end($list[$day]));
                echo "<br>";
                print_r($placeData);
                echo "<br>";
                echo "--------------------------";
                echo "<br>";
                */
            }
            
        }

        $box = [
            "type" => "bubble",
            "size" => "mega",
            "header" => $header,
            "body" => [
                "type" => "box",
                "layout" => "vertical",
                "contents" => $bubbleContents,
            ],
        ];
        $bubble[] = $box;
    }

    /*
    $bubble = [
       "type" => "bubble",
       "size" => "mega",
       "body" => [
          "type" => "box",
          "layout" => "vertical",
          "contents" => $bubbleContents,
       ],
    ];
    */

    $carousel = [
      "type" => "carousel",
      "contents" => $bubble,
    ];

    return $carousel;

    $label = [
       "type" => "text",
       "text" => "租車",
       "size" => "sm",
       "gravity" => "center",
       "color" => "#686868",
       "weight" => "bold",
    ];

    $dots = [
       "type" => "box",
       "layout" => "vertical",
       "contents" => [
          ["type" => "filler"],
          [
             "type" => "box",
             "layout" => "vertical",
             "contents" => [],
             "cornerRadius" => "30px",
             "height" => "12px",
             "width" => "12px",
             "borderColor" => "#4B656C",
             "borderWidth" => "2px",
             "backgroundColor" => "#4B656C",
          ],
          ["type" => "filler"],
       ],
       "flex" => 0,
    ];

    $place = [
       "type" => "text",
       "text" => "格上租車",
       "gravity" => "center",
       "flex" => 4,
       "size" => "sm",
       "color" => "#0FAFBB",
       "weight" => "bold",
    ];

    $placeBox = [$label, $dots, $place];

    $spaceLeft = [
       "type" => "box",
       "layout" => "baseline",
       "contents" => [],
       "flex" => 1,
    ];

    $filler = [
       "type" => "box",
       "layout" => "vertical",
       "contents" => [
          [
             "type" => "box",
             "layout" => "horizontal",
             "contents" => [
                   ["type" => "filler"],
                   [
                      "type" => "box",
                      "layout" => "vertical",
                      "contents" => [],
                      "width" => "2px",
                      "backgroundColor" => "#4B656C"
                   ],
                   ["type" => "filler"],
                ],
             "flex" => 1,
          ],
       ],
       "width" => "12px",
    ];

    $spaceRight = [
       "type" => "box",
       "layout" => "baseline",
       "contents" => [],
       "flex" => 4,
    ];

    $fillerBox = [
       "type" => "box",
       "layout" => "horizontal",
       "contents" => [$spaceLeft, $filler, $spaceRight],
       "spacing" => "lg",
       "height" => "20px"
    ];

    $bubble = [
       "type" => "bubble",
       "size" => "mega",
       "body" => [
          "type" => "box",
          "layout" => "vertical",
          "contents" => [
                [
                "type" => "box",
                "layout" => "horizontal",
                "contents" => $placeBox,
                "spacing" => "lg",
                "cornerRadius" => "30px",
                "margin" => "xl",
               ],
               $fillerBox,
          ],
       ],
    ];

    return $bubble;
}
