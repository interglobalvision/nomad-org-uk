/* jshint browser: true, devel: true, indent: 2, curly: true, eqeqeq: true, futurehostile: true, latedef: true, undef: true, unused: true */
/* global $, jQuery, document, Modernizr */

function l(data) {
  'use strict';
  console.log(data);
}

// VARS

var retina = Modernizr.highresdisplay,
  largeImageThreshold = 1100,
  largerImageThreshold = 1600,
  largestImageThreshold = 2000,

  margin = 35,
  slideMargin = 80,

  basicAnimationSpeed = 700,

  html = $('html'),
  mainContent = $('#main-content'),

  windowHeight = $(window).outerHeight(),
  windowWidth = $(window).width(),

  captionHeight = $('#single-slider-text').outerHeight(),
  footerHeight = $('#footer').outerHeight(true),
  headerHeight = $('#header').outerHeight(true),
  footerOffset = footerHeight + headerHeight + margin,

  galleryOverlay = $('#gallery-overlay'),
  videoOverlay = $('#video-overlay'),

  slickItemWidth,
  slickItemPadding,

  videoWidth,
  videoHeight,
  videoPadding,
  videoAreaHeight,
  videoAreaWidth;

// FUNCTIONS

  // LAZY IMAGES

function lazyLoadImages(selector) {
  var smallRetina = (largeImageThreshold / 2)

  $(selector).each(function() {
    var $this = $(this);
    var data = $this.data();

    if (retina) {
      if (windowWidth > largerImageThreshold) {
        $this.attr('src', data.largest);
      } if (windowWidth < smallRetina) {
        $this.attr('src', data.basic);
      } else {
        $this.attr('src', data.large);
      }

    } else if (windowWidth > largestImageThreshold) {
      $this.attr('src', data.largest);
    } else if (windowWidth > largerImageThreshold) {
      $this.attr('src', data.larger);
    } else if (windowWidth > largeImageThreshold) {
      $this.attr('src', data.large);
    } else {
      $this.attr('src', data.basic);
    }

    $this.imagesLoaded(function() {
      this.images[0].img.className += ' img-loaded';

      if ( $('.js-packery-container').length ) {
        $('.js-packery-container').packery();
      }
    });

  });
}

  // LAYOUT

