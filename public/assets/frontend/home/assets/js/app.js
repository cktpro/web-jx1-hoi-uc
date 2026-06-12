

jQuery(document).ready(function(){


    // sllick slide new  
    $('.slide-new').slick({
        dots: true,
        prevArrow: false,
        nextArrow: false,
        autoplay: true,
        speed: 500,
    });

    // slick slider mon phai
    $('.slide-featured').slick({
      // fade: true,
      autoplay: true,
      autoplaySpeed: 5000,
      speed: 300,
      arrows: true,
      dots: true,
      infinite: true,
      slidesToShow: 1,
      slidesToScroll: 1,
      mobileFirst: true,
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            arrows: false,
          }
        }
      ],
      customPaging: function(slider, i) {
        var thumb = $(slider.$slides[i]).data();
        return '<div class="txt-dot"><span></span></div>';
      },
    });

    var tabs_hephai = $('.slide-featured .slick-dots');
    tabs_hephai.find('li:first-child() div span').html('Chiến trường <span class="txt-big">rực lửa</span>');
    tabs_hephai.find('li:nth-child(2) div span').html('Hào kiệt <span class="txt-big">xuất thế</span>');
    tabs_hephai.find('li:nth-child(3) div span').html('Kiếm hiệp <span class="txt-big">tình duyên</span>');
    tabs_hephai.find('li:nth-child(4) div span').html('Giao dịch <span class="txt-big">tự do</span>');

    // sllick art 
    $('.slide-art').slick({
        dots: true,
        // autoplay: true,
        speed: 300,
        customPaging: function(c,b){
          var a=$(c.$slides[b]).data();return"<div> <a></a> </div>";
        },
    });
    var slide_he_phai_text=$(".slide-art .slick-dots");
    slide_he_phai_text.find("li:first-child() a").text("Thiên Sơn");
    slide_he_phai_text.find("li:nth-child(2) a").text("Thiên Vương");
    slide_he_phai_text.find("li:nth-child(3) a").text("Võ Đang");

    

    // tab Compoenets news
    $('ul.tab-news li').click(function(){
        var tab_id = $(this).attr('data-tab-news');

        $('ul.tab-news li').removeClass('current');
        $('.tab-detail-news').removeClass('current');

        $(this).addClass('current');
        $("#"+tab_id).addClass('current');

        var tab_id_view_more = $(this).attr('data-view-news');
        $('.tab-view-more-news').removeClass('current');

        $(this).addClass('current');
        $("#"+tab_id_view_more).addClass('current');

    });


    
    // gotop
    var offset = 800
        anchor = $('.anchor')
        go_top = $('.go-top');

    $(window).scroll(function() {
      ($(this).scrollTop() < offset) ? anchor.removeClass('run') : anchor.addClass('run');
    });

    go_top.click(function(){$('html,body').animate({scrollTop: 0}, 1000);});

    
});


//# sourceMappingURL=app.js.map