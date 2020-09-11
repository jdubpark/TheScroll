'use strict';

(function($){
  console.log('universal script loaded');

  $(document).on('click.menu-trigger', '.site-nav-menu-trigger', function(){
    const $m = $('#site-nav-main'), $t = $('.site-nav-menu-trigger');
    if ($m.hasClass('full')){
      $t.removeClass('active');
      $m.removeClass('full');
    } else {
      $t.addClass('active');
      $m.addClass('full');
    }
  });

  $(document).on('click.search-trigger', '.site-nav-search-trigger', function(){
    const $m = $('#site-nav-main'), $t = $('.site-nav-search-trigger');
    if ($m.hasClass('search')){
      $t.removeClass('active');
      $m.removeClass('search');
    } else {
      $t.addClass('active');
      $m.addClass('search');
    }
  });
})(jQuery);
