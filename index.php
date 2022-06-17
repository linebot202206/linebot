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
         echo 'Connected successfully';
         
         $sql = 'SELECT * FROM travel20221231';
         mysqli_select_db('9b3cxQX9UY');
         $retval = mysqli_query( $sql, $conn );
         print_r("123===".$retval);
         echo 'done';
         //mysqli_close($conn);
      ?>
   </body>
</html>
