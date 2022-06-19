<?php
global $client, $message, $event;
if ($type == "flex") {
    /* 注意，Flex Message Simulator 生成並轉換的陣列貼在這邊 */
    $name = strtolower($name);

    switch ($data[$command[0]]['label']) {
        case 'travel':
            $contentsArray = output($name);
            break;
        case 'introduce':
            $contentsArray = introduce($name);
            break;
        default:
            # code...
            break;
    }

    if($contentsArray){
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

}

function output($name)
{
    global $conn;
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
        case 'introduce':
           $introduce = introduce($message);
           return $introduce;
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
            if($placeData['url']){
                $place['action'] = [
                    "type" => "message",
                    "label" => "action",
                    "uri" => "景點 ".$placeData['name']
                ];
            }

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

    $carousel = [
      "type" => "carousel",
      "contents" => $bubble,
    ];

    return $carousel;
}

function introduce($name)
{
    $name = "格下租車";
    global $conn;
    //取得table
    $sql = "SELECT * FROM `place` WHERE `name` = '格下租車'";
    $retval = mysqli_query( $conn, $sql );
    if(!$retval ) {
        die('Could not get data: ' . mysqli_error());
    }
    $row = mysqli_fetch_array($retval, MYSQLI_ASSOC);

    $address = [
        "type" => "box",
        "layout" => "baseline",
        "spacing" => "sm",
        "contents" => [
            [
                "type" => "text",
                "text" => "地址",
                "color" => "#aaaaaa",
                "size" => "sm",
                "flex" => 1,
                "weight" => "bold"
            ],
            [
                "type" => "text",
                "text" => $row['address'],
                "wrap" => true,
                "color" => "#666666",
                "size" => "sm",
                "flex" => 5
            ]
        ]
    ];

    $now = time();
    $weekday = date('w', $now);
    $openTime = json_decode($row['time'], TRUE);
    $time = [
        "type" => "box",
        "layout" => "baseline",
        "spacing" => "sm",
        "contents" => [
            [
                "type" => "text",
                "text" => "時間",
                "color" => "#aaaaaa",
                "size" => "sm",
                "flex" => 1,
                "weight" => "bold"
            ],
            [
                "type" => "text",
                "text" => $openTime[$weekday],
                "wrap" => true,
                "color" => "#666666",
                "size" => "sm",
                "flex" => 5
            ]
        ]
    ];

    $introduce = [
        "type" => "box",
        "layout" => "baseline",
        "spacing" => "sm",
        "contents" => [
            [
                "type" => "text",
                "text" => "介紹",
                "color" => "#aaaaaa",
                "size" => "sm",
                "flex" => 1,
                "weight" => "bold"
            ],
            [
                "type" => "text",
                "text" => $row['introduce'],
                "wrap" => true,
                "color" => "#666666",
                "size" => "sm",
                "flex" => 5
            ]
        ]
    ];

    $body = [
        [
            "type" => "text",
            "text" => $row['name'],
            "weight" => "bold",
            "size" => "xl"
        ],
        [
            "type" => "box",
            "layout" => "vertical",
            "margin" => "lg",
            "spacing" => "sm",
            "contents" => [$address, $time, $introduce]
        ],
    ];

    if($row['introduce_url']){
        $google = [
            "type" => "button",
            "style" => "link",
            "height" => "sm",
            "action" => [
              "type" => "uri",
              "label" => "Google",
              "uri" => "https://liff.line.me/1657231784-R4vDzKzK?url=".$row['introduce_url']
            ]
        ];
        $footer[] = $google;
    }
    if($row['map_url']){
        $map = [
            "type" => "button",
            "style" => "link",
            "height" => "sm",
            "action" => [
              "type" => "uri",
              "label" => "開啟地圖",
              "uri" => "https://liff.line.me/1657231784-R4vDzKzK?url=".$row['map_url']
            ]
        ];
        $footer[] = $map;
    }


    $out = [
        "type" => "bubble",
        "hero" => [
            "type" => "image",
            "url" => "https://linebot202206.herokuapp.com/img/".$row['img'].".png",
            "size" => "full",
            "aspectRatio" => "20:13",
            "aspectMode" => "cover"
        ],
        "body" => [
        "type" => "box",
        "layout" => "vertical",
            "contents" => $body
        ],
        "footer" => [
            "type" => "box",
            "layout" => "vertical",
            "spacing" => "sm",
            "contents" => $footer,
            "flex" => 0
        ]
    ];

    return $out;
}
