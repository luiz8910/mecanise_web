var opened_menu = false;
var black_moon = '<i class="fas fa-moon"></i>';
var white_moon = '<i class="far fa-moon"></i>';

$(function () {

    localStorage.removeItem('open_items_menu');

    setInterval(function () {
        $("#body").css('display', 'none');
        $(".pre-loading").css('display', 'block');
    }, 1000);

    if(localStorage.getItem('night_mode') == true)
    {
        $(".ver3").css('display', 'block');
        night_mode = true;
        $(".night-mode i").remove();
        $(".night-mode").append(white_moon);
        localStorage.setItem('night_mode', night_mode);
    }
    else{
        $(".ver1").css('display', 'block');
        night_mode = false;
        localStorage.setItem('night_mode', night_mode);
    }

    $(".night-mode").click(function () {

        night_mode = !night_mode;

        if(night_mode)
        {
            $(".ver1").css('display', 'none');
            $(".ver3").css('display', 'block');

            $('.night-mode i').remove();

            $(".night-mode").append(white_moon);

            localStorage.setItem('night_mode', true);
        }
        else{
            $(".ver1").css('display', 'block');
            $(".ver3").css('display', 'none');

            $('.night-mode i').remove();
            $(".night-mode").append(black_moon);

            localStorage.setItem('night_mode', false);
        }
    });


    $('.plus-btn').click(function(){
        $('body').toggleClass('menu-open');

        opened_menu = !opened_menu;

        open_menu(opened_menu);
    });

    $(".menu_li").click(function () {

        var id = this.id.replace('li_', '');

        $(".lvl_1").css('display', 'none');

        $("#menu_item_"+id).css('display', 'block');

        if(localStorage.getItem('open_items_menu'))
        {
            var levels = localStorage.getItem('open_items_menu');

            levels++;

            localStorage.setItem('open_items_menu', levels);
        }


    });

    $(".menu_back").click(function () {
        $(".menu-items").css('display', 'none');

        $(".menu_li").css('display', 'block');

        $(".menu ul").css('display', 'flex');

        $(".r1").css('display', 'block');

        $(".r2").css('display', 'block');
    });


    $('.js-pscroll').each(function(){
        var ps = new PerfectScrollbar(this);

        $(window).on('resize', function(){
            ps.update();
        })
    });

});

function open_menu($status)
{
    if($status)
    {

        $(".menu").css('display', 'block');
        $(".r1").css('display', 'block');
        $(".r2").css('display', 'block');

        $(".limiter").css('display', 'none');
        $(".bars").css('display', 'none');

        localStorage.setItem('open_items_menu', 1);
    }
    else{

        $(".menu").css('display', 'none');
        $(".r1").css('display', 'none');
        $(".r2").css('display', 'none');

        $(".limiter").css('display', 'block');
        $(".bars").css('display', 'initial');

        localStorage.setItem('open_items_menu', 0);
    }
}

function back_menu()
{
    var levels = localStorage.getItem('open_items_menu');

    if(levels == 1)
        $(".plus-btn").trigger('click');

    else{
        $(".lvl_"+levels).css('display', 'none');

        levels--;

        localStorage.setItem('open_items_menu', levels);

        if(levels == 1)
        {
            $(".menu_li").css("display", 'block');
            $(".lvl_"+levels).css('display', 'block');
        }

    }
}
