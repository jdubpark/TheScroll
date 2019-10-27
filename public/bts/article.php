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

  <body style="max-width:1000px;margin:0 auto;padding:20px;">

    <h1>Article</h1>

    <h2>View an article</h2>

    <h2>New an article</h2>

    <h2>Edit an article</h2>

    <?php
      if (isset($_GET['action'])):
        $gAction = $_GET['action'];
        if ($gAction === 'new'):
    ?>
    <div id="article-submit-btn" style="cursor:pointer;">Submit</div>
    <input id="article-title" type="text" placeholder="Artitle Title" value="Random article title <?php echo rand(1, 100000); ?>" />
    <input id="article-display-author" type="text" placeholder="Author Display Name" value="John Smith '21" />
    <select id="article-section">
      <option value="1">Opinion</option>
    </select>
    <input id="article-display-datetime" type="datetime-local" value="2019-12-25T12:25" />
    <textarea id="article-summary" placeholder="Article Summary">Just some random summary!</textarea>
    <input id="article-cover-image" type="text" value="https://images.pexels.com/photos/2110937/pexels-photo-2110937.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260" />
    <input id="article-cover-video" type="text" />
    <input id="article-cover-image-caption" type="text" value="some caption for the cover image" />
    <input id="article-cover-video-caption" type="text" value="some caption for the cover video" />
    <textarea id="article-editor">Hello, World!</textarea>
    <script src="https://cdn.tiny.cloud/1/6fxsm44tquczno84cpsr0zvbev0fid3vohn11jc9lt3p4ltd/tinymce/5/tinymce.min.js"></script>
    <script>
    var demoBaseConfig = {
      selector: "textarea#article-editor",
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
      image_caption: true,
      spellchecker_dialog: true,
      spellchecker_whitelist: ['Ephox', 'Moxiecode'],
    };

    tinymce.init(demoBaseConfig);

    </script>
    <?php elseif ($gAction === 'edit'): ?>
    <?php else: ?>
    <?php endif; endif; ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.slim.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
    (function($){
      $('#article-submit-btn').on('click', function(){
        const
          title = $('#article-title').val();
          dAuthor = $('#article-display-author').val();
          section = $('#article-section').val(),
          pubtime = $('#article-display-datetime').val(),
          summary = $('#article-summary').val(),
          content = tinymce.get('article-editor').getContent(),
          cover = {
            image: $('#article-cover-image').val(),
            image_caption: $('#article-cover-image-caption').val(),
            video: $('#article-cover-video').val(),
            video_caption: $('#article-cover-video-caption').val(),
          };

        const postData = {
          req: 'new_article',
          payload: {title, section: [section], pubtime, summary, content, cover, dAuthor},
        };

        console.log(postData);

        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        axios.post('../actions/article.php', postData)
          .then(res => {
            console.log(res);
          })
          .catch(err => {
            console.error(err);
          });
      });
    })(jQuery);
    </script>
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
