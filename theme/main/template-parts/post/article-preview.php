<?php

  //
  //  Constructing layers - ORDER MATTERS
  //

  $layer_opts = [
    'excerpt_trim' => 30,
  ];

  $layer_image = ['image' => true];
  $layer_content = [
    'category' => true,
    'pubdate' => false,
    'title' => true,
    'excerpt' => true,
  ];

  // ORDER MATTERS!!
  $layers = [
    'image' => $layer_image,
    'content' => $layer_content,
  ];

  // passed using hm_get_template_part
  // e.g. hm_get_template_part('path', ['option' => 'value']);
  if (isset($template_args)){
    //
    // apply args
    //
    if (isset($template_args['opts'])){
      foreach ($template_args['opts'] as $name => $val){
        $layer_opts[$name] = $val;
      }
    }

    //
    // pre-assembled types
    //
    $type = $template_args['type'];
    if (isset($type)){
      switch ($type) {
        case 'hero-top':
        case 'flip-image':
          # swap image to after
          $layers = array_slice($layers, 1);
          $layers['image'] = $layer_image;
          break;

        case 'image-main':
          # no category & excerpt
          $layers['content']['category'] = false;
          $layers['content']['excerpt'] = false;
          break;

        case 'hero-quick':
        case 'plain-text':
          # no image & category
          $layers = array_slice($layers, 1);
          $layers['content']['category'] = false;
          // $layers['content']['excerpt'] = false;
          break;

        case 'search':
        case 'archive':
          # no image, add date
          $layers = array_slice($layers, 1);
          $layers['content']['pubdate'] = true;
          break;

        case 'category-all':
          # no category, add date, image later
          $layers = array_slice($layers, 1);
          $layers['content']['category'] = false;
          $layers['content']['pubdate'] = true;
          $layers['image'] = $layer_image;

        case 'no-category':
          $layers['content']['category'] = false;
          break;

        case 'no-excerpt':
          $layers['content']['excerpt'] = false;
          break;

        case 'no-image':
          $layers = array_slice($layers, 1);
          break;

        case 'no-image-no-excerpt':
          $layers = array_slice($layers, 1);
          $layers['content']['excerpt'] = false;
          break;

        default: break;
      }
    }
  }

  // var_dump($layers);

  //
  //  Propagating layers - ORDER MATTERS
  //
  $is_enabled = [ // mostly just for readability
    // enabled AND thumbnail url is valid
    'image' => $layers['image']['image'] && get_the_post_thumbnail_url(),
    'content' => [
      'category' => $layers['content']['category'],
      'pubdate' => $layers['content']['pubdate'],
      'title' => $layers['content']['title'],
      'excerpt' => $layers['content']['excerpt'],
    ],
  ];

  $prop_article = [
    'class' => 'article'.($is_enabled['image'] ? '' : ' no-image'),
  ];

  $prop_image = [
    'class' => 'article__image',
    'url' => get_the_permalink(),
    'style' => 'background-image:url('.get_the_post_thumbnail_url().')',
  ];

  $prop_content = [
    'class' => 'article__content',
    'children' => [
      'category' => [
        'class' => 'article__category',
        'value' => get_the_category()[0]->name, // [0] for safety
      ],
      'pubdate' => [
        'class' => 'article__pubdate',
        'value' => get_the_date('F j, Y'), # e.g. January 1, 2020
      ],
      'title' => [
        'class' => 'article__title',
        'value' => '<a href="'.get_the_permalink().'">'.get_the_title().'</a>',
      ],
      'excerpt' => [
        'class' => 'article__excerpt',
        'value' => wp_trim_words(get_the_excerpt(), $layer_opts['excerpt_trim']),
      ],
    ],
  ];

  // order doesn't matter
  $props = [
    'image' => $prop_image,
    'content' => $prop_content,
  ];

  $propagated = '';
  foreach ($layers as $root => $layer){
    $content = $props[$root];

    if ($root == 'image' && $is_enabled['image']){
      $propagated = $propagated
      .'<a class="'.$content['class'].'"'
      .' href="'.$content['url'].'"'
      .' style="'.$content['style'].'">'
      .'</a>';
    } else if ($root == 'content'){
      $propagated = $propagated.'<div class="'.$content['class'].'">';

      // loop content children
      foreach ($content['children'] as $name => $child){
        if (!$is_enabled[$root][$name]) continue;
        $propagated = $propagated.'<div class="'.$child['class'].'">'.$child['value'].'</div>';
      }

      $propagated = $propagated.'</div>';
    }
  }

?>

<article class="<?php echo $prop_article['class']; ?>">
  <div class="article__wrapper">
    <?php echo $propagated; ?>
  </div>
</article>
