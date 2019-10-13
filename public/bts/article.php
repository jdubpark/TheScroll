<?php

  require_once '../../private/access/control.php';

  $articleID = $_GET['id'];
  if (!isset($articleID) || ntype_digit($articleID)){
    header('Location: ./index.php');
    exit;
  }

  $allowedActions = ['new', 'edit'];
  if (isset($_GET['action']) && !array_include($allowedActions, $_GET['action'])){
    header("Location: ./article.php?id=$articleID");
    exit;
  }

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

    <h1>Article</h1>

    <h2>View an article</h2>

    <h2>New an article</h2>

    <h2>Edit an article</h2>

    <?php if (isset($_GET['action'])){ $gAction = $_GET['action']; ?>
    <?php if ($gAction === 'new'){ ?>
    <?php } else if ($gAction === 'edit'){ ?>
    <?php } ?>
    <?php } else { ?>
    <?php } ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.slim.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/editorjs@latest"></script>
    <script>
    (function($){
      const
        id = 0, // get uri id
        action = ''; // get uri action

      // validate id
      // if id contains non-number, redirect

      const axios;

      // if uri action
      if (action === 'new'){
        // config axios to new
        // no fetch for article
      } else if (action === 'edit'){
        // config axios to edit
        // fetch data with raw json syntax
      } else {
        // config axios to preview
        // fetch data normally
      }

      // axios post

    })(jQuery);
    </script>
  </body>
</html>
