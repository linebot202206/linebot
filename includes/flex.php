<?php
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
    /* 注意，Flex Message Simulator 生成並轉換的陣列貼在這邊 */
    $contentsArray = array(
        "type" => "carousel",
        "contents" => array(
            array(
                "type" => "bubble",
                "size" => "mega",
                "header" => array(
                    "type" => "box",
                    "layout" => "vertical",
                    "contents" => array(
                        array(
                            "type" => "box",
                            "layout" => "vertical",
                            "contents" => array(
                                array(
                                    "type" => "text",
                                    "text" => "2023跨年",
                                    "color" => "#D7DBCB",
                                    "size" => "sm",
                                    "weight" => "bold"
                                ),
                                array(
                                    "type" => "text",
                                    "text" => "Day 1 (12/31)",
                                    "color" => "#ffffff",
                                    "size" => "xl",
                                    "flex" => 4,
                                    "weight" => "bold"
                                )
                            )
                        ),
                        array(
                            "type" => "box",
                            "layout" => "vertical",
                            "contents" => array(
                                array(
                                    "type" => "text",
                                    "text" => "台北 - 嘉義",
                                    "color" => "#D7DBCB",
                                    "size" => "sm",
                                    "weight" => "bold"
                                )
                            )
                        )
                    ),
                    "paddingAll" => "20px",
                    "backgroundColor" => "#4B656C",
                    "spacing" => "md",
                    "height" => "110px",
                    "paddingTop" => "22px"
                ),
                "body" => array(
                    "type" => "box",
                    "layout" => "vertical",
                    "contents" => array(
                        array(
                            "type" => "text",
                            "text" => "預估旅行時間：3小時",
                            "color" => "#C5C5C5",
                            "size" => "xs",
                            "weight" => "bold"
                        ),
                        array(
                            "type" => "box",
                            "layout" => "horizontal",
                            "contents" => array(
                                array(
                                    "type" => "text",
                                    "text" => "租車",
                                    "size" => "sm",
                                    "gravity" => "center",
                                    "color" => "#686868",
                                    "weight" => "bold"
                                ),
                                array(
                                    "type" => "box",
                                    "layout" => "vertical",
                                    "contents" => array(
                                        array(
                                            "type" => "filler"
                                        ),
                                        array(
                                            "type" => "box",
                                            "layout" => "vertical",
                                            "contents" => array(),
                                            "cornerRadius" => "30px",
                                            "height" => "12px",
                                            "width" => "12px",
                                            "borderColor" => "#4B656C",
                                            "borderWidth" => "2px",
                                            "backgroundColor" => "#4B656C"
                                        ),
                                        array(
                                            "type" => "filler"
                                        )
                                    ),
                                    "flex" => 0
                                ),
                                array(
                                    "type" => "text",
                                    "text" => "格上租車",
                                    "gravity" => "center",
                                    "flex" => 4,
                                    "size" => "sm",
                                    "color" => "#0FAFBB",
                                    "weight" => "bold"
                                    "action" => array(
                                        "type" => "uri",
                                        "label" => "action",
                                        "uri" => "https://www.car-plus.com.tw/"
                                    )
                                )
                            ),
                            "spacing" => "lg",
                            "cornerRadius" => "30px",
                            "margin" => "xl"
                        ),
                        array(
                            "type" => "box",
                            "layout" => "horizontal",
                            "contents" => array(
                                array(
                                    "type" => "box",
                                    "layout" => "baseline",
                                    "contents" => array(
                                        array(
                                            "type" => "filler"
                                        )
                                    ),
                                    "flex" => 1
                                ),
                                array(
                                    "type" => "box",
                                    "layout" => "vertical",
                                    "contents" => array(
                                        array(
                                            "type" => "box",
                                            "layout" => "horizontal",
                                            "contents" => array(
                                                array(
                                                    "type" => "filler"
                                                ),
                                                array(
                                                    "type" => "box",
                                                    "layout" => "vertical",
                                                    "contents" => array(),
                                                    "width" => "2px",
                                                    "backgroundColor" => "#4B656C"
                                                ),
                                                array(
                                                    "type" => "filler"
                                                )
                                            ),
                                            "flex" => 1
                                        )
                                    ),
                                    "width" => "12px"
                                ),
                                array(
                                    "type" => "text",
                                    "text" => "開車 3小時",
                                    "gravity" => "center",
                                    "flex" => 4,
                                    "size" => "xs",
                                    "color" => "#8c8c8c"
                                )
                            ),
                            "spacing" => "lg",
                            "height" => "20px"
                        ),
                        array(
                            "type" => "box",
                            "layout" => "horizontal",
                            "contents" => array(
                                array(
                                    "type" => "text",
                                    "text" => "租車",
                                    "size" => "sm",
                                    "gravity" => "center",
                                    "color" => "#686868",
                                    "weight" => "bold"
                                ),
                                array(
                                    "type" => "box",
                                    "layout" => "vertical",
                                    "contents" => array(
                                        array(
                                            "type" => "filler"
                                        ),
                                        array(
                                            "type" => "box",
                                            "layout" => "vertical",
                                            "contents" => array(),
                                            "cornerRadius" => "30px",
                                            "height" => "12px",
                                            "width" => "12px",
                                            "borderColor" => "#4B656C",
                                            "borderWidth" => "2px",
                                            "backgroundColor" => "#4B656C"
                                        ),
                                        array(
                                            "type" => "filler"
                                        )
                                    ),
                                    "flex" => 0
                                ),
                                array(
                                    "type" => "text",
                                    "text" => "格上租車",
                                    "gravity" => "center",
                                    "flex" => 4,
                                    "size" => "sm",
                                    "color" => "#0FAFBB",
                                    "weight" => "bold"
                                )
                            ),
                            "spacing" => "lg",
                            "cornerRadius" => "30px",
                            "margin" => "none"
                        ),
                        array(
                            "type" => "box",
                            "layout" => "horizontal",
                            "contents" => array(
                                array(
                                    "type" => "box",
                                    "layout" => "baseline",
                                    "contents" => array(
                                        array(
                                            "type" => "filler"
                                        )
                                    ),
                                    "flex" => 1
                                ),
                                array(
                                    "type" => "box",
                                    "layout" => "vertical",
                                    "contents" => array(
                                        array(
                                            "type" => "box",
                                            "layout" => "horizontal",
                                            "contents" => array(
                                                array(
                                                    "type" => "filler"
                                                ),
                                                array(
                                                    "type" => "box",
                                                    "layout" => "vertical",
                                                    "contents" => array(),
                                                    "width" => "2px",
                                                    "backgroundColor" => "#4B656C"
                                                ),
                                                array(
                                                    "type" => "filler"
                                                )
                                            ),
                                            "flex" => 1
                                        )
                                    ),
                                    "width" => "12px"
                                ),
                                array(
                                    "type" => "text",
                                    "text" => "開車 3小時",
                                    "gravity" => "center",
                                    "flex" => 4,
                                    "size" => "xs",
                                    "color" => "#8c8c8c"
                                )
                            ),
                            "spacing" => "lg",
                            "height" => "20px"
                        ),
                        array(
                            "type" => "box",
                            "layout" => "horizontal",
                            "contents" => array(
                                array(
                                    "type" => "text",
                                    "text" => "租車",
                                    "size" => "sm",
                                    "gravity" => "center",
                                    "color" => "#686868",
                                    "weight" => "bold"
                                ),
                                array(
                                    "type" => "box",
                                    "layout" => "vertical",
                                    "contents" => array(
                                        array(
                                            "type" => "filler"
                                        ),
                                        array(
                                            "type" => "box",
                                            "layout" => "vertical",
                                            "contents" => array(),
                                            "cornerRadius" => "30px",
                                            "height" => "12px",
                                            "width" => "12px",
                                            "borderColor" => "#4B656C",
                                            "borderWidth" => "2px",
                                            "backgroundColor" => "#4B656C"
                                        ),
                                        array(
                                            "type" => "filler"
                                        )
                                    ),
                                    "flex" => 0
                                ),
                                array(
                                    "type" => "text",
                                    "text" => "格上租車",
                                    "gravity" => "center",
                                    "flex" => 4,
                                    "size" => "sm",
                                    "color" => "#0FAFBB",
                                    "weight" => "bold"
                                )
                            ),
                            "spacing" => "lg",
                            "cornerRadius" => "30px",
                            "margin" => "none"
                        )
                    )
                )
            ),
            array(
                "type" => "bubble",
                "size" => "mega",
                "header" => array(
                    "type" => "box",
                    "layout" => "vertical",
                    "contents" => array(
                        array(
                            "type" => "box",
                            "layout" => "vertical",
                            "contents" => array(
                                array(
                                    "type" => "text",
                                    "text" => "2023跨年",
                                    "color" => "#D7DBCB",
                                    "size" => "sm",
                                    "weight" => "bold"
                                ),
                                array(
                                    "type" => "text",
                                    "text" => "Day 2 (1/1)",
                                    "color" => "#ffffff",
                                    "size" => "xl",
                                    "flex" => 4,
                                    "weight" => "bold"
                                )
                            )
                        ),
                        array(
                            "type" => "box",
                            "layout" => "vertical",
                            "contents" => array(
                                array(
                                    "type" => "text",
                                    "text" => "嘉義 - 台南",
                                    "color" => "#D7DBCB",
                                    "size" => "sm",
                                    "weight" => "bold"
                                )
                            )
                        )
                    ),
                    "paddingAll" => "20px",
                    "backgroundColor" => "#4B656C",
                    "spacing" => "md",
                    "height" => "110px",
                    "paddingTop" => "22px"
                ),
                "body" => array(
                    "type" => "box",
                    "layout" => "vertical",
                    "contents" => array(
                        array(
                            "type" => "text",
                            "text" => "預估旅行時間：3小時",
                            "color" => "#C5C5C5",
                            "size" => "xs",
                            "weight" => "bold"
                        ),
                        array(
                            "type" => "box",
                            "layout" => "horizontal",
                            "contents" => array(
                                array(
                                    "type" => "text",
                                    "text" => "租車",
                                    "size" => "sm",
                                    "gravity" => "center",
                                    "color" => "#686868",
                                    "weight" => "bold"
                                ),
                                array(
                                    "type" => "box",
                                    "layout" => "vertical",
                                    "contents" => array(
                                        array(
                                            "type" => "filler"
                                        ),
                                        array(
                                            "type" => "box",
                                            "layout" => "vertical",
                                            "contents" => array(),
                                            "cornerRadius" => "30px",
                                            "height" => "12px",
                                            "width" => "12px",
                                            "borderColor" => "#4B656C",
                                            "borderWidth" => "2px",
                                            "backgroundColor" => "#4B656C"
                                        ),
                                        array(
                                            "type" => "filler"
                                        )
                                    ),
                                    "flex" => 0
                                ),
                                array(
                                    "type" => "text",
                                    "text" => "格上租車",
                                    "gravity" => "center",
                                    "flex" => 4,
                                    "size" => "sm",
                                    "color" => "#0FAFBB",
                                    "weight" => "bold"
                                )
                            ),
                            "spacing" => "lg",
                            "cornerRadius" => "30px",
                            "margin" => "xl"
                        ),
                        array(
                            "type" => "box",
                            "layout" => "horizontal",
                            "contents" => array(
                                array(
                                    "type" => "box",
                                    "layout" => "baseline",
                                    "contents" => array(
                                        array(
                                            "type" => "filler"
                                        )
                                    ),
                                    "flex" => 1
                                ),
                                array(
                                    "type" => "box",
                                    "layout" => "vertical",
                                    "contents" => array(
                                        array(
                                            "type" => "box",
                                            "layout" => "horizontal",
                                            "contents" => array(
                                                array(
                                                    "type" => "filler"
                                                ),
                                                array(
                                                    "type" => "box",
                                                    "layout" => "vertical",
                                                    "contents" => array(),
                                                    "width" => "2px",
                                                    "backgroundColor" => "#4B656C"
                                                ),
                                                array(
                                                    "type" => "filler"
                                                )
                                            ),
                                            "flex" => 1
                                        )
                                    ),
                                    "width" => "12px"
                                ),
                                array(
                                    "type" => "text",
                                    "text" => "開車 3小時",
                                    "gravity" => "center",
                                    "flex" => 4,
                                    "size" => "xs",
                                    "color" => "#8c8c8c"
                                )
                            ),
                            "spacing" => "lg",
                            "height" => "20px"
                        ),
                        array(
                            "type" => "box",
                            "layout" => "horizontal",
                            "contents" => array(
                                array(
                                    "type" => "text",
                                    "text" => "租車",
                                    "size" => "sm",
                                    "gravity" => "center",
                                    "color" => "#686868",
                                    "weight" => "bold"
                                ),
                                array(
                                    "type" => "box",
                                    "layout" => "vertical",
                                    "contents" => array(
                                        array(
                                            "type" => "filler"
                                        ),
                                        array(
                                            "type" => "box",
                                            "layout" => "vertical",
                                            "contents" => array(),
                                            "cornerRadius" => "30px",
                                            "height" => "12px",
                                            "width" => "12px",
                                            "borderColor" => "#4B656C",
                                            "borderWidth" => "2px",
                                            "backgroundColor" => "#4B656C"
                                        ),
                                        array(
                                            "type" => "filler"
                                        )
                                    ),
                                    "flex" => 0
                                ),
                                array(
                                    "type" => "text",
                                    "text" => "格上租車",
                                    "gravity" => "center",
                                    "flex" => 4,
                                    "size" => "sm",
                                    "color" => "#0FAFBB",
                                    "weight" => "bold"
                                )
                            ),
                            "spacing" => "lg",
                            "cornerRadius" => "30px",
                            "margin" => "none"
                        ),
                        array(
                            "type" => "box",
                            "layout" => "horizontal",
                            "contents" => array(
                                array(
                                    "type" => "box",
                                    "layout" => "baseline",
                                    "contents" => array(
                                        array(
                                            "type" => "filler"
                                        )
                                    ),
                                    "flex" => 1
                                ),
                                array(
                                    "type" => "box",
                                    "layout" => "vertical",
                                    "contents" => array(
                                        array(
                                            "type" => "box",
                                            "layout" => "horizontal",
                                            "contents" => array(
                                                array(
                                                    "type" => "filler"
                                                ),
                                                array(
                                                    "type" => "box",
                                                    "layout" => "vertical",
                                                    "contents" => array(),
                                                    "width" => "2px",
                                                    "backgroundColor" => "#4B656C"
                                                ),
                                                array(
                                                    "type" => "filler"
                                                )
                                            ),
                                            "flex" => 1
                                        )
                                    ),
                                    "width" => "12px"
                                ),
                                array(
                                    "type" => "text",
                                    "text" => "開車 3小時",
                                    "gravity" => "center",
                                    "flex" => 4,
                                    "size" => "xs",
                                    "color" => "#8c8c8c"
                                )
                            ),
                            "spacing" => "lg",
                            "height" => "20px"
                        ),
                        array(
                            "type" => "box",
                            "layout" => "horizontal",
                            "contents" => array(
                                array(
                                    "type" => "text",
                                    "text" => "租車",
                                    "size" => "sm",
                                    "gravity" => "center",
                                    "color" => "#686868",
                                    "weight" => "bold"
                                ),
                                array(
                                    "type" => "box",
                                    "layout" => "vertical",
                                    "contents" => array(
                                        array(
                                            "type" => "filler"
                                        ),
                                        array(
                                            "type" => "box",
                                            "layout" => "vertical",
                                            "contents" => array(),
                                            "cornerRadius" => "30px",
                                            "height" => "12px",
                                            "width" => "12px",
                                            "borderColor" => "#4B656C",
                                            "borderWidth" => "2px",
                                            "backgroundColor" => "#4B656C"
                                        ),
                                        array(
                                            "type" => "filler"
                                        )
                                    ),
                                    "flex" => 0
                                ),
                                array(
                                    "type" => "text",
                                    "text" => "格上租車",
                                    "gravity" => "center",
                                    "flex" => 4,
                                    "size" => "sm",
                                    "color" => "#0FAFBB",
                                    "weight" => "bold"
                                )
                            ),
                            "spacing" => "lg",
                            "cornerRadius" => "30px",
                            "margin" => "none"
                        )
                    )
                )
            ),
            array(
                "type" => "bubble",
                "size" => "mega",
                "header" => array(
                    "type" => "box",
                    "layout" => "vertical",
                    "contents" => array(
                        array(
                            "type" => "box",
                            "layout" => "vertical",
                            "contents" => array(
                                array(
                                    "type" => "text",
                                    "text" => "2023跨年",
                                    "color" => "#D7DBCB",
                                    "size" => "sm",
                                    "weight" => "bold"
                                ),
                                array(
                                    "type" => "text",
                                    "text" => "Day 3 (1/2)",
                                    "color" => "#ffffff",
                                    "size" => "xl",
                                    "flex" => 4,
                                    "weight" => "bold"
                                )
                            )
                        ),
                        array(
                            "type" => "box",
                            "layout" => "vertical",
                            "contents" => array(
                                array(
                                    "type" => "text",
                                    "text" => "台南 - 台北",
                                    "color" => "#D7DBCB",
                                    "size" => "sm",
                                    "weight" => "bold"
                                )
                            )
                        )
                    ),
                    "paddingAll" => "20px",
                    "backgroundColor" => "#4B656C",
                    "spacing" => "md",
                    "height" => "110px",
                    "paddingTop" => "22px"
                ),
                "body" => array(
                    "type" => "box",
                    "layout" => "vertical",
                    "contents" => array(
                        array(
                            "type" => "text",
                            "text" => "預估旅行時間：3小時",
                            "color" => "#C5C5C5",
                            "size" => "xs",
                            "weight" => "bold"
                        ),
                        array(
                            "type" => "box",
                            "layout" => "horizontal",
                            "contents" => array(
                                array(
                                    "type" => "text",
                                    "text" => "租車",
                                    "size" => "sm",
                                    "gravity" => "center",
                                    "color" => "#686868",
                                    "weight" => "bold"
                                ),
                                array(
                                    "type" => "box",
                                    "layout" => "vertical",
                                    "contents" => array(
                                        array(
                                            "type" => "filler"
                                        ),
                                        array(
                                            "type" => "box",
                                            "layout" => "vertical",
                                            "contents" => array(),
                                            "cornerRadius" => "30px",
                                            "height" => "12px",
                                            "width" => "12px",
                                            "borderColor" => "#4B656C",
                                            "borderWidth" => "2px",
                                            "backgroundColor" => "#4B656C"
                                        ),
                                        array(
                                            "type" => "filler"
                                        )
                                    ),
                                    "flex" => 0
                                ),
                                array(
                                    "type" => "text",
                                    "text" => "格上租車",
                                    "gravity" => "center",
                                    "flex" => 4,
                                    "size" => "sm",
                                    "color" => "#0FAFBB",
                                    "weight" => "bold"
                                )
                            ),
                            "spacing" => "lg",
                            "cornerRadius" => "30px",
                            "margin" => "xl"
                        ),
                        array(
                            "type" => "box",
                            "layout" => "horizontal",
                            "contents" => array(
                                array(
                                    "type" => "box",
                                    "layout" => "baseline",
                                    "contents" => array(
                                        array(
                                            "type" => "filler"
                                        )
                                    ),
                                    "flex" => 1
                                ),
                                array(
                                    "type" => "box",
                                    "layout" => "vertical",
                                    "contents" => array(
                                        array(
                                            "type" => "box",
                                            "layout" => "horizontal",
                                            "contents" => array(
                                                array(
                                                    "type" => "filler"
                                                ),
                                                array(
                                                    "type" => "box",
                                                    "layout" => "vertical",
                                                    "contents" => array(),
                                                    "width" => "2px",
                                                    "backgroundColor" => "#4B656C"
                                                ),
                                                array(
                                                    "type" => "filler"
                                                )
                                            ),
                                            "flex" => 1
                                        )
                                    ),
                                    "width" => "12px"
                                ),
                                array(
                                    "type" => "text",
                                    "text" => "開車 3小時",
                                    "gravity" => "center",
                                    "flex" => 4,
                                    "size" => "xs",
                                    "color" => "#8c8c8c"
                                )
                            ),
                            "spacing" => "lg",
                            "height" => "20px"
                        ),
                        array(
                            "type" => "box",
                            "layout" => "horizontal",
                            "contents" => array(
                                array(
                                    "type" => "text",
                                    "text" => "租車",
                                    "size" => "sm",
                                    "gravity" => "center",
                                    "color" => "#686868",
                                    "weight" => "bold"
                                ),
                                array(
                                    "type" => "box",
                                    "layout" => "vertical",
                                    "contents" => array(
                                        array(
                                            "type" => "filler"
                                        ),
                                        array(
                                            "type" => "box",
                                            "layout" => "vertical",
                                            "contents" => array(),
                                            "cornerRadius" => "30px",
                                            "height" => "12px",
                                            "width" => "12px",
                                            "borderColor" => "#4B656C",
                                            "borderWidth" => "2px",
                                            "backgroundColor" => "#4B656C"
                                        ),
                                        array(
                                            "type" => "filler"
                                        )
                                    ),
                                    "flex" => 0
                                ),
                                array(
                                    "type" => "text",
                                    "text" => "格上租車",
                                    "gravity" => "center",
                                    "flex" => 4,
                                    "size" => "sm",
                                    "color" => "#0FAFBB",
                                    "weight" => "bold"
                                )
                            ),
                            "spacing" => "lg",
                            "cornerRadius" => "30px",
                            "margin" => "none"
                        ),
                        array(
                            "type" => "box",
                            "layout" => "horizontal",
                            "contents" => array(
                                array(
                                    "type" => "box",
                                    "layout" => "baseline",
                                    "contents" => array(
                                        array(
                                            "type" => "filler"
                                        )
                                    ),
                                    "flex" => 1
                                ),
                                array(
                                    "type" => "box",
                                    "layout" => "vertical",
                                    "contents" => array(
                                        array(
                                            "type" => "box",
                                            "layout" => "horizontal",
                                            "contents" => array(
                                                array(
                                                    "type" => "filler"
                                                ),
                                                array(
                                                    "type" => "box",
                                                    "layout" => "vertical",
                                                    "contents" => array(),
                                                    "width" => "2px",
                                                    "backgroundColor" => "#4B656C"
                                                ),
                                                array(
                                                    "type" => "filler"
                                                )
                                            ),
                                            "flex" => 1
                                        )
                                    ),
                                    "width" => "12px"
                                ),
                                array(
                                    "type" => "text",
                                    "text" => "開車 3小時",
                                    "gravity" => "center",
                                    "flex" => 4,
                                    "size" => "xs",
                                    "color" => "#8c8c8c"
                                )
                            ),
                            "spacing" => "lg",
                            "height" => "20px"
                        ),
                        array(
                            "type" => "box",
                            "layout" => "horizontal",
                            "contents" => array(
                                array(
                                    "type" => "text",
                                    "text" => "租車",
                                    "size" => "sm",
                                    "gravity" => "center",
                                    "color" => "#686868",
                                    "weight" => "bold"
                                ),
                                array(
                                    "type" => "box",
                                    "layout" => "vertical",
                                    "contents" => array(
                                        array(
                                            "type" => "filler"
                                        ),
                                        array(
                                            "type" => "box",
                                            "layout" => "vertical",
                                            "contents" => array(),
                                            "cornerRadius" => "30px",
                                            "height" => "12px",
                                            "width" => "12px",
                                            "borderColor" => "#4B656C",
                                            "borderWidth" => "2px",
                                            "backgroundColor" => "#4B656C"
                                        ),
                                        array(
                                            "type" => "filler"
                                        )
                                    ),
                                    "flex" => 0
                                ),
                                array(
                                    "type" => "text",
                                    "text" => "格上租車",
                                    "gravity" => "center",
                                    "flex" => 4,
                                    "size" => "sm",
                                    "color" => "#0FAFBB",
                                    "weight" => "bold"
                                )
                            ),
                            "spacing" => "lg",
                            "cornerRadius" => "30px",
                            "margin" => "none"
                        )
                    )
                )
            )
        )
    );

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
