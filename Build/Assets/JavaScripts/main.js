/**
 * Initialize modules & plugins
 */
(function (window) {
  'use strict';

  var requireJsBasePath = window.requireJsBasePath || '/typo3conf/ext/ddboilerplate/Resources/Public/JavaScripts/';

  /**
   * RequireJs configuration
   */
  require.config({
    baseUrl: requireJsBasePath,
    waitSeconds: 60,
    paths: {
      'jquery': 'Vendor/jquery-3.2.0.min',
      'minigrid': 'Vendor/minigrid.min',
      'slick': 'Vendor/slick.min',
      'unveil': 'Vendor/jquery.unveil',
      'photoswipe': 'Vendor/photoswipe.min',
      'photoswipeUI_Default': 'Vendor/photoswipe-ui-default'
    },
    shim: {
      'slick': {
        deps: ['jquery'],
        exports: 'jQuery.fn.slick'
      },
      'unveil': {
        deps: ['jquery'],
        exports: 'jQuery.fn.unveil'
      }
    }
  });

  /**
   * Initialize JS-HTML Tag
   */

  var addJsClassToHtml = function () {
    document.querySelector('html').classList.add('js');
    document.querySelector('html').classList.remove('no-js');
  }

  addJsClassToHtml();

  /**
   * Fade out Overlay
   */

  requirejs(['jquery'], function ($) {
    $(document).ready(function () {
      $('html').addClass('js-page__animation--loaded');
    });
  });

  /**
   *  Mini Grid
   */

  var projectList = document.querySelectorAll('.c-project-list').length;

  if (projectList > 0) {
    requirejs(['minigrid'], function (Minigrid) {
      var grid = new Minigrid({
        container: '.c-project-list',
        item: '.c-project-list__item',
        gutter: 0
      });

      setTimeout(function(){
        grid.mount();
      }, 50);
      // grid.mount();

      // mount
      var update = function () {
        grid.mount();
      };

      window.addEventListener('resize', update);
    });
  }

  /**
   * Fancy page reload
   */
  var fancyPageReload = function () {
    // console.log('init: fancyPageReload');
    var anchors = document.getElementsByClassName('intern');
    for (var z = 0; z < anchors.length; z = z + 1) {
      var elem = anchors[z];
      elem.onclick = function () {
        var element = this;
        document.querySelector('html').classList.add('js-page__animation--is-loading');
        document.querySelector('html').classList.remove('js-page__animation--loaded');
        var xhr = new XMLHttpRequest();
        xhr.open('GET', element.href);
        xhr.send(null);
        xhr.onreadystatechange = function () {
          var DONE = 4;
          var OK = 200;
          if (xhr.readyState === DONE) {
            if (xhr.status === OK) {
              window.location = element.href;
            } else {
              console.log('Error: ' + xhr.status); // An error occurred during the request.
            }
          }
        };
        return false;
      };
    }
  };

  fancyPageReload();


  /**
   * Lazy Load Images
   */
  var lazyLoadImageCountProjects = document.querySelectorAll('.c-project-list img.lazy-image').length;
  var lazyLoadVideoCountProjects = document.querySelectorAll('.c-project-list .lazy-video').length;
  var lazyLoadImageCount = document.querySelectorAll('.c-profile .lazy-image').length;

  /**
   * Lazy load images in Gallery
   */

  if (lazyLoadImageCountProjects > 0) {
    requirejs(['jquery', 'unveil'], function () {
      $(document).ready(function () {
        $("img.lazy-image").unveil(400, function () {
          // console.log('unveiled');
          requirejs(['minigrid'], function (Minigrid) {
            var grid = new Minigrid({
              container: '.c-project-list',
              item: '.c-project-list__item',
              gutter: 0
            });

            setTimeout(function(){
              grid.mount();
            }, 100);
          });

          var parentListItem = $(this).parents('li');
          parentListItem.addClass('is-unveiled');
        });
      });
    });
  }

  /**
   * Lazy Load Videos in Gallery
   */

  if (lazyLoadVideoCountProjects > 0) {
    requirejs(['jquery', 'unveil'], function () {
      $(document).ready(function () {
        $(".lazy-video").unveil(300, function () {

          requirejs(['minigrid'], function (Minigrid) {
            var grid = new Minigrid({
              container: '.c-project-list',
              item: '.c-project-list__item',
              gutter: 0
            });
            setTimeout(function(){
              grid.mount();
            }, 100);
          });


          var vid = $(this);
          // console.log(vid);
          [].forEach.call(vid, function (el) {
            // var title = $(this).data(src);
            setTimeout(function () {
              el.load();
              // console.log('loaded');
            }, 500);
            setTimeout(function () {
              el.play();
              // console.log('video played');
            }, 1750);
          });

          var parentListItem = $(this).parents('li');
          parentListItem.addClass('is-unveiled');
        });
      });
    });
  }

  /**
   * Lazy laod Images in About
   */

  if (lazyLoadImageCount > 0) {
    requirejs(['jquery', 'unveil'], function () {
      $(document).ready(function () {
        $(".lazy-image").unveil(100, function () {
          // console.log('regular image unveiled')
          var parentListItem = $(this).parents('.c-profile');
          parentListItem.addClass('is-unveiled');
        });
      });
    });
  }

  /**
   * Slick Slider
   */
  var sliderItemCount = document.querySelectorAll('.c-slider').length;

  if (sliderItemCount > 0) {
    requirejs(['jquery', 'slick'], function ($) {

      $('.c-slider').on('init', function (slick) {
        // var $slides = $('.c-slider').slick("getSlick").$slides;
        var color = $(slick.currentTarget).find('.slick-current').data('color');
        // console.log(color);

        if (color === 'dark') {
          $('.header__page').addClass('header__page--light');
          $('.header__page').removeClass('header__page--dark');
          $('.c-slider').addClass('c-slider--light');
          $('.c-slider').removeClass('c-slider--dark');
        } else if (color === 'light') {
          $('.header__page').addClass('header__page--dark');
          $('.header__page').removeClass('header__page--light');
          $('.c-slider').addClass('c-slider--dark');
          $('.c-slider').removeClass('c-slider--light');
        }
      });

      $('.c-slider').slick({
        dots: true,
        infinite: true,
        speed: 300,
        slide: "li.c-slider__item",
        slidesToShow: 1,
        slidesToScroll: 1,
        responsive: [
          {
            breakpoint: 1024,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1,
              infinite: true
            }
          }, {
            breakpoint: 600,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          }, {
            breakpoint: 480,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1,
              arrows: false
            }
          }
        ]
      });

      $('.c-slider').on('beforeChange', function (event, slick, currentSlide, nextSlide) {
        // var $slides = $('.c-slider').slick("getSlick").$slides;
        var color = slick.$slides.eq(nextSlide).data('color');

        if (color === 'dark') {
          $('.header__page').addClass('header__page--light');
          $('.header__page').removeClass('header__page--dark');
          $('.c-slider').addClass('c-slider--light');
          $('.c-slider').removeClass('c-slider--dark');
        } else if (color === 'light') {
          $('.header__page').addClass('header__page--dark');
          $('.header__page').removeClass('header__page--light');
          $('.c-slider').addClass('c-slider--dark');
          $('.c-slider').removeClass('c-slider--light');
        }
      });
    });
  }

  /**
   * Video background sets header color
   */

  requirejs(['jquery'], function ($) {
    var colorVideo = document.getElementsByClassName("c-video__file--color-0");

    if (colorVideo.length > 0) {
      $('.header__page').addClass('header__page--light');
      $('.header__page').removeClass('header__page--dark');
    } else{
      $('.header__page').addClass('header__page--dark');
      $('.header__page').removeClass('header__page--light');
    }
  });


  /**
   * Delay Thumbnail Videos
   */

  // var videoThumbnail = document.getElementsByClassName("c-project-list__video");
  //
  // if (videoThumbnail.length > 0) {
  //   [].forEach.call(videoThumbnail, function (el) {
  //     console.log('video unveiled');
  //     setTimeout(function () {
  //       console.log('video played');
  //       el.play();
  //     }, 1500);
  //   });
  // }

  /**
   * PhotoSwipe Lightbox
   */

  var pswpGallery = document.querySelectorAll('.my-gallery').length;

  if (pswpGallery > 0) {
    requirejs(['photoswipe', 'photoswipeUI_Default'], function (PhotoSwipe, PhotoSwipeUI_Default) {

      var initPhotoSwipeFromDOM = function (gallerySelector) {

        // parse slide data (url, title, size ...) from DOM elements
        // (children of gallerySelector)
        var parseThumbnailElements = function (el) {
          var thumbElements = el.childNodes,
            numNodes = thumbElements.length,
            items = [],
            figureEl,
            linkEl,
            size,
            item;

          for (var i = 0; i < numNodes; i++) {

            figureEl = thumbElements[i]; // <figure> element

            // include only element nodes
            if (figureEl.nodeType !== 1) {
              continue;
            }

            linkEl = figureEl.children[0]; // <a> element

            size = linkEl.getAttribute('data-size').split('x');

            // create slide object

            if ($(linkEl).data('type') == 'video') {
              item = {
                html: $(linkEl).data('video')
              };
            }
            else {
              item = {
                src: linkEl.getAttribute('href'),
                w: parseInt(size[0], 10),
                h: parseInt(size[1], 10)
              };
            }

            // item = {
            //   src: linkEl.getAttribute('href'),
            //   w: parseInt(size[0], 10),
            //   h: parseInt(size[1], 10)
            // };


            if (figureEl.children.length > 1) {
              // <figcaption> content
              item.title = figureEl.children[1].innerHTML;
            }

            if (linkEl.children.length > 0) {
              // <img> thumbnail element, retrieving thumbnail url
              item.msrc = linkEl.children[0].getAttribute('src');
            }

            item.el = figureEl; // save link to element for getThumbBoundsFn
            items.push(item);
          }

          return items;
        };

        // find nearest parent element
        var closest = function closest(el, fn) {
          return el && ( fn(el) ? el : closest(el.parentNode, fn) );
        };

        // triggers when user clicks on thumbnail
        var onThumbnailsClick = function (e) {
          e = e || window.event;
          e.preventDefault ? e.preventDefault() : e.returnValue = false;

          var eTarget = e.target || e.srcElement;

          // find root element of slide
          var clickedListItem = closest(eTarget, function (el) {
            return (el.tagName && el.tagName.toUpperCase() === 'LI');
          });

          if (!clickedListItem) {
            return;
          }

          // find index of clicked item by looping through all child nodes
          // alternatively, you may define index via data-attribute
          var clickedGallery = clickedListItem.parentNode,
            childNodes = clickedListItem.parentNode.childNodes,
            numChildNodes = childNodes.length,
            nodeIndex = 0,
            index;

          for (var i = 0; i < numChildNodes; i++) {
            if (childNodes[i].nodeType !== 1) {
              continue;
            }

            if (childNodes[i] === clickedListItem) {
              index = nodeIndex;
              break;
            }
            nodeIndex++;
          }


          if (index >= 0) {
            // open PhotoSwipe if valid index found
            openPhotoSwipe(index, clickedGallery);
          }
          return false;
        };

        // parse picture index and gallery index from URL (#&pid=1&gid=2)
        var photoswipeParseHash = function () {
          var hash = window.location.hash.substring(1),
            params = {};

          if (hash.length < 5) {
            return params;
          }

          var vars = hash.split('&');
          for (var i = 0; i < vars.length; i++) {
            if (!vars[i]) {
              continue;
            }
            var pair = vars[i].split('=');
            if (pair.length < 2) {
              continue;
            }
            params[pair[0]] = pair[1];
          }

          if (params.gid) {
            params.gid = parseInt(params.gid, 10);
          }

          return params;
        };

        var openPhotoSwipe = function (index, galleryElement, disableAnimation, fromURL) {
          var pswpElement = document.querySelectorAll('.pswp')[0],
            gallery,
            options,
            items;

          items = parseThumbnailElements(galleryElement);

          // define options (if needed)
          options = {

            // define gallery index (for URL)
            galleryUID: galleryElement.getAttribute('data-pswp-uid'),

            getThumbBoundsFn: function (index) {
              // See Options -> getThumbBoundsFn section of documentation for more info
              var thumbnail = items[index].el.getElementsByClassName('c-project-list__thumbnail')[0], // find thumbnail
                pageYScroll = window.pageYOffset || document.documentElement.scrollTop,
                rect = thumbnail.getBoundingClientRect();

              return {x: rect.left, y: rect.top + pageYScroll, w: rect.width};
            },

            // Disable Zoom which is not supported by default
            maxSpreadZoom: 1,
            zoomEl: false,
            getDoubleTapZoom: function(isMouseClick, item) {
              return item.initialZoomLevel;
            },
            pinchToClose: false
          };

          // PhotoSwipe opened from URL
          if (fromURL) {
            if (options.galleryPIDs) {
              // parse real index when custom PIDs are used
              // http://photoswipe.com/documentation/faq.html#custom-pid-in-url
              for (var j = 0; j < items.length; j++) {
                if (items[j].pid == index) {
                  options.index = j;
                  break;
                }
              }
            } else {
              // in URL indexes start from 1
              options.index = parseInt(index, 10) - 1;
            }
          } else {
            options.index = parseInt(index, 10);
          }

          // exit if index not found
          if (isNaN(options.index)) {
            return;
          }

          if (disableAnimation) {
            options.showAnimationDuration = 0;
          }

          // Pass data to PhotoSwipe and initialize it
          gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
          gallery.init();
          gallery.options.showHideOpacity = true;
          gallery.options.getThumbBoundsFn = false;

        };

        // loop through all gallery elements and bind events
        var galleryElements = document.querySelectorAll(gallerySelector);

        for (var i = 0, l = galleryElements.length; i < l; i++) {
          galleryElements[i].setAttribute('data-pswp-uid', i + 1);
          galleryElements[i].onclick = onThumbnailsClick;
        }

        // Parse URL and open gallery if it contains #&pid=3&gid=1
        var hashData = photoswipeParseHash();
        if (hashData.pid && hashData.gid) {
          openPhotoSwipe(hashData.pid, galleryElements[hashData.gid - 1], true, true);
        }
      };
      // execute above function
      initPhotoSwipeFromDOM('.my-gallery');

    });
  }

})
(window);
