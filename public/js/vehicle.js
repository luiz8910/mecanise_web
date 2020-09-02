$(function () {

    $("#car_id").change(function () {
        car_change();
    });

    $("#license_plate").keydown(function (e) {
        var value = $(this).val();

        console.log(e.which);

        $(this).val(value.toUpperCase());

        for (var i = 0; i < value.length; i++)
        {
            if(value.length < 4)
            {
                if(!$("#mercosul").is(":checked"))
                    if (e.which < 65 || e.which > 90)
                        if(e.which !== 8)
                            return false;


                if((value.length === 3) && (parseInt(e.which) !== 8))
                    $(this).val(value.toUpperCase() + '-');


            }
            else{

                if(!$("#mercosul").is(":checked"))
                    if((e.which < 48 || e.which > 57))
                        if(e.which < 96 || e.which > 105)
                            if(e.which !== 8)
                                return false;

            }

        }

    }).keyup(function (e) {

        var value = $(this).val();

        $(this).val(value.toUpperCase());

        if((value.length === 3) && (parseInt(e.which) !== 8))
            $(this).val(value.toUpperCase() + '-');

    }).blur(function () {

        var len = $(this).val().length;

        if(len > 0 && len < 8)
        {
            $("#span_license_plate_status").css('display', 'block');
            $("#input-license_plate").addClass('border-red');
        }
        else{
            $("#span_license_plate_status").css('display', 'none');
            $("#input-license_plate").removeClass('border-red');
        }
    });



    $("#search-model").keyup(function () {

        if($(this).val().length > 2)
            search();

    });

    rearrange_columns();

    hide_elements();
});

function rearrange_columns()
{
    $(".column1").css('width', '24%');
    $(".column3").css('width', '18%');
    $(".column4").css('width', '8%');
}

function new_owner()
{
    $("#span_name").css('display', 'none');
    $("#span_cel").css('display', 'none');
    $("#span_cpf").css('display', 'none');

    var name = $("#modal_name").val();

    var cpf = $("#modal_cpf").val();

    var email = $("#modal_email").val();

    var cel = $("#modal_cel").val();

    var zip_code = $("#zip_code").val();

    var street = $("#street").val();

    var number = $("#number").val();

    var district = $("#district").val();

    var city = $("#city").val();

    var state = $("#state").val();

    $("#modal_name").removeClass('input-error');
    $("#modal_cel").removeClass('input-error');
    $("#modal_cpf").removeClass('input-error');

    if (name === "")
    {
        $("#modal_name").addClass('input-error');

        $("#span_name").css('display', 'block');
        return false;
    }

    if(cel === "")
    {
        $("#modal_cel").addClass('input-error');

        $("#span_cel").css('display', 'block');
        return false;
    }

    if(cpf === "")
    {
        $("#modal_cpf").addClass('input-error');

        $("#span_cpf").css('display', 'block');
        return false;
    }
    else if(cpf.length < 11){
        sweet_alert_error('CPF deve conter 11 números, você digitou ' + cpf.length);
        return false;
    }



    /*var modal = $(".modal_input");

    for(var i = 0; i < modal.length; i++) {
        if (modal[i].classList.contains('input-error')){
            break;
            console.log(modal[i]);
        }
    }*/



    $.ajax({
        url: '/person',
        method: 'POST',
        dataType: 'json',
        data:{
            'name': name,
            'cpf': cpf,
            'email': email,
            'cel': cel,
            'zip_code': zip_code,
            'street': street,
            'number': number,
            'district': district,
            'city': city,
            'state': state,
            'role_id': 4,
            'origin': 'json'
        },

    }).done(function (e) {

        if(e.status)
        {
            var append = '<option value="'+e.id+'" selected>'+name+'</option>';

            $("#owner_id").append(append);

            $("#new_owner").modal('hide');

            $("#owner_id_input").val(e.id);

            sweet_alert_success('O proprietário foi cadastrado com sucesso');
        }
        else{
            sweet_alert_error('Este proprietário já está cadastrado');
        }

    }).fail(function (e) {
        console.log('fail');
        console.log(e);

        $("#new_owner").modal('hide');

        sweet_alert_error();
    });



};

function hide_elements()
{
    $(".email").css('display', 'none');
}

