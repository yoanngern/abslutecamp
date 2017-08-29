// @codekit-prepend "vendor/jquery-2.2.2.js"
// @codekit-prepend "vendor/jquery.slides.min.js"

$(document).ready(function () {


    $("body > header").on("click", "#burger", function (event) {
        event.preventDefault();
        $("body > header div[class^='menu-menu']").toggleClass("show");
        $("body > header #burger").toggleClass("open");
    });




    ratio();


    $(window).resize(function () {

        ratio();
    });


    $(document).scroll(function () {

        var pos = $(document).scrollTop();

        //console.log(pos);

        //var slideheader = $("section.slideheader").height();

        var start = 60;

        if (pos >= start) {
            $("#subnav").addClass("fixed");
        } else {
            $("#subnav").removeClass("fixed");
        }

        /*


         if (pos >= start && pos <= (start + 68)) {
         header((pos - start) / 0.68);
         } else if (pos >= (start + 68)) {
         header(100);
         } else if (pos <= start) {
         header(0);
         }

         if (pos >= 0 && pos <= 200) {
         $("div.logowhite").css("opacity", (-Math.pow((pos / 2), 2)) / 10000 + 1);
         } else if (pos >= 200) {
         $("div.logowhite").css("opacity", 0);
         } else if (pos <= start) {
         $("div.logowhite").css("opacity", 1);
         }

         */
    });


    $(".slidesjs").each(function () {

        var slider = $(this);

        var option = {
            width: 1920,
            height: slider.data("height"),
            navigation: {
                active: false
            },
            pagination: {
                active: false
            }
        };

        if (slider.data("size") != 1) {

            option.navigation = {
                active: true,
                effect: "swipe"
            };

            option.pagination = {
                active: true,
                effect: "swipe"
            };

            if (!slider.data("nav")) {
                option.navigation = {
                    active: false
                };
            }

            if (!slider.data("pag")) {
                option.pagination = {
                    active: false
                };
            }

            option.effect = {
                fade: {
                    speed: 500
                }
            };

            option.play = {
                effect: "swipe",
                interval: 4000,
                auto: true,
                swap: true,
                restartDelay: 2500
            };
        }

        slider.slidesjs(option);
    });
});


function ratio() {
    var h = $(window).height();
    var w = $(window).width();

    var ratio = w / h;

    if (ratio >= 3) {

        ratio = 3;

    } else if (ratio >= 1.5 && ratio <= 2) {

        ratio = 1.5;

    } else if (ratio >= 1) {

        ratio = Math.round(ratio);

    } else {

        ratio = Math.round(ratio * 10) / 10;

        if (ratio < 0.5) {
            ratio = 0.5;
        }

    }

    $("body").attr("data-ratio", ratio);
}
