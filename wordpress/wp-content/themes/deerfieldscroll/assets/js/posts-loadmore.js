'use strict';
(function($){
  console.log('post loadmore script loaded');

  // postLoadmoreParams.offset = 11;

  $(document).on('click.catLM', '#category-loadmore', function(){
    console.log('loadmore clicked');
    const
      $btn = $(this),
      numberposts = 8,
      data = {
        action: 'post_loadmore',
        numberposts: numberposts,
        // that's how we get params from wp_localize_script() function
        // page: postLoadmoreParams.current_page,
        category: wpPageCategory,
        offset: postLoadmoreParams.offset,
      };

    const promise = $.ajax({ // you can also use $.post here
      url: postLoadmoreParams.ajaxurl, // AJAX handler
      data: data,
      type: 'POST',
    });

    promise.complete = function(){
      // console.log('loading request sent');
      $btn.text('Loading...'); // change the button text, you can also add a preloader image
    };

    promise.done(data => {
      // console.log('load success - printing data below');
      // console.log(data);
      if (data.posts && data.posts.length > 0){
        $btn.text('Load More Articles'); // insert new posts
        postLoadmoreParams.offset = Number(postLoadmoreParams.offset) + numberposts;

        data.posts.forEach(postWrapped => {
          $('#category__articles-long').append(postWrapped);
        });

        // if last page, remove the button
        // if (postLoadmoreParams.current_page == postLoadmoreParams.max_page) $btn.remove();
        // you can also fire the "post-load" event here if you use a plugin that requires it
        // $( document.body ).trigger( 'post-load' );
      } else {
        $btn.remove(); // if no data, remove the button as well
      }
    });
  });
})(jQuery);
