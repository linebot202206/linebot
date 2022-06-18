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
    //header("Location: https://www.google.com.tw/maps/place/%E6%A2%85%E5%B1%B1%E5%AF%8C%E9%87%8C%E5%B1%85/@23.552816,120.5509503,17z/data=!3m1!4b1!4m5!3m4!1s0x346ec0f4f20d8a8b:0x34e2ec79b9cf71ca!8m2!3d23.5528016!4d120.5531011?hl=zh-TW&authuser=0"); 
    //exit;
    ?>
  </body>
</html>