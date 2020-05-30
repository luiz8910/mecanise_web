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

    //When loading disable next-tab button
    $('.next-tab').attr('disabled', null);

    //When loading disable submit button
    $('.submit').attr('disabled', null);

    //Used to limit user typing to numbers
    //Limita o usuário a digitar apenas números
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

    //Do not allow input type number to add "e" character
    //Não permite campos do tipo número de conter o caracter "e"
    $("input[type=number]").keydown(function (e) {

        if (e.which === 69)
            return false;
    });

    //When CPF field changes / Quando o campo cpf muda de valor
    $("#cpf").change(function () {
        //Pre cpf validation / Validação preliminar do CPF
        before_validate_cpf();
    });

    //When CPF field inside a modal changes / Quando um cpf dentro do modal muda de valor
    $("#modal_cpf").change(function () {

        before_validate_cpf('modal_cpf');
    });

    //Chassis validation when input field changes
    // Quando o campo chassis tem seu valor alterado ocorre a validação do mesmo
    $("#chassis").change(function () {
        validate_chassis();
    });


    /*$(".search-model").click(function () {
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

    });*/

    //Quando o proprietário muda / When the owner changes
    $("#owner_id").change(function () {
        var value = $(this).val();

        $("#owner_id_input").val(value);
    });


    //Format a date value / Formata uma data
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


    //Gambiarra para dar um efeito de animação no ícone pesquisa
    //Animation of search icon
    setTimeout(function () {
        $("#general-search-icon").css('display', 'inline-block');
    }, 2000);



    //When hovered, shows up the user options
    $(".icon-profile").mouseenter(function () {
        $(".profile-settings-box").css('display', 'inline-block');
    });

    //When hovered out, hide user options
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

    //Fires when $this has new inputs
    //Evento dispara ao digitar
    $("#general-search-input").keyup(function (e) {

        //Gambiarra monstra para diminuir a velocidade de digitação do usuário corno
        //A way to slow down user when typing
        setTimeout(function () {
            $(this).attr('disabled', true);
        }, 500);

        //Parte final da gambiarra acima
        //Final part of the "fix" above
        $(this).attr('disabled', false);

        //If search field is blank / Se o campo pesquisa estiver em branco
        if($(this).val() == "")
        {
            //Shows up the search icon / Mostra o ícone de pesquisa
            $("#general-search-icon").css('display', 'inline-block');

            //Hide the X icon / Esconde o ícone X
            $("#general-search-icon-close").css('display', 'none');

            //Shows up the initial table / Mostra a tabela inicial
            $("#tbody-search").css('display', 'none');

            //Hide the table with search results / Esconde a tabela com resultados da pesquisa
            $("#tbody-main").css("display", 'table-row-group');

            //Hide the information of no results found / Esconde a info de resultados não encontrados
            $(".no-results").css('display', 'none');

            //Shows up the pagination button
            $(".load-more").css('display', 'inline-block');
        }
        else{
            //Ajax search request / Requisição de pesquisa
            search_model();

            //Hide the search icon / Esconde o ícone de pesquisa
            $("#general-search-icon").css('display', 'none');

            //Shows up the X icon / Mostra o ícone X
            $("#general-search-icon-close").css('display', 'inline-block');
        }
    });

    //When $this was clicked / Quando o ícone fechar for clickado
    $("#general-search-icon-close").click(function () {

        //Input search value is now blank / Campo pesquisa está vazio
        $("#general-search-input").val("");

        //Hide the table with search results / Esconde a tabela com resultados da pesquisa
        $("#tbody-search").css('display', 'none');

        //Shows up the initial table / Mostra a tabela inicial
        $("#tbody-main").css("display", 'table-row-group');

        //Shows up the search icon / Mostra o ícone de pesquisa
        $("#general-search-icon").css('display', 'inline-block');

        //Hide the X icon / Esconde o ícone X
        $("#general-search-icon-close").css('display', 'none');

        //Hide the information of no results found / Esconde a info de resultados não encontrados
        $(".no-results").css('display', 'none');

        //Shows up the pagination button
        $(".load-more").css('display', 'inline-block');
    });
});