$(window).resize(function() {
  windowHeight = $(window).outerHeight();
  windowWidth = $(window).width();
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

  // SLICK

var Slick = {
  init: function() {
    var _this = this;
    $('.js-slick-container').on({
      init: function(event, slick){
        //var currentSlideIndex = $('.slick-active').attr('data-slick-index');
        // set caption
        _this.replaceCaptions(0);

        // set length for n of * in captions
        //$('#slick-length').html($('.js-slick-item').length-2);

        // fix images for window height
        _this.resizeImages();

        // fade in when ready
        $('#single-slider').css( 'opacity' , 1 );
        //$('#single-slider-text').css( 'opacity' , 1 );
      },
      afterChange: function(event, slick, currentSlide, nextSlide){
        // set caption
        _this.replaceCaptions(currentSlide);

        // set active index in human readable form
        //$('#slick-current-index').html(currentSlide+1);
      }
    }).slick({
      prevArrow: $('#gallery-overlay-previous'),
      nextArrow: $('#gallery-overlay-next'),
    });

    $('.js-slick-item').on('click', function() {
      $('.js-slick-container').slick('slickNext');
    });
  },

  replaceCaptions: function(currentSlide) {
    var data = $('[data-slick-index="' + currentSlide + '"]').data();
    var caption;
    if (data.caption !== undefined || data.caption !== null) {
      caption = data.caption;
    }
    var title = data.title;

    if (! caption || caption === undefined || caption === null) {
      $('#gallery-overlay-caption').html(' ');
    } else {
      $('#gallery-overlay-caption').html(', ' + caption);
    }

    if (! title || title === undefined || title === null) {
      $('#gallery-overlay-title').html(' ');
    } else {
      $('#gallery-overlay-title').html(title);
    }

  },

  resizeImages: function() {
    slickItemWidth = $('#gallery-overlay .js-slick-item:first-of-type').width();
    slickItemPadding = $('#gallery-overlay .js-slick-item:first-of-type').css('padding');
    $('.js-slick-item img').css({
      'max-height' : ( windowHeight - captionHeight - ( slideMargin * 2 ) ),
      'max-width' : ( slickItemWidth - ( slickItemPadding * 2 ) ),
    });
  },
};


jQuery(document).ready(function () {
  'use strict';

// MENU

  $('#scroll-to-menu').on('click', function() {
    $('html').ScrollTo();
  });

// FOOTER

  mainContent.css('min-height', (windowHeight - footerOffset));
  $('#footer').css('opacity', 1);
  $(window).resize(function() {
    mainContent.css('min-height', (windowHeight - footerOffset));
  });


// INDEX

  $('.js-post-toggle').on('click', function() {
    var $this = $(this);
    var $copy = $this.parent().find('.post-copy');

    if ($this.data('open') === true) {
      $copy.slideUp(basicAnimationSpeed);
      $this.data('open', false);
    } else {
      $copy.slideDown(basicAnimationSpeed);
      $this.data('open', true);
    }
  });

  // VIDEO HOVERS

  $('.project-video').each( function() {
    this.load();
  });

  $('.project-video').on('durationchange', function() {
    if( $(this).is(":hover") ) {
      this.play();
    }
    $(this).on({
      'mouseenter': function() {
        this.play();
      },
      'mouseleave': function() {
        this.pause();
        this.currentTime = 0;
      },
    });
  });

// SINGLE PROJECT

  if ($('body').hasClass('single-project')) {
    mainContent.ScrollTo();
    lazyLoadImages('.js-grid-img');
  }

  // OVERLAY GALLERY
  $('.js-load-gallery').on('click', function() {
    var target = '#overlay-gallery-' + $(this).data('gallery');
    var insert = $(target).find('.js-slick-item');

    insert.clone().appendTo('#gallery-overlay-insert');

    lazyLoadImages('#gallery-overlay-insert .slider-img');

    galleryOverlay.show();
    html.addClass('overlay-active');

    Slick.init();

    mainContent.ScrollTo();
  });

  $('#gallery-overlay-close').on('click', function() {
    galleryOverlay.hide();
    html.removeClass('overlay-active');
    $('.js-slick-container').slick('unslick').html('');
  });

  // OVERLAY VIDEO

  var resizeVideo = function() {
    videoPadding = parseInt($('.js-video-holder').css('padding-top'));
    videoAreaHeight = ( windowHeight - ( videoPadding * 2 ) );
    videoAreaWidth = ( windowWidth - ( videoPadding * 2 ) );

    videoHeight = videoAreaWidth * 0.5625;
    videoWidth = videoAreaHeight * 1.7777;

    if (videoHeight > videoAreaHeight) {
      videoHeight = videoAreaHeight;
      videoWidth = videoAreaHeight * 1.7777;
    }

    if (videoWidth > videoAreaWidth) {
      videoWidth = videoAreaWidth;
      videoHeight = videoAreaWidth * 0.5625;
    }

    $('#overlay-video-player').css({
      'height': videoHeight,
      'width': videoWidth,
    });
  };

  $('.js-load-vimeo').on('click', function() {
    var $this = $(this);
    var vimeo = $this.data();
    var insert = '<iframe id="overlay-video-player" src="//player.vimeo.com/video/' + vimeo.vimeo + '?portrait=0&badge=0&byline=0&title=0&autoplay=1" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';

    $('#video-overlay-insert').html(insert);
    $('#video-overlay-title').html(vimeo.title);

    videoOverlay.show();
    html.addClass('overlay-active');

    resizeVideo();

    mainContent.ScrollTo();
  });

  $('#video-overlay-close').on('click', function() {
    videoOverlay.hide();
    html.removeClass('overlay-active');
    $('#video-overlay-insert').html('');
  });

  // STICKY HEADER & SCROLLTO
  var $projectHeader = $('#project-header');
  var $toMenu = $('#scroll-to-menu');

  if ($projectHeader.length) {
    var projectHeaderOffset = $projectHeader.offset();
    var projectHeaderTop = projectHeaderOffset.top;
    var projectHeaderHeight = $projectHeader.outerHeight();

    $('article.project').prepend('<div class="js-header-spacer u-hidden"></div>');
    var $headerSpacer = $('.js-header-spacer');
    $headerSpacer.css('height', projectHeaderHeight);

    $(window).on('scroll', function() {

      var scrollTop = $(window).scrollTop();

      if ($projectHeader.hasClass('u-fixed')) {
        if (scrollTop <= projectHeaderTop) {
          $projectHeader.removeClass('u-fixed');
          $headerSpacer.addClass('u-hidden');
          $toMenu.addClass('u-hidden');
        }
      } else {
        if (scrollTop >= projectHeaderTop) {
          $projectHeader.addClass('u-fixed');
          $headerSpacer.removeClass('u-hidden');
          $toMenu.removeClass('u-hidden');
        }
      }

    });

  } else {

    var showToMenu = 100;

    $(window).on('scroll', function() {
      var scrollTop = $(window).scrollTop();
      if ($toMenu.hasClass('u-hidden')) {
        if (scrollTop >= showToMenu) {
          $toMenu.removeClass('u-hidden');
        }
      } else {
        if (scrollTop <= showToMenu) {
          $toMenu.addClass('u-hidden');
        }
      }
    });

  }

  // OTHER

  $('.js-project-copy-link').on('click', function() {
    var target = '#' + $(this).data('target-id');
    $(target).ScrollTo();
  });


// PACKERY

  if ( $('.js-packery-container').length ) {
    $('.js-packery-container').packery({
        itemSelector: '.js-packery-item',
        transitionDuration: '0s',
        percentPosition: true,
        isOriginTop: false
    });
  }

  $(window).bind('resize', function(e) {
    var resizeTimeout;
    $(window).resize(function() {
      clearTimeout(resizeTimeout);
      resizeTimeout = setTimeout(function() {
        Slick.resizeImages();
        resizeVideo();
      }, 250);
    });
  });

});