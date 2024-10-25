$(document).foundation();

var pageDimensions = {
  sidebarHeight: 0,
  breadcrumbHeight: 0,
  headerHeight: 0,
};

var blockSettings = {
  postGrid: {
    scrollOffset: 0,
  }
};

$(document).ready(function($) {

  //dimensions
  pageDimensions.sidebarHeight = $('.outer-container .sidebar-container').outerHeight();
  $('body').css('--sidebar-height', pageDimensions.sidebarHeight+'px');
  pageDimensions.breadcrumbHeight = $('.breadcrumb-container').outerHeight();
  $('body').css('--breadcrumb-height', pageDimensions.breadcrumbHeight+'px');
  pageDimensions.headerHeight = $('header').outerHeight();
  $('body').css('--header-height', pageDimensions.headerHeight+'px');

  // headroom
  var headroom  = new Headroom(document.querySelector("header"));
  headroom.init();  

  // nav menu
  $('.menu-toggle').on("click", function(e) {
    e.preventDefault();
    $('.mobile-navigation').toggleClass('is-active');
  });

  // hero
  var heroFlickityArgs = {
    cellSelector: '.carousel-cell',
    cellAlign: 'left',
    wrapAround: true,
    draggable: false,
    pageDots: false,
    prevNextButtons: true,
  };
  $('.hero-carousel').each(function() {
    var $current = $(this);
    var speed = $current.data('slider-speed');
    var animation = $current.data('slider-animation');
    var args = heroFlickityArgs;
    if (speed) {
      args.autoPlay = parseInt(speed);
      args.pauseAutoPlayOnHover = false;
    }
    if (animation == 'fade') {
      args.fade = true;
    }
    $current.flickity(args);
  });

  // blocks
  $('.block-media.type-slider .image-carousel .carousel-cell').each(function() {
    $(this).height($(this).parent().outerHeight());
  });
  $('.block-media.type-slider .image-carousel').each(function() {
    $(this).flickity({
      cellSelector: '.carousel-cell',
      cellAlign: 'left',
      wrapAround: true,
      draggable: true,
      pageDots: false,
      prevNextButtons: true,
      autoPlay: ($(this).data('autoplay') == '1') ? 5000 : false,
      pauseAutoPlayOnHover: true,
    })
  });
  $('.block-image-carousel .image-carousel').each(function() {
    $(this).flickity({
      cellSelector: '.carousel-cell',
      cellAlign: 'left',
      wrapAround: true,
      draggable: true,
      pageDots: false,
      prevNextButtons: false,
      autoPlay: false,
    })
  });
  $('.post-grid-pager a').on('click', function() {
    var $current = $(this);
    var page = $current.data('page');
    var $postContainer = $current.parents('.post-grid-pager').siblings('.post-grid');
    var pageCount = parseInt($postContainer.data('page-count'));
    if ($current.is('.active') || $current.is('.disabled')) return;
    switch (page) {
      case 'prev':
        var currentPage = $postContainer.data('current-page');
        if (parseInt(currentPage) > 1) {
          $current.siblings('[data-page='+(currentPage-1)+']').trigger('click');
        }
        break;
      case 'next':
        var currentPage = $postContainer.data('current-page');
        if (parseInt(currentPage) < pageCount) {
          $current.siblings('[data-page='+(currentPage+1)+']').trigger('click');
        }
        break;
      case 'first':
        break;
      case 'last':
        break;
      default: // page numbers
        $current.siblings().removeClass('active');
        $current.addClass('active');
        if (page == 1) {
          $current.siblings('[data-page="prev"]').addClass('disabled');
          $current.siblings('[data-page="next"]').removeClass('disabled');
        } else if (page == pageCount) {
          $current.siblings('[data-page="prev"]').removeClass('disabled');
          $current.siblings('[data-page="next"]').addClass('disabled');
        } else {
          $current.siblings('[data-page="prev"]').removeClass('disabled');
          $current.siblings('[data-page="next"]').removeClass('disabled');
        }
        $postContainer.data('current-page', page);
        $postContainer.find('.post-grid-item').addClass('hide');
        $postContainer.find('.post-grid-item[data-page="'+page+'"]').removeClass('hide');
    }
    $('html,body').animate({scrollTop: $postContainer.offset().top - blockSettings.postGrid.scrollOffset}, 500);  
  });
	// Adds Flex Video to YouTube and Vimeo Embeds
  $('iframe[src*="youtube.com"], iframe[src*="vimeo.com"]').each(function() {
    $(this).parent().addClass('responsive-embed widescreen')
  });

})
