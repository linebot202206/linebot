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
         echo 'Connected successfully2';
         echo 'start';
         $sql = 'SELECT * FROM travel20221231';
         mysqli_select_db('9b3cxQX9UY');
         $retval = mysqli_query( $sql, $conn );
      
         if(! $retval ) {
            die('Could not get data: ' . mysqli_error());
         }
      
         while($row = mysqli_fetch_array($retval, mysqli_ASSOC)) {
            echo "day :{$row['v']}  <br> ".
             "num: {$row['num']} <br> ".
              "label: {$row['label']} <br> ".
            "name : {$row['name']} <br> ".
            "--------------------------------<br>";
         } 
         //mysqli_close($conn);
      ?>
   </body>
</html>
