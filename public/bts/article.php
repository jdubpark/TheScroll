<?php

  require_once '../../private/access/control.php';

  // $articleID = $_GET['id'];
  // if (!isset($articleID) || ntype_digit($articleID)){
  //   header('Location: ./index.php');
  //   exit;
  // }

  $allowedActions = ['new', 'edit'];
  if (isset($_GET['action']) && !in_array($_GET['action'], $allowedActions)){
    // header("Location: ./article.php?id=$articleID");
    header('Location: ./index.php');
    exit;
  }

?>
<!DOCTYPE html>
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

    <?php
      if (isset($_GET['action'])):
        $gAction = $_GET['action'];
        if ($gAction === 'new'):
    ?>
    <textarea id="classic">Hello, World!</textarea>
    <!-- <script src="https://cdn.tiny.cloud/1/6fxsm44tquczno84cpsr0zvbev0fid3vohn11jc9lt3p4ltd/tinymce/5/tinymce.min.js"></script>
    <script>
    var demoBaseConfig = {
      selector: "textarea#classic",
      width: 755,
      height: 500,
      resize: false,
      autosave_ask_before_unload: false,
      powerpaste_allow_local_images: true,
      plugins: [
        "advlist anchor autolink fullscreen help image imagetools",
        " lists link media noneditable powerpaste preview",
        " searchreplace table template tinymcespellchecker visualblocks wordcount"
      ],
      toolbar:
        "undo redo | bold italic | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist | link image",
      content_css: [
        "//fonts.googleapis.com/css?family=Lato:300,300i,400,400i",
        "//www.tiny.cloud/css/content-standard.min.css"
      ],
      spellchecker_dialog: true,
      spellchecker_whitelist: ['Ephox', 'Moxiecode'],
    };

    tinymce.init(demoBaseConfig);

    </script> -->
    <?php elseif ($gAction === 'edit'): ?>
    <?php else: ?>
    <?php endif; endif; ?>

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

      // const axios;

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
