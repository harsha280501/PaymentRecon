(function($) {
  'use strict';
  $(function() {
    $('[data-toggle="offcanvas"]').on("click", function() {
      $('.sidebar-offcanvas').toggleClass('active')
      $('.brand-logo-mini').toggleClass('active')
      $('.main-panel').toggleClass('active')
      $('#mobile-header').toggleClass('active')

    });
  });
})(jQuery);

