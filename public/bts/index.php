<?php

  require_once '../../private/access/control.php';

?>
<html lang="en-US">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="parkjongwon.com" />
    <title>Behind The Scroll - DA Student Newspaper</title>
    <!-- <link rel="canonical" href="https://thescroll.com/" /> -->
    <link rel="stylesheet" href="../lib/style/dist/normalize.min.css" />
    <link rel="stylesheet" href="../lib/style/dist/universal.min.css<?php echo "?v=".filemtime("../lib/style/dist/universal.min.css"); ?>" />
    <link rel="stylesheet" href="../lib/style/dist/bts/article.min.css<?php echo "?v=".filemtime("../lib/style/dist/bts/article.min.css"); ?>" />
    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans:300,400,500,700|Open+Sans:300,400,700,800&display=swap" rel="stylesheet">
    <noscript>
      You need to enable JavaScript to run this app.
    </noscript>
  </head>

  <body>

    <h1>Editors Home</h1>

    <h2>View/New/Edit Article</h2>
    <a href="./article.php">View/Edit Article</a>
    <a href="./article.php?action=new">New Article</a>

    <h2>Manage Articles</h2>
    <a href="./articles.php">Articles</a>

    <h2>Human Resources</h2>
    <a href="./humanresources.php"></a>

    <h2>Settings</h2>
    <a href="./settings.php"></a>

    <a href="../index.php">Logout</a>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.slim.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/editorjs@latest"></script>
  </body>
</html>
