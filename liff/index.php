<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
  </head>
  <body>
    <?php
    $urlData = urldecode($_SERVER['QUERY_STRING']);
    $url = explode("=",explode("?",$urlData)[1])[1];
    echo $url;
    //header("Location: $url"); 
    //exit;
    ?>
  </body>
</html>