$(document).foundation();

$(document).ready(function($) {

  // headroom
  var headroom  = new Headroom(document.querySelector("header"));
  headroom.init();  

  // nav menu
  $('.menu-toggle').on("click", function(e) {
    e.preventDefault();
    $('.mobile-navigation').toggleClass('is-active');
  });

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
	// Adds Flex Video to YouTube and Vimeo Embeds
  $('iframe[src*="youtube.com"], iframe[src*="vimeo.com"]').each(function() {
    $(this).parent().addClass('responsive-embed widescreen')
  });

})
