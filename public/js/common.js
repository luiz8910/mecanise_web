var opened_menu = false;
var black_moon = '<i class="fas fa-moon"></i>';
var white_moon = '<i class="far fa-moon"></i>';
var menu_item_open = false;
var v_hide_menu = false;
var user_option_item = false;

$(function () {

    localStorage.removeItem('open_items_menu');
    localStorage.setItem('filters', false);

    setInterval(function () {
        $("#body").css('display', 'none');
        $(".pre-loading").css('display', 'block');
    }, 1000);

    if (localStorage.getItem('night_mode') == true) {
        $("#table_list")
            .addClass('ver3')
            .removeClass('ver1')
            .css('display', 'block');

        night_mode = true;
        $(".night-mode i").remove();
        $(".night-mode").append(white_moon);
        localStorage.setItem('night_mode', night_mode);
    } else {
        $("#table_list")
            .removeClass('ver3')
            .addClass('ver1')
            .css('display', 'block');

        night_mode = false;
        localStorage.setItem('night_mode', night_mode);
    }

    $(".night-mode").click(function () {

        night_mode = !night_mode;

        if (night_mode) {
            $("#table_list")
                .removeClass('ver1')
                .addClass('ver3');


            $('.night-mode i').remove();

            $(".night-mode").append(white_moon);

            localStorage.setItem('night_mode', true);
        } else {
            $("#table_list")
                .removeClass('ver3')
                .addClass('ver1');

            $('.night-mode i').remove();
            $(".night-mode").append(black_moon);

            localStorage.setItem('night_mode', false);
        }
    });


    $('.plus-btn').click(function () {
        $('body').toggleClass('menu-open');

        opened_menu = !opened_menu;

        open_menu(opened_menu);
    });

    $(".menu_li").click(function () {

        var id = this.id.replace('li_', '');

        $(".lvl_1").css('display', 'none');

        $("#menu_item_" + id).css('display', 'block');

        if (localStorage.getItem('open_items_menu')) {
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


    $('.js-pscroll').each(function () {
        var ps = new PerfectScrollbar(this);

        $(window).on('resize', function () {
            ps.update();
        })
    });

    $('.next-tab').attr('disabled', null);

    $('.submit').attr('disabled', null);

    $(".number").keypress(function (e) {

        if (e.which < 48 || e.which > 57)
            return false;

    });

    $(".tab-info").keyup(function () {
        $('.input-group').removeClass('border-red');

        $(".text-danger").css('display', 'none');

    }).change(function () {
        $(".text-danger").css('display', 'none');
    });

    $("input[type=number]").keydown(function (e) {

        if (e.which === 69)
            return false;
    });

    $("#cpf").change(function () {

        before_validate_cpf();
    });


    $("#modal_cpf").change(function () {

        before_validate_cpf('modal_cpf');
    });

    $("#chassis").change(function () {
        validate_chassis();
    });


    $(".search-model").click(function () {
        $(this).css('display', 'none');

        $(".hide-search").css('display', 'none');

        $("#label-search-model").css('display', 'block');

        $("#search-model").css('display', 'block').focus();
    });

    $("#search-model").blur(function () {

        $(this).css('display', 'none');

        $("#label-search-model").css('display', 'none');

        $(".search-model").css('display', 'block');

        if(localStorage.getItem('filters') == true)
            $("#remove_filters").css('display', 'inline-block');

    });

    $("#owner_id").change(function () {
        var value = $(this).val();

        $("#owner_id_input").val(value);
    });


    $(".date").keyup(function (e) {

        var value = $(this).val();

        if(value.length == 2 && e.which != 8)
        {
            value += '/';

            $(this).val(value);
        }
        else if(value.length == 5 && e.which != 8)
        {
            value += '/';

            $(this).val(value);
        }
    });

    $(".main-item").click(function () {
        var id = this.id;
        var ul = id.replace('item-', '');

        if (menu_item_open)
        {

            $('.ul-subitem').css('display', 'none');

            $("#ul-"+ul).css('display', 'none');

            menu_item_open = !menu_item_open;
        }
        else{
            $('.ul-subitem').css('display', 'none');

            $("#ul-"+ul).css('display', 'block');

            menu_item_open = !menu_item_open;
        }

    });


    setTimeout(function () {
        $("#general-search-icon").css('display', 'inline-block');
    }, 2000);

    $("#general-search-icon").click(function () {

        $(this).css('display', 'none');

        $("#general-search-input").css("display", "inline-block");
    });

    $(".icon-profile").mouseenter(function () {
        $(".profile-settings-box").css('display', 'inline-block');
    });

    $(".profile-settings-box").mouseleave(function () {
        $(this).css('display', 'none');
    });


    $(".hide-menu").click(function () {

        v_hide_menu = !v_hide_menu;

        if(v_hide_menu)
        {
            $(".menu-topic p").css('display', 'none');
            $(".span-item-name").css('display', 'none');
            $(".span-item").css('display', 'none');

            $(".top-menu").css('width', '3%');

            $(".menu").css('width', '3%');
        }
        else{
            $(".menu-topic p").css('display', 'inline-block');
            $(".span-item-name").css('display', 'inline-block');
            $(".span-item").css('display', 'inline-block');

            $(".top-menu").css('width', '16%');

            $(".menu").css('width', '16%');
        }

    });




});

function load_more()
{

    $("#load-more").attr('disabled', true);
    $("#load-more span").text('Carregando...');
    $(".fa-download").css('display', 'none');
    $(".fa-spinner").css('display', 'inline-block');


    var offset = $("#offset").val();
    var page = location.pathname;
    var url = '';

    switch (page) {
        case '/':
            url = '/car_pagination/' + offset;
            break;

        case '/carros':
            url = '/car_pagination/' + offset;
            break;
    }

    var request = $.ajax({
        url: url,
        method: 'GET',
        dataType: 'json'
    });

    request.done(function (e) {

        if(e.status)
        {

            var append = '';

            for (var i = 0; i < e.cars.length; i++)
            {
                var start_year = e.cars[i].start_year != null ? e.cars[i].start_year : '';
                var end_year = e.cars[i].end_year != null ? e.cars[i].end_year : '';

                append += '<tr class="row100 body" id="model_'+e.cars[i].id+'">'+
                    '<th scope="row">'+e.cars[i].id+'</th>'+
                    '<td><a href="'+e.edit+e.cars[i].id+'" class="car_model">'+e.cars[i].model+'</a></td>'+
                    '<td>'+e.cars[i].brand_name+'</td>'+
                    '<td><span class="car_version">'+e.cars[i].version+'</span></td>'+
                    '<td>'+start_year+'</td>'+
                    '<td>'+end_year+'</td>'+
                    '<td><a href="'+e.edit+e.cars[i].id+'" class="btn btn-sm btn-outline-info" title="Editar Carro">' +
                                    '<i class="fas fa-edit"></i>' +
                    '          </a> '+
                    '          <button class="btn btn-sm btn-outline-danger" onclick="delete_car('+e.cars[i].id+')" title="Excluir Carro">' +
                    '               <i class="fas fa-trash"></i>' +
                    '          </button>'+
                    '      </td>'+
                '</tr>';
            }

            $("#tbody-main").append(append);

            $("#offset").val(e.offset);
        }
    });

    request.fail(function (e) {
        console.log('fail', e);

        sweet_alert_error();
    });

    $("#load-more").attr('disabled', null);
    $("#load-more span").text('Carregar mais resultados');
    $(".fa-download").css('display', 'inline-block');
    $(".fa-spinner").css('display', 'none');
}

function remove_filters()
{
    $("#tbody-search").css('display', 'none');

    $("#tbody-main").css('display', 'block');

    $("#search-model").val('');

    $("#remove_filters").css('display', 'none');

    localStorage.setItem('filters', false);
}

function open_menu($status) {
    if ($status) {

        $(".menu").css('display', 'block');
        $(".r1").css('display', 'block');
        $(".r2").css('display', 'block');

        $(".limiter").css('display', 'none');
        $(".container-contact100").css('display', 'none');
        $(".bars").css('display', 'none');


        localStorage.setItem('open_items_menu', 1);
    } else {

        $(".menu").css('display', 'none');
        $(".r1").css('display', 'none');
        $(".r2").css('display', 'none');

        $(".limiter").css('display', 'block');
        $(".container-contact100").css('display', 'flex');
        $(".bars").css('display', 'initial');

        localStorage.setItem('open_items_menu', 0);
    }
}

function back_menu() {
    var levels = localStorage.getItem('open_items_menu');

    if (levels == 1)
        $(".plus-btn").trigger('click');

    else {
        $(".lvl_" + levels).css('display', 'none');

        levels--;

        localStorage.setItem('open_items_menu', levels);

        if (levels == 1) {
            $(".menu_li").css("display", 'block');
            $(".lvl_" + levels).css('display', 'block');
        }

    }
}

function before_validate_cpf($input) {
    $input = $input ? $input : 'cpf';

    if ($("#" + $input).val().length == 11) {
        if (!validate_cpf($input)) {
            sweet_alert_error('CPF inválido');

            $("#" + $input).addClass('input-error');
        } else {
            $("#" + $input).removeClass('input-error');
        }
    }
}

function sweet_alert($data, $ajax) {
    swal({
        title: $data.title,
        text: $data.text,
        icon: $data.icon ? $data.icon : "warning",
        buttons: {
            cancel: {
                text: $data.cancel ? $data.cancel : "Cancelar",
                value: null,
                visible: true,
                closeModal: true,
            },
            confirm: {
                text: $data.button ? $data.button : "OK",
                value: true,
                visible: true,
                closeModal: true
            }
        }

    }).then((value) => {
        if (value) {
            var request = $.ajax({
                url: $ajax.url,
                method: $ajax.method ? $ajax.method : 'GET',
                dataType: 'json'
            });

            request.done(function (e) {
                if (e.status) {

                    swal($data.success_msg, {
                        icon: 'success',
                        timer: 3000
                    });

                    setTimeout(function () {
                        if ($data.reload)
                            location.reload();
                        else
                            $("#model_" + $data.id).remove();
                    }, 3000);
                } else {
                    sweet_alert_error();

                    return false;
                }
            });

            request.fail(function (e) {
                console.log('fail');
                console.log(e);
                sweet_alert_error();

                return false;
            })

        }

        return false;
    });


}

function sweet_alert_error($msg) {
    var msg = $msg ? $msg : 'Um erro desconhecido ocorreu, tente novamente mais tarde';

    swal(msg, {
        icon: 'error',
        timer: 3000
    });
}

function sweet_alert_success($msg) {
    var msg = $msg ? $msg : 'Sucesso';

    swal(msg, {
        icon: 'success',
        timer: 3000
    });
}

function clean_fields($class) {
    $("." + $class).val('');
}

/*
 * $tab indicates the next tab which should show up
 * $class indicates which fields has to be filled up before going to the next tab
 *
 * $tab indica qual tab deve aparecer
 * $class verifica quais campos são obrigatórios
 */
function next_tab($tab, $class) {
    var fields = $("." + $class);

    $(".input-group").removeClass('border-red');
    $(".select-input").removeClass('border-red');

    console.log($class);

    if (fields.length > 0) {
        var i = 0;
        var errors = localStorage.getItem('errors') ? localStorage.getItem('errors') : 0;

        while (i < fields.length) {
            if (fields[i].value === '' && fields[i].getAttribute('required') !== null) {
                var id = fields[i].id;

                $("#input-" + id).addClass('border-red');

                $("#span_" + id + "_status").css('display', 'block');

                $('html, body').animate({
                    scrollTop: $("." + $class + "-title").offset().top
                }, 1000);

                errors++;
            }

            i++;
        }

        if (errors === 0) {
            if ($tab === 0)
                $("#form").submit();

            else
                $("#user_edit_tab_" + $tab).trigger('click').removeClass('disabled');


        }
    }
}

/*
 Add or remove spinner function to element $id or $class
 */
function spinner_input($function, $id, $class) {
    if ($function) {
        if ($id) {
            $("#" + $id).addClass("loading-input");
        } else if ($class) {
            $("." + $class).addClass("loading-input");
        }
    } else {
        if ($id) {
            $("#" + $id).removeClass("loading-input");
        } else if ($class) {
            $("." + $class).removeClass("loading-input");
        }
    }

}

/*
 Validate CPF
 */
function validate_cpf($input_id) {
    var cpf = $input_id ? $("#" + $input_id).val() : $("#cpf").val();

    cpf = cpf.replace(/[^\d]+/g, '');

    if (cpf == '')
        return false;

    // Elimina CPFs invalidos conhecidos
    if (cpf.length != 11 ||
        cpf == "00000000000" ||
        cpf == "11111111111" ||
        cpf == "22222222222" ||
        cpf == "33333333333" ||
        cpf == "44444444444" ||
        cpf == "55555555555" ||
        cpf == "66666666666" ||
        cpf == "77777777777" ||
        cpf == "88888888888" ||
        cpf == "99999999999")
        return false;

    // Valida 1o digito
    add = 0;
    for (i = 0; i < 9; i++)
        add += parseInt(cpf.charAt(i)) * (10 - i);

    rev = 11 - (add % 11);

    if (rev == 10 || rev == 11)
        rev = 0;

    if (rev != parseInt(cpf.charAt(9)))
        return false;

    // Valida 2o digito
    add = 0;

    for (i = 0; i < 10; i++)
        add += parseInt(cpf.charAt(i)) * (11 - i);

    rev = 11 - (add % 11);

    if (rev == 10 || rev == 11)
        rev = 0;

    if (rev != parseInt(cpf.charAt(10)))
        return false;

    return true;
}

/*
 Validate chassis number
 */
function validate_chassis() {
    var chassis = $("#chassis").val();

    if (chassis.length < 17 && chassis.length > 0) {
        $("#span_chassis_status").css('display', 'block');

        $("#input-chassis").addClass('border-red');

        localStorage.getItem('errors') ? localStorage.setItem('errors', localStorage.getItem('errors') + 1) : localStorage.setItem('errors', 1);
    } else {
        $("#span_chassis_status").css('display', 'none');

        $("#input-chassis").removeClass('border-red');

        localStorage.getItem('errors') ? localStorage.setItem('errors', localStorage.getItem('errors') - 1) : localStorage.removeItem('errors');
    }
}



$(document).ready(function () {

    /*var id = $(this)[0].id.replace('model_id_', '');

    if (id && parseInt(id) > 0) {
        var location = window.location.pathname;

        switch (location) {
            case '/carros':

                delete_car(id);
                break;

            default:
                sweet_alert_error();
        }

    }*/

});


