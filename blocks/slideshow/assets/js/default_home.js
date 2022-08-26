jQuery(document).ready(function($) {
        var owl = $('.owl-carousel');
          owl.owlCarousel({
            margin: 10,
            nav: true,
            loop: true,
            responsive: {
              0: {
                items: 1
              },
              600: {
                items: 3
              },
              1000: {
                items: 1
              }
            }
          })
        $('.fadeOut').owlCarousel({
            items: 1,
            animateOut: 'fadeOut',
            loop: true,
            margin: 10,
        });
        $('.custom1').owlCarousel({
            animateOut: 'slideOutDown',
            animateIn: 'flipInX',
            items: 1,
            margin: 30,
            stagePadding: 30,
            smartSpeed: 450
        });
    });