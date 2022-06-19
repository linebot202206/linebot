<?php
global $client, $message, $event;
if ($type == "flex") {
    /* 注意，Flex Message Simulator 生成並轉換的陣列貼在這邊 */
    $name = strtolower($name);
    if($data[$name]['label'] == "travel"){
        $contentsArray = output($name);
    }elseif ($config['label'] == "introduce") {
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
            if($placeData['url']){
                $place['action'] = [
                    "type" => "uri",
                    "label" => "action",
                    "uri" => "https://liff.line.me/1657231784-R4vDzKzK?url=".$placeData['url']
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

function introduce()
{
    $arr = array(
        "type" => "bubble",
        "hero" => array(
            "type" => "image",
            "url" => "https://scdn.line-apps.com/n/channel_devcenter/img/fx/01_1_cafe.png",
            "size" => "full",
            "aspectRatio" => "20:13",
            "aspectMode" => "cover"
        ),
        "body" => array(
            "type" => "box",
            "layout" => "vertical",
            "contents" => array(
                array(
                    "type" => "text",
                    "text" => "Brown Cafe",
                    "weight" => "bold",
                    "size" => "xl"
                ),
                array(
                    "type" => "box",
                    "layout" => "vertical",
                    "margin" => "lg",
                    "spacing" => "sm",
                    "contents" => array(
                        array(
                            "type" => "box",
                            "layout" => "baseline",
                            "spacing" => "sm",
                            "contents" => array(
                                array(
                                    "type" => "text",
                                    "text" => "地址",
                                    "color" => "#aaaaaa",
                                    "size" => "sm",
                                    "flex" => 1,
                                    "weight" => "bold"
                                ),
                                array(
                                    "type" => "text",
                                    "text" => "新北市板橋區文化路二段266號",
                                    "wrap" => true,
                                    "color" => "#666666",
                                    "size" => "sm",
                                    "flex" => 5
                                )
                            )
                        ),
                        array(
                            "type" => "box",
                            "layout" => "baseline",
                            "spacing" => "sm",
                            "contents" => array(
                                array(
                                    "type" => "text",
                                    "text" => "時間",
                                    "color" => "#aaaaaa",
                                    "size" => "sm",
                                    "flex" => 1,
                                    "weight" => "bold"
                                ),
                                array(
                                    "type" => "text",
                                    "text" => "08:30 - 20:30",
                                    "wrap" => true,
                                    "color" => "#666666",
                                    "size" => "sm",
                                    "flex" => 5
                                )
                            )
                        ),
                        array(
                            "type" => "box",
                            "layout" => "baseline",
                            "spacing" => "sm",
                            "contents" => array(
                                array(
                                    "type" => "text",
                                    "text" => "介紹",
                                    "color" => "#aaaaaa",
                                    "size" => "sm",
                                    "flex" => 1,
                                    "weight" => "bold"
                                ),
                                array(
                                    "type" => "text",
                                    "text" => "格上汽車租賃股份有限公司，簡稱格上租車，是臺灣一家汽車租賃公司，其母公司為裕融企業股份有限公司。 格上租車於1998年12月加入裕隆汽車集團，並陸續併購多家同業公司，目前是臺灣第二大租車公司，市場佔有率約23%。",
                                    "wrap" => true,
                                    "color" => "#666666",
                                    "size" => "sm",
                                    "flex" => 5
                                )
                            )
                        )
                    )
                )
            )
        ),
        "footer" => array(
            "type" => "box",
            "layout" => "vertical",
            "spacing" => "sm",
            "contents" => array(
                array(
                    "type" => "button",
                    "style" => "link",
                    "height" => "sm",
                    "action" => array(
                        "type" => "uri",
                        "label" => "Google",
                        "uri" => "https://linecorp.com"
                    )
                ),
                array(
                    "type" => "button",
                    "style" => "link",
                    "height" => "sm",
                    "action" => array(
                        "type" => "uri",
                        "label" => "開啟地圖",
                        "uri" => "https://linecorp.com"
                    )
                ),
                array(
                    "type" => "box",
                    "layout" => "vertical",
                    "contents" => array(),
                    "margin" => "sm"
                )
            ),
            "flex" => 0
        )
    );

    return $arr;
}