//Searchs any model / Procura dados em qualquer classe
function search_model()
{
    //Actual url / Url atual
    var page = location.pathname;

    var url = '';

    //Value of input search / Valor do campo pesquisa
    var input = $("#general-search-input").val();

    //If page is "/" or "carros" we must search for table cars
    //Se page é = "/" ou é igual a "carros", procura-se por tabela carros
    switch (page) {
        case '/':
            url = '/car_search/' + input;
            break;

        case '/carros':
            url = '/car_search/' + input;
            break;

        default: url = null; break;
    }

    //If url, so search for the given model
    if(url)
    {
        //Beginning of ajax search request / Ínicio da requisição ajax
        var request = $.ajax({
            url: url,
            method: 'GET',
            dataType: 'json'
        });

        request.done(function (e) {
            if(e.status)
            {
                //Hide the initial table / Esconde a tabela inicial
                $("#tbody-main").css('display', 'none');

                //Remove tr tags from search results table / Remove tags tr da tabela de resultados
                $("#tbody-search tr").remove();

                //Remove info of no results fount / Remover <p> de nenhum resultado encontrado
                $(".no-results").css('display', 'none');

                var append = '';

                //If has any results / Se houver qualquer resultado
                if(e.model.length > 0)
                {
                    //Hide the pagination button / Esconde o botão de paginação
                    $(".load-more").css('display', 'none');

                    //Iterate over array model which containing all search results
                    //Iteração no array model que contém todos os resultados da pesquisa
                    for (var i = 0; i < e.model.length; i++)
                    {
                        //Used to know how much columns we should print
                        //Usado para saber quantas colunas devemos exibir
                        var columns = 0;

                        //Tr tag which contains the entire row, we need the id model to delete the right row
                        //in case the user delete a model
                        append += '<tr class="row100 body" id="model_'+e.model[i].column_0+'">';

                        //Displays id from model / Exibe o id da classe
                        append += '<th scope="row">'+e.model[i].column_0+'</th>';

                        //Displays model´s column name and the link to edit
                        //Exibe a coluna nome da classe correspondente e o link para edição
                        append += '<td><a href="'+e.edit+e.model[i].column_0+'">'+e.model[i].column_1+'</a></td>';

                        //Iterate over the remaining columns / Iteração nas colunas restantes
                        for(var x = 2; x < e.columns; x++)
                        {
                            //Used to know which column we are at the moment
                            //Usado para saber qual coluna estamos
                            var c = 'column_' + x;

                            //Display <td> content
                            //Exibe o conteúdo da tag <td>
                            append += '<td>'+e.model[i][c]+'</td>';
                        }

                        //<td> and href link of a edit button / <td> e link para edição
                        append += '<td><a href="'+e.edit+e.model[i].column_0+'" class="btn btn-sm btn-outline-info" title="Editar">';
                        append += '<i class="fas fa-edit"></i></a>';

                        //Button delete / Botão Excluir
                        append += '<button class="btn btn-sm btn-outline-danger" onclick="delete_model('+e.model[i].column_0+')" title="Excluir">';
                        append += '<i class="fas fa-trash"></i></button></td>';
                    }

                    //Finally displays search results / Exibe os resultados da pesquisa
                    $("#tbody-search").css('display', 'table-row-group').append(append);
                }
                //If has not any results / Senão houver resultados
                else{
                    sweet_alert_error('Nenhum resultado encontrado');
                    $(".no-results").css('display', 'block');
                }

            }
        });

        //When request fails it shows the log at console
        //Exibe erros no console
        request.fail(function (e) {
            console.log('fail', e);

            //Error alert message / Mensagem de erro em um alerta
            sweet_alert_error();
        });
    }


}

//Used to verify which model has to be deleted
//Usado para verificar qual classe deve ser excluída
function delete_model($id)
{
    var page = location.pathname;

    switch (page) {
        case '/':
            delete_car($id);
            break;

        case '/carros':
            delete_car($id);
            break;
    }
}

//Load more data to increase list (infinite pagination)
//Carrega mais dados para aumentar o tamanho da lista (paginação infinita)
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

        case '/montadoras':
            url = '/brand_pagination/' + offset;
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

            if(page === '/montadoras')
                append = load_more_brands(e);

            else{

                for (var i = 0; i < e.cars.length; i++)
                {
                    var start_year = e.cars[i].start_year != null ? e.cars[i].start_year : '';
                    var end_year = e.cars[i].end_year != null ? e.cars[i].end_year : '';

                    append += '<tr class="row100 body" id="model_'+e.cars[i].id+'">'+
                        '<th scope="row">'+e.cars[i].id+'</th>'+
                        '<td><a href="'+e.edit+e.cars[i].id+'">'+e.cars[i].model+'</a></td>'+
                        '<td>'+e.cars[i].brand_name+'</td>'+
                        '<td><span>'+e.cars[i].fuel_name+'</span></td>'+
                        '<td>'+start_year+'</td>'+
                        '<td>'+end_year+'</td>'+
                        '<td><a href="'+e.edit+e.cars[i].id+'" class="btn btn-sm btn-outline-info" title="Editar">' +
                        '<i class="fas fa-edit"></i>' +
                        '          </a> '+
                        '          <button class="btn btn-sm btn-outline-danger" onclick="delete_car('+e.cars[i].id+')" title="Excluir">' +
                        '               <i class="fas fa-trash"></i>' +
                        '          </button>'+
                        '      </td>'+
                        '</tr>';
                }

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

/*
    Before user identification is validated,
    verify if cpf fields has 11 characters

    Antes de validar se o cpf é valido, verifica-se
    o cpf tem 11 caracteres
* */
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

//Generic Ajax Request / Requisição ajax genérica
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
    //Every input which has target $class
    var fields = $("." + $class);

    $(".input-group").removeClass('border-red');
    $(".select-input").removeClass('border-red');

    //If has at least one field of the given $class
    //Se pelo menos um campo com a $class informada for encontrado
    if (fields.length > 0) {
        var i = 0;
        var errors = localStorage.getItem('errors') ? localStorage.getItem('errors') : 0;

        while (i < fields.length) {

            //If a required input wasn't filled.
            //Se um campo obrigatório não foi preenchido.
            if (fields[i].value === '' && fields[i].getAttribute('required') !== null) {
                var id = fields[i].id;

                $("#input-" + id).addClass('border-red');

                $("#span_" + id + "_status").css('display', 'block');

                //Scroll to input with error
                $('html, body').animate({
                    scrollTop: $("." + $class + "-title").offset().top
                }, 1000);

                errors++;
            }

            i++;
        }

        //If no errors / Se não houver erros
        if (errors === 0) {
            if ($tab === 0) //If there is no others tabs to fill in / Senão houver outras tabs
                $("#form").submit(); //then the form can be persisted normally / Formulário submetido

            else //If has others tabs and no errors, remove disabled class from next tab title
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

function feature_not_available()
{
    sweet_alert_error('Este recurso ainda não está disponível, tente novamente mais tarde');
}
