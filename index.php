<html>
   <head>
      <title>Connecting MySQL Server</title>
   </head>
   <body>
      <?php
         $dbhost = 'remotemysql.com:3306';
         $dbuser = '9b3cxQX9UY';
         $dbpass = '3EdzRNODN8';
         $conn = mysqli_connect($dbhost, $dbuser, $dbpass);
         
         if(! $conn ) {
            die('Could not connect: ' . mysqli_error());
         }
         $sql = 'SELECT * FROM travel20221231';
         mysqli_select_db($conn, '9b3cxQX9UY');
         $retval = mysqli_query( $conn, $sql );
      
         if(!$retval ) {
            die('Could not get data: ' . mysqli_error());
         }

         $data = $row = mysqli_fetch_array($retval);
         $type = "travel";
      
         switch ($type) {
            case 'travel':
               echo "switch_travel<br>";
               $bubble = travel($data);
               //print_r($bubble);
               echo json_encode($bubble);
               break;
         }
         
         /*
         while($row = mysqli_fetch_array($retval)) {
            echo "day :{$row['day']}  <br> ".
             "num: {$row['num']} <br> ".
              "label: {$row['label']} <br> ".
            "name : {$row['name']} <br> ".
            "--------------------------------<br>";
         }
         */
         //mysqli_close($conn);

         function travel($data)
         {
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
             ),
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
                     "type" => "box",
                     "layout" => "horizontal",
                     "contents" => [$placeBox,$fillerBox],
                     "spacing" => "lg",
                     "cornerRadius" => "30px",
                     "margin" => "xl",
                  ],
               ],
            ];

            return $bubble;
         }
         
      ?>
   </body>
</html>
