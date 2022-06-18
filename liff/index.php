<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
  </head>
  <body>
    <?php
    $urlData = urldecode($_SERVER['QUERY_STRING']);
    $url = substr(explode("?",$urlData)[1], 4);
    echo $url;
    //header("Location: $url");
    exit;
    ?>
  </body>
</html>