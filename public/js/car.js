$(function () {

    reduce_string();

    $("#model").change(function () {

        var model = $("#model");
        var span_valid = $("#span_valid_model");
        var span_invalid = $("#span_invalid_model");

        model.removeClass('is-valid is-invalid');
        span_invalid.css('display', 'none');
        span_valid.css('display', 'none');

        if(model.val() !== "")
        {
            spinner_input(1, 'model');

            var id = null;

            if (location.pathname.search('editar') !== -1)
                id = $("#car_id").val();


            var request = $.ajax({
                url: '/car_exists/' + model.val() + '/' + id,
                method: 'GET',
                dataType: 'json'
            });

            request.done(function (e) {
                if(e.status)
                {
                    model.addClass('is-valid');
                    spinner_input(0, 'model');

                    if(!e.id)
                        span_valid.css('display', 'block');

                }
                else{
                    model.addClass('is-invalid');
                    spinner_input(0, 'model');
                    span_invalid.css('display', 'block').text(e.msg);
                }

            });

            request.fail(function (e) {
                console.log('fail');
                console.log(e);

                spinner_input(0, 'model');
                span_invalid.css('display', 'block').text('Um erro ocorreu, tente novamente mais tarde');
            })
        }

    });

    $("#start_year").keyup(function (e) {

        var end = $("#end_year").val();
        var start = $(this).val();

        if(start.length === 4)
        {
            var today = new Date();

            if((today.getFullYear() - start) < 0)
            {
                $("#span_start_year_status").css('display', 'block').text('Insira um valor menor que o ano atual');
            }
            else{
                $("#span_start_year_status").css('display', 'none').text('Insira um ano válido');

                if(end !== "" && end < start)
                    $("#span_end_year_status").css('display', 'block').text('Insira um ano final de fabricação maior que o ano de início');

                else
                    $("#end_year").focus();
            }
        }

        else
            $("#span_start_year_status").css('display', 'block').text('Insira mais ' + (4 - ($(this).val().length)) + ' caracteres');
    });

    $("#end_year").keyup(function (e) {

        var end = $(this).val();
        var start = $("#start_year").val();


        if(end.length === 4)
        {
            var today = new Date();

            if((today.getFullYear() - end) < 0)
            {
                $("#span_end_year_status").css('display', 'block').text('Insira um valor menor que o ano atual');
            }
            else{
                $("#span_end_year_status").css('display', 'none').text('Insira um ano válido');

                if(start !== "" && end < start)
                {
                    $("#span_end_year_status").css('display', 'block').text('Insira um ano final de fabricação maior que o ano de início');
                }
            }
        }
        else{

            $("#span_end_year_status").css('display', 'block').text('Insira mais ' + (4 - ($(this).val().length)) + ' caracteres');
        }
    });

    $(".btn_brand").click(function () {

        var id = this.id.replace('btn_brand_', '');

        $("#modal_label").text("Editar Montadora: " + $("#name_brand_"+id).text());

        $("#brand_id").val(id);

        $("#modal_brand").modal('show');
    });

    $("#new_brand").click(function () {

        $("#modal_label").text('Nova Montadora');

        $("#brand_id").val('');

        $("#name").val('');

        $("#modal_brand").modal('show');
    });

    $("#modal_submit").click(function () {

        var brand_id = $("#brand_id").val();

        brand(brand_id);
    });
});

function delete_car($id)
{

    var data = {
        title: 'Atenção',
        text: 'Deseja excluir este carro?',
        icon: 'warning',
        button: 'Excluir',
        success_msg: 'O Carro foi excluído',
        reload: false,
        id: $id
    }

    var ajax = {
        url: '/carro/' + $id,
        method: 'DELETE',
    };

    return sweet_alert(data, ajax);

}

//This function works when <td> has a string long enough to break table layout
//Esta função reduz o tamanho de uma string numa <td>
function reduce_string()
{
    var model = $(".car_model");
    var version = $(".car_version");

    for (var i = 0; i < model.length; i++)
    {
        if(model[i].text.charAt(35) !== "")
        {
            var str = model[i].text.slice(0, 35);

            str += '...';

            $(".car_model")[i].text = str;
            $(".car_version")[i].innerHTML = str;
        }
    }
}

//Pagination brands list / Paginação na página de montadoras
function load_more_brands($e)
{
    var append = '';

    for (var i = 0; i < $e.model.length; i++)
    {
        append += '<tr class="row100 body" id="model_'+$e.model[i].id+'">';
        append += '<td>'+$e.model[i].name+'</td>';
        append += '<td>'+$e.model[i].qtde+'</td>';
        append += '<td><button class="btn btn-sm btn-outline-info" title="Editar Montadora"><i class="fas fa-edit"></i></button>';
        append += '<button class="btn btn-sm btn-outline-danger" onclick="feature_not_available();" title="Excluir Montadora"><i class="fas fa-trash"></i></button></td>';
        append += '</tr>';
    }

    return append;
}

//Submit a new brand or update a existing one
function brand($id)
{
    //Hides modal error
    $("#modal_error").css('display', 'none');

    //Brand name to be persisted // Montadora a ser persistida
    var name = $("#name").val();

    if (name == "")
    {
        $("#modal_error").text('Preencha o campo nome!!!').css('display', 'block');
        return false;
    }

    var request = $.ajax({
        url: '/brand_exists/' + name,
        method: 'GET',
        dataType: 'json'
    });

    request.done(function (e) {
        if(e.status)
        {
            if($id)
            {
                $.ajax({
                    url: '/brand/'+$id,
                    method: 'PUT',
                    dataType: 'json',
                    data: {'name': name},

                }).done(function (e) {
                    if(e.status)
                    {
                        sweet_alert_success(name + ' foi alterada');

                        $("#name_brand_"+$id).text(name);

                        $("#modal_brand").modal('hide');
                    }
                    else
                        sweet_alert_error();

                }).fail(function (e) {
                    console.log('fail', e);
                    sweet_alert_error();
                });
            }
            else{
                $.ajax({
                    url: '/brand',
                    method: 'POST',
                    dataType: 'json',
                    data:{'name': name}

                }).done(function (e) {
                    if(e.status)
                    {
                        sweet_alert_success(name + ' foi cadastrada com sucesso');

                        setTimeout(function () {
                            location.reload();
                        },3000);
                    }
                    else
                        sweet_alert_error();

                }).fail(function (e) {
                    console.log('fail', e);
                    sweet_alert_error();
                });
            }
        }
        else
            $("#modal_error").text('Já existe uma montadora com este nome!!!').css('display', 'block');

    });

    request.fail(function (e) {

        console.log('fail', e);

    });
}

function brand_search($e)
{
    var append = '';

    for (var i = 0; i < $e.model.length; i++)
    {
        append += '<tr class="row100 body" id="model_'+$e.model[i].id+'">';
        append += '<td id="name_brand_'+$e.model[i].id+'">'+$e.model[i].name+'</td>';
        append += '<td>'+$e.model[i].qtde+'</td>';
        append += '<td><button class="btn btn-sm btn-outline-info btn_brand" title="Editar Montadora" id="btn_brand_'+$e.model[i].id+'"><i class="fas fa-edit"></i></button>';
        append += '<button class="btn btn-sm btn-outline-danger" onclick="feature_not_available();" title="Excluir Montadora"><i class="fas fa-trash"></i></button></td>';
        append += '</tr>';
    }

    return append;
}
