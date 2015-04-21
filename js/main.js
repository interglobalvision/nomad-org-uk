/* jshint browser: true, devel: true, indent: 2, curly: true, eqeqeq: true, futurehostile: true, latedef: true, undef: true, unused: true */
/* global $, jQuery, document, Modernizr */

function l(data) {
  'use strict';
  console.log(data);
}

// VARS

var retina = Modernizr.highresdisplay,
  largeImageThreshold = 800,
  largestImageThreshold = 1400,

  margin = 35,

  windowHeight = $(window).outerHeight(),

  captionHeight = $('#single-slider-text').outerHeight();

// FUNCTIONS

  // LAZY IMAGES

function lazyLoadImages(selector) {
  $(selector).each(function() {
    var $this = $(this);
    var data = $this.data();
    var windowWidth = $(window).width();

    if (retina) {
      if (windowWidth > (largeImageThreshold*1.5)) {
        $this.attr('src', data.largest);
      } else {
        $this.attr('src', data.large);
      }
    } else if (windowWidth > largestImageThreshold) {
      $this.attr('src', data.largest);
    } else if (windowWidth > largeImageThreshold) {
      $this.attr('src', data.large);
    } else {
      $this.attr('src', data.basic);
    }
  });
}

  // LAYOUT

$(window).resize(function() {
  windowHeight = $(window).outerHeight();
});

function singleLayout() {
  $('#single-slider').css({
    'padding-top': margin,
    'height': (windowHeight - captionHeight)
  });
}

if ($('body').hasClass('single')) {
  singleLayout();
}

  // RESIZE

function debounce(func, wait, immediate) {
  var timeout;
  return function() {
    var context = this, args = arguments;
    var later = function() {
      timeout = null;
      if (!immediate) {
        func.apply(context, args);
      }
    };
    var callNow = immediate && !timeout;
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
    if (callNow) {
      func.apply(context, args);
    }
  };
}

  // SLICK

var Slick = {
  init: function() {
    var _this = this;
    $('.js-slick-container').on({
      init: function(event, slick){
        var currentSlideIndex = $('.slick-active').attr('data-slick-index');
        // set caption
        _this.replaceCaption(currentSlideIndex);

        // set length for n of * in captions
        $('#slick-length').html($('.js-slick-item').length-2);

        // lazy load images for screen resolution
        lazyLoadImages('.slider-img');

        // fix images for window height
        _this.resizeImages();

        // fade in when ready
        $('#single-slider').css( 'opacity' , 1 );
        $('#single-slider-text').css( 'opacity' , 1 );
      },
      afterChange: function(event, slick, currentSlide, nextSlide){
        // set caption
        _this.replaceCaption(currentSlide);

        // set active index in human readable form
        $('#slick-current-index').html(currentSlide+1);
      }
    })
    .slick({
      prevArrow: '#slick-prev',
      nextArrow: '#slick-next',
    });

    $('.js-slick-item').on('click', function() {
      $('.js-slick-container').slick('slickNext');
    });
  },

  replaceCaption: function(currentSlide) {
    var caption = $('[data-slick-index="' + currentSlide + '"]').data('caption');
    if (! caption || caption === undefined || caption === null) {
      $('#slick-caption').html(' ');
    } else {
      $('#slick-caption').html(caption);
    }
  },

  resizeImages: function() {
    $('.js-slick-item img').css( 'max-height' , ( windowHeight - captionHeight - margin ) );
  }
};


jQuery(document).ready(function () {
  'use strict';
  l('Hola Globie');

// PACKERY
  if ( $('.js-packery-container').length ) {
    $('.js-packery-container').imagesLoaded( function() {
      $('.js-packery-container').packery({
        itemSelector: '.js-packery-item',
        transitionDuration: '0s',
        percentPosition: true
      }).css({
        'opacity': 1
      });
    });
  }

// SLICK
/*
  var resizeFunction = debounce(function() {
    resizeImages();
  }, 30);
*/

  if ( $('.js-slick-item').length ) {
    Slick.init();
  }

  $(window).on('resize', function() {
    Slick.resizeImages();
  });

});