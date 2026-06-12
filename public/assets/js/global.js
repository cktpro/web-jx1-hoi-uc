window.globalMethod = (function () {
  var common = {
    tab: function tab(option) {
      var config = {
        tabControl: [".bar2-tab a"],
        contControl: ".bar2 li",
        activeName: "curr",
        event: "click",
        autoPlay: false,
        speed: 5000,
        cb: function () {},
      };
      var index = 0;
      var autoStatus = null;
      for (var keyname in option) {
        config[keyname] = option[keyname];
      }

      tabCont();
      config.tabControl.forEach(element => {
        $(element).on(config.event, function () {
          index = $(this).index();
  
          if (config.autoPlay) {
            autoPlayCont();
          }
  
          if (option.cb) {
            option.cb & option.cb(index);
          }
  
          tabCont();
        });
      });
      

      if (config.autoPlay) {
        autoPlayCont();
      }

      function autoPlayCont() {
        var len = $(config.contControl).length - 1;
        clearInterval(autoStatus);
        autoStatus = setInterval(function () {
          index++;
          if (index > len) {
            index = 0;
          }
          tabCont();
        }, config.speed);
      }

      function tabCont() {
        var activeName = config.activeName;
        config.tabControl.forEach(element=>{
          $(element)
          .eq(index)
          .addClass(activeName)
          .siblings()
          .removeClass(activeName);
        })
        

        if (config.contControl) {
          if (typeof config.contControl == "string") {
            $(config.contControl)
              .eq(index)
              .addClass(activeName)
              .siblings()
              .removeClass(activeName);
          }
          if (typeof config.contControl == "object") {
            for (var i = 0; i < config.contControl.length; i++) {
              $(config.contControl[i])
                .eq(index)
                .addClass(activeName)
                .siblings()
                .removeClass(activeName);
            }
          }
        }
      }
    },
  };

  function init() {
    $(".tab-news li").each(function () {
      var local = window.location.href;
      var href = $(this).find("a").attr("href");
      if (local.indexOf(href) > -1) {
        $(this).addClass("curr");
      }
    });

    $(".tab-news li p a").each(function () {
      var local = window.location.href;
      var href = $(this).attr("href");
      if (local.indexOf(href) > -1) {
        $(this).addClass("current");
        $(this).parents("li").addClass("curr");
        $(this).parent("p").show();
      }
    });
  }

  return {
    common: common,
    init: init,
  };
})();

function showNav() {
 $('.nav-right').addClass('active');
 $('body').css('overflow','hiden');
}
function hideNav(){
  $('.nav-right').removeClass('active');
  $('body').css('overflow','unset');
}

$(function () {
  globalMethod.init();
});
