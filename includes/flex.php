<?php
global $client, $message, $event;
if (strtolower($message['text']) == "flex" || $config['type'] == "flex") {
    /* 注意，Flex Message Simulator 生成並轉換的陣列貼在這邊 */
    $name = $message['text'];
    $contentsArray = output($name);

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
