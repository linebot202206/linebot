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

         
      ?>
   </body>
</html>
