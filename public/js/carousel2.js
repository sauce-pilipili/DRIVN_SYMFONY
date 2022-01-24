$(function(){
  $('.responsive').slick({
    autoplaySpeed: 5000,
    slidesToShow: 3,
    infinite: false,
    prevArrow: $('.prev'),
    nextArrow: $('.next'),
    responsive: [
      {
        breakpoint: 1200,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 1008,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
    ]
});
});

