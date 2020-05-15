$(function () {

    $(".column1").css('width', '10%');

    if(location.pathname.search('editar') == -1)
    {
        var today = new Date();

        var month = today.getMonth() + 1 < 10 ? '0' + (today.getMonth() + 1) : today.getMonth() + 1;

        today = today.getDate() + '/' + month + '/' + today.getFullYear();

        $("#done_at").val(today);
        $("#conclusion_at").val(today);
    }

    $("#owner_id").change(function () {

        //id = owner id
        var id = $("#owner_id_input").val();

        var request = $.ajax({
            url: '/get_vehicles/' + id,
            method: 'GET',
            dataType: 'json'
        });

        request.done(function (e) {

            if(e.status)
            {
                var append = '';

                $("#car_id_input").val('');
                $("#vehicle_id_input").val('');
                $("#car_id option").remove();

                if(e.count === 1) {
                    append += '<option value="' + e.vehicles.car_id + '" selected>' + e.vehicles.car_name + '</option>';

                    $("#car_id_input").val(e.vehicles.car_id);
                    $("#vehicle_id_input").val(e.vehicles.id);
                }else{
                    for(var i = 0; i < e.count; i++)
                    {
                        append += '<option value="'+e.vehicles[i].car_id+'">'+e.vehicles[i].car_name+'</option>';
                    }
                }

                $("#car_id").append(append);

            }
            else{
                $("#car_id option").remove();

                sweet_alert_error(e.msg);
            }
        });

        request.fail(function (e) {

            console.log('fail');
            console.log(e);

            sweet_alert_error();
        });
    });

    $("#car_id_modal").change(function () {

        car_change('car_id_modal');
    });

    $("#car_id").change(function () {
        $("#car_id_input").val($(this).val());
    });
});

function new_vehicle()
{
    var model = $("#car_id_modal").val();

    var color = $("#color").val();

    var year = $("#year").val();

    var km = $("#km").val();

    var chassis = $("#chassis").val();

    var license_plate = $("#license_plate").val();

    var owner_id = $("#owner_id_input").val() != "" ? $("#owner_id_input").val() : 0;

    if(model === "")
    {
        sweet_alert_error('Preencha o campo modelo');

        return false;
    }

    $.ajax({
        url: '/vehicle',
        method: 'POST',
        dataType: 'json',
        data:{
            'car_id': model,
            'color': color,
            'year': year,
            'km': km,
            'chassis': chassis,
            'license_plate': license_plate,
            'owner_id': owner_id,
            'origin': 'json'
        }

    }).done(function (e) {
        if(e.status)
        {
            console.log(e);

            var append = '<option value="'+e.id+'" selected>'+e.name+'</option>';

            $("#car_id").append(append);

            $("#new_vehicle").modal('hide');

            $("#vehicle_id_input").val(e.id);

            $("#car_id_input").val(model);

            sweet_alert_success('O veículo foi cadastrado com sucesso');
        }
        else
            sweet_alert_error(e.msg);


    }).fail(function (e) {
        console.log('fail', e);

        sweet_alert_error();
    })
}

function delete_order($id)
{
    var data = {
        title: 'Atenção',
        text: 'Você deseja excluir esta OS?',
        button: 'Excluir',
        success_msg: 'Esta OS foi excluída com sucesso',
        reload: false,
        id: $id
    }

    var ajax = {
        url: '/os/'+$id,
        method: 'DELETE',
        dataType: 'json'
    }

    sweet_alert(data, ajax);
}
