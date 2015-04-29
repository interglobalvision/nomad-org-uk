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

  captionHeight = $('#single-slider-text').outerHeight(),

  overlay = $('#overlay'),
  overlayGallery = $('#overlay-gallery');

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

function slickLazyLoad(selector) {
  $(selector).each(function() {
    var $this = $(this);
    var data = $this.data();
    var windowWidth = $(window).width();

    if (retina) {
      if (windowWidth > (largeImageThreshold*1.5)) {
        $this.attr('data-lazy', data.largest);
      } else {
        $this.attr('data-lazy', data.large);
      }
    } else if (windowWidth > largestImageThreshold) {
      $this.attr('data-lazy', data.largest);
    } else if (windowWidth > largeImageThreshold) {
      $this.attr('data-lazy', data.large);
    } else {
      $this.attr('data-lazy', data.basic);
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

overlayGallery.on({
  init: function(event, slick){
    Slick.resizeImages();
  }
});

var Slick = {
  init: function() {
    var _this = this;
    overlayGallery.on({
      init: function(event, slick){
        //var currentSlideIndex = $('.slick-active').attr('data-slick-index');
        // set caption
        //_this.replaceCaption(currentSlideIndex);

        // set length for n of * in captions
        //$('#slick-length').html($('.js-slick-item').length-2);

        // fix images for window height
        Slick.resizeImages();

        // fade in when ready
        $('#single-slider').css( 'opacity' , 1 );
        //$('#single-slider-text').css( 'opacity' , 1 );
      }/*,
      afterChange: function(event, slick, currentSlide, nextSlide){
        // set caption
        //_this.replaceCaption(currentSlide);

        // set active index in human readable form
        //$('#slick-current-index').html(currentSlide+1);
      }*/
    }).slick({
      prevArrow: $('#overlay-previous'),
      nextArrow: $('#overlay-next'),
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

// SINGLE PROJECT
  $('.js-load-gallery').on('click', function() {
    var target = '#overlay-gallery-' + $(this).data('gallery');
    var insert = $(target).find('.js-slick-item');

    insert.clone().appendTo('#overlay-gallery');

    lazyLoadImages('#overlay-gallery .slider-img');

    overlay.show();

    Slick.init();

    $('body').scrollTop(0);
  });

  $('#overlay-close').on('click', function() {
    overlay.hide();
    overlayGallery.slick('unslick').html('');
  });

  $('.js-project-copy-link').on('click', function() {
    var target = '#' + $(this).data('target-id');
    $(target).ScrollTo();
  });


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



  $(window).on('resize', function() {
    Slick.resizeImages();
  });

});