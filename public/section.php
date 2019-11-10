<!DOCTYPE html>
<html lang="en-US">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="parkjongwon.com" />
    <title>The Scroll - DA Student Newspaper</title>
    <!-- <link rel="canonical" href="https://thescroll.com/" /> -->
    <link rel="stylesheet" href="./lib/style/dist/normalize.min.css" />
    <link rel="stylesheet" href="./lib/style/dist/universal.min.css<?php echo "?v=".filemtime("./lib/style/dist/universal.min.css"); ?>" />
    <link rel="stylesheet" href="./lib/style/dist/section.min.css<?php echo "?v=".filemtime("./lib/style/dist/section.min.css"); ?>" />
    <link href="https://fonts.googleapis.com/css?family=Cormorant+Garamond:600|Spectral:400,400i,700,700i|Libre+Baskerville:400,400i&display=swap" rel="stylesheet">
    <!-- Gentium+Basic:400 -->
    <noscript>
      You need to enable JavaScript to run this app.
    </noscript>
  </head>

  <body>

    <div id="layout">
      <div id="header" class="layout-container layout-header">
        <div id="site-nav" class="header-parent">
          <div id="header-mini" class="header-row header-mini">
            <div class="header-container header-container-mini">
              <div class="header-wrapper header-wrapper-top">
                <div class="header-top-col mini header-top-items header-top-col-left">
                  <div class="header-top-item mini header-top-menu-trigger">
                    <span class="one"></span>
                    <span class="two"></span>
                    <span class="three"></span>
                  </div>
                  <div class="header-top-item mini header-top-search-trigger">
                    <img src="./lib/svg/icon-search.svg" title="Search" />
                  </div>
                </div>
                <div class="header-top-col mini header-top-col-center"><i>Be Worthy of Your Heritage</i></div>
                <div class="header-top-col mini header-top-col-right">
                  <div class="header-mini-actions">
                    <div class="header-mini-action-btn header-mini-action-subscribe"><a>Subscribe</a></div>
                    <div class="header-mini-action-btn"><a href="./login.php">Login</a></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div id="header-top" class="header-row">
            <div class="header-container header-container-top">
              <div class="header-wrapper header-wrapper-top">
                <div class="header-top-col header-top-col-left"></div>
                <div class="header-top-col header-top-col-center">
                  <a class="header-top-logo" href="./" title="Go to Deerfield Scroll homepage"></a>
                  <div class="header-top-info">
                    <div class="header-top-info-item"><?php echo date('l, M jS, Y'); ?></div>
                    <div class="header-top-info-item">Vol. XCVII</div>
                    <div class="header-top-info-item"><a>Last Print Edition</a></div>
                  </div>
                </div>
                <div class="header-top-col header-top-col-right"></div>
              </div>
            </div>
          </div>
          <div id="header-nav" class="header-row header-nav">
            <div class="header-nav-container">
              <div class="header-nav-list">
                <div class="header-nav-item"><a href="./">Home</a></div>
                <div class="header-nav-item"><a href="./section.php">News</a></div>
                <div class="header-nav-item"><a href="./section.php">Features</a></div>
                <div class="header-nav-item"><a href="./section.php">Opinion</a></div>
                <div class="header-nav-item"><a href="./section.php">Editorial</a></div>
                <div class="header-nav-item"><a href="./section.php">Arts</a></div>
                <div class="header-nav-item"><a href="./section.php">Sports</a></div>
                <div class="header-nav-item"><a href="./section.php">Buzz</a></div>
              </div>
              <!-- <div class="header-nav-vd"></div> -->
              <div class="header-nav-list">
                <div class="header-nav-item"><a href="./section.php">Archives</a></div>
                <div class="header-nav-item"><a href="./section.php">About</a></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="content" class="layout-container layout-content layout-blocks">
        <div id="section" class="layout-section">
          <div id="section-header" class="section-header">
            <div class="section-title">Opinion</div>
          </div>
          <div id="section-content" class="section-content">
            <div class="layout-row">
              <div class="layout-block layout-block-s1 layout-8-12">
                <div class="article article-s1a">
                  <div class="article-s1a-cover-image"><img src="./lib/img/random-img.jpg" /></div>
                  <div class="article-s1a-content">
                    <div class="article-s1a-section">Opinion</div>
                    <div class="article-s1a-headline">Celebrating Margarita Curtis, 55th HOS</div>
                    <div class="article-s1a-summary">For the past thirteen years, Margarita Curtis, Deerfield’s first female Head of School, has left an unforgettable legacy within the Deerfield community. Dr. Curtis’ belief in the importance of listening is seen</div>
                  </div>
                </div>
              </div>
              <div class="layout-block layout-block-s1 layout-4-12">
                <div class="article article-s1b">
                  <div class="article-s1b-cover-image"><img src="./lib/img/random-img.jpg" /></div>
                  <div class="article-s1b-content">
                    <div class="article-s1b-section">Opinion</div>
                    <div class="article-s1b-headline">Celebrating Margarita Curtis, 55th HOS</div>
                    <div class="article-s1b-summary">For the past thirteen years, Margarita Curtis, Deerfield’s first female Head of School, has left an unforgettable legacy within the Deerfield community. Dr. Curtis’ belief in the importance of listening is seen</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="footer" class="layout-container layout-home">

      </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.slim.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
    axios.get('http://localhost:1289/api/teasers/section/1')
      .then(res => {
        console.log(res);
      })
      .catch(err => {
        console.error(err);
      })
    </script>
	</body>
</html>