function delete_vehicle($id)
{

    var data = {
        title: 'Atenção',
        text: 'Você deseja excluir este veículo?',
        button: 'Excluir',
        success_msg: 'O veículo foi excluído com sucesso',
        reload: false,
        id: $id
    }

    var ajax = {
        url: '/vehicle/' + $id,
        method: 'DELETE',
        dataType: 'json'
    }

    sweet_alert(data, ajax);
}



function search()
{
    var value = $("#search-model").val();

    localStorage.setItem('filters', true);

    var request = $.ajax({
        url: '/search-vehicles/' + value,
        method: 'GET',
        dataType: 'json'
    });

    request.done(function (e) {

        console.log(e.result);

        if (e.status)
        {
            var append = '';

            $("#tbody-search tr").remove();

            for (var i = 0; i < e.result.length; i++)
            {
                append += '<tr class="row100 body" id="model_'+e.result[i].id+'">\n' +
                    '                                <td class="cell100 column1"><a href="/editar-veiculo/'+e.result[i].id+'">'+e.result[i].model+'</a></td>\n' +
                    '                                <td class="cell100 column2">'+e.result[i].brand_name+'</td>\n' +
                    '                                <td class="cell100 column3">'+e.result[i].owner_name+'</td>\n' +
                    '                                <td class="cell100 column4">'+e.result[i].year+'</td>\n' +
                    '                                <td class="cell100 column5">\n' +
                    '                                    <div class="row">\n' +
                    '                                        <div class="dropdown">\n' +
                    '                                            <button class="btn btn-default btn-outline-primary btn-sm dropdown-toggle" type="button"\n' +
                    '                                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Status do Veículo">\n' +
                    '                                                <i class="fas fa-filter"></i>\n' +
                    '                                            </button>\n' +
                    '                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">\n' +
                    '                                                <a class="dropdown-item" href="#">\n' +
                    '                                                    <i class="fas fa-check"></i>\n' +
                    '                                                    Concluído\n' +
                    '                                                </a>\n' +
                    '                                                <a class="dropdown-item" href="#">\n' +
                    '                                                    <i class="fas fa-clock"></i>\n' +
                    '                                                    Aguardando\n' +
                    '                                                </a>\n' +
                    '                                                <a class="dropdown-item" href="#">\n' +
                    '                                                    <i class="fas fa-backward"></i>\n' +
                    '                                                    Retorno\n' +
                    '                                                </a>\n' +
                    '                                            </div>\n' +
                    '                                        </div>\n' +
                    '                                        <a href="javascript:" class="btn btn-sm btn-outline-info" title="Ordem de Serviço">\n' +
                    '                                            <i class="fas fa-file"></i>\n' +
                    '                                        </a>\n' +
                    '                                        <button class="btn btn-sm btn-outline-danger" onclick="delete_vehicle('+e.result[i].id+')" title="Excluir Veículo">\n' +
                    '                                            <i class="fas fa-trash"></i>\n' +
                    '                                        </button>\n' +
                    '                                    </div>\n' +
                    '\n' +
                    '                                </td>\n' +
                    '                            </tr>'
            }


            $("#tbody-main").css('display', 'none');

            $("#tbody-search").css('display', 'block').append(append);

            rearrange_columns();
        }
    })
}

function car_change($input_id)
{
    $input_id = $input_id ? $input_id : 'car_id'

    const id = $('#'+$input_id).val();

    if(id)
    {
        var request = $.ajax({
            url: '/car_details/' + id,
            method: 'GET',
            dataType: 'json'
        });

        request.done(function (e) {

            if(e.status)
            {

                $("#brand").val(e.car.brand);

                $("#version").val(e.car.version);

                var append = '';

                var diff = e.car.end_year - e.car.start_year;

                $("#year option").remove();

                if(diff > 0)
                {

                    for(var i = 0; i < diff + 1; i++)
                    {
                        var year = parseInt(e.car.start_year) + i;

                        if(i === 0)
                            append += '<option value="">Insira um valor</option>';

                        append += '<option value="'+year+'">'+year+'</option>';
                    }

                }
                else
                    append += '<option value="'+e.car.start_year+'" selected>'+e.car.start_year+'</option>';


                $("#year").append(append);
            }
            else
                sweet_alert_error(e.msg);

        });

        request.fail(function (e) {

            console.log('fail');
            console.log(e);

            sweet_alert_error();
        });
    }
}
