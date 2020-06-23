$(function () {

    $("#system_id").change(function () {

        $("#part_id option").remove();

        var request = $.ajax({
            url: '/system_parts/' + $(this).val(),
            method: 'GET',
            dataType: 'json'
        });

        request.done(function (e) {
            if(e.status)
            {
                var append = '<option value="">Selecione uma peça</option>';


                for(var i = 0; i < e.parts.length; i++)
                {
                    append += '<option value="'+e.parts[i].id+'">'+e.parts[i].name+'</option>';
                }

                $("#part_id").append(append);
            }
            else
                sweet_alert_error();

        });

        request.fail(function (e) {
            console.log('fail', e);
            sweet_alert_error();
        });
    });

    $("#universal_code").keyup(function () {
        $("#universal_code").val($(this).val().toUpperCase());
    });

    $("#brand_id").change(function () {

        if($(this).val() !== "")
        {
            $("#car_id_fake").css('display', 'none');

            $("#car_id").css('display', 'block');

            list_cars_by_brand($(this).val());
        }

    });

    slim_select_brand();

    verify_system_parts();
});

function slim_select_brand()
{
    var select = new SlimSelect({
        select: '#brand_id',
        placeholder: 'Pesquisar'
    });

    select.setSearch('Nenhum resultado encontrado.');

    $("input[type=search]").attr('placeholder', 'Pesquisar');
}

function slim_select_car($brand_id)
{
    var select = new SlimSelect({
        select: '#car_id',
    });

    select.destroy();

    var request = $.ajax({
        url: '/teste/'+$brand_id,
        method: 'GET',
        dataType: 'json'
    });

    request.done(function (e) {

        if(e.status)
        {
            var values = [];

            for(var i = 0; i < e.cars.length; i++)
            {
                values.push({text: e.cars[i].model});
            }

            select = new SlimSelect({
                select: '#car_id',
                data: values
            });
        }
    });

    request.fail(function (e) {
        console.log('fail', e);
    });
}


function delete_part($id)
{
    var data = {
        title: 'Atenção',
        text: 'Deseja excluir esta peça?',
        icon: 'warning',
        button: 'Excluir',
        success_msg: 'A peça foi excluída',
        reload: false,
        id: $id
    }

    var ajax = {
        url: '/peca/' + $id,
        method: 'DELETE',
    };

    return sweet_alert(data, ajax);
}

function verify_system_parts()
{
    if(location.pathname.search('editar') !== -1)
    {
        $("#system_id").trigger('change');

        setTimeout(function () {
            $("#part_id").val($("#hidden_part_id").val());
        }, 500);
    }
}

//Listing cars by brand when input #brand changes
//Lista de carros por montadora
function list_cars_by_brand($brand_id)
{
    $("#car_id option").remove();

    var request = $.ajax({
        url: '/list_cars_by_brand/' + $brand_id,
        method: 'GET',
        dataType: 'json'
    });

    request.done(function (e) {
        if(e.status)
        {

            var append = "";

            for(var i = 0; i < e.cars.length; i++)
            {
                append += '<option value="'+e.cars[i].id+'">'+e.cars[i].model+'</option>';
            }

            $("#car_id").attr('readonly', null).append(append);
        }
        else{
            sweet_alert_error(e.msg);
        }
    });

    request.fail(function (e) {
        sweet_alert_error();
        console.log('fail', e);
    });
}
