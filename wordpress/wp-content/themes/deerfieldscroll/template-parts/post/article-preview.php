<?php

  //
  //  Constructing layers
  //

  $layer_opts = [
    'excerpt_trim' => 30,
  ];

  $layer_image = ['image' => true];
  $layer_content = [
    'category' => true,
    'title' => true,
    'excerpt' => true,
  ];

  // order matters
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
          $layers = array_slice($layers, 1);
          $layers['image'] = $layer_image;
          break;

        case 'hero-quick':
          $layers = array_slice($layers, 1);
          $layers['content']['category'] = false;
          // $layers['content']['excerpt'] = false;
          break;

        case 'image-top-no-excerpt':
          $layers['content']['excerpt'] = false;
          break;

        default: break;
      }
    }
  }

  // var_dump($layers);

  //
  //  Propagating layers
  //
  $is_enabled = [ // mostly just for readability
    // enabled AND thumbnail url is valid
    'image' => $layers['image']['image'] && get_the_post_thumbnail_url(),
    'content' => [
      'category' => $layers['content']['category'],
      'title' => $layers['content']['title'],
      'excerpt' => $layers['content']['excerpt'],
    ],
  ];

  $prop_article = [
    'class' => 'article'.($is_enabled['image'] ? '' : ' no-image'),
  ];

  $prop_image = [
    'class' => 'article__image',
    'href' => get_the_permalink(),
    'style' => 'background-image:url('.get_the_post_thumbnail_url().')',
  ];

  $prop_content = [
    'class' => 'article__content',
    'children' => [
      'category' => [
        'class' => 'article__category',
        'value' => get_the_category()[0]->name,
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
      $propagated = $propagated.'<a class="'.$content['class'].'"'
        .' href="'.$content['href'].'"'
        .' style="'.$content['style'].'"'
        .'></a>';
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
