$(function () {


    if(location.pathname.search('editar') == -1)
    {
        var today = new Date();

        var month = today.getMonth() + 1 < 10 ? '0' + (today.getMonth() + 1) : today.getMonth() + 1;

        if(today.getDate() < 10)
            var day = '0' + today.getDate();

        else
            day = today.getDate();

        today = day + '/' + month + '/' + today.getFullYear();

        $("#done_at").val(today);
        $("#conclusion_at").val(today);
    }

    /*$("#owner_id").change(function () {

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
    });*/

    $("#car_id_modal").change(function () {

        car_change('car_id_modal');
    });


    $("#owner_id").change(function () {
        //$("#car_id_input").val($(this).val());
        $.ajax({
            url: '/vehicle_by_owner/' + $(this).val() + '/' + true,
            method: 'GET',
            dataType: 'json',
            success: function (e){
                if(e.status)
                {
                    $("#car_id option").remove();
                    var append = '';

                    for(var i = 0; i < e.vehicles.length; i++)
                    {
                        append += '<option value="'+e.vehicles[i].id+'">'+e.vehicles[i].name+'</option>'
                    }

                    $("#car_id").append(append).trigger('change');
                }
                else
                {
                    swal({
                        title: "Atenção",
                        text: "Este cliente não tem nenhum veículo cadastrado, quer cadastrar um agora?",
                        icon: "warning",
                        buttons: {
                            cancel: {
                                text: "Cancelar",
                                value: null,
                                visible: true,
                                closeModal: true,
                            },
                            confirm: {
                                text: "Cadastrar",
                                value: true,
                                visible: true,
                                closeModal: true
                            }
                        }

                    }).then((value) => {
                        if(value)
                            $("#new_owner").modal('show');

                    });
                }
            },
            fail: function (e){
                console.log('fail', e);
            }
        });
    });


    $("#quantity").maskMoney({thousands:'.', decimal:','});
    $("#price_unity").maskMoney({prefix:'R$ ', allowNegative: false, thousands:'.', decimal:','});

    $(".item_order").keyup(function (e){
        if($(this).val() != "")
        {
            var id = $(this)[0].id;

            $("#span_"+id+"_status").css('display', 'none');
            $(this).removeClass('has-error').addClass("has-success");
        }
    });

    $("#type_item").change(function (){
        if($(this).val() != "")
        {
            $("#span_type_item_status").css('display', 'none');
            $(this).removeClass('has-error').addClass("has-success");
        }
    })

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

function add_item_order()
{
    var parts = $("#parts_description");
    var quantity = $("#quantity");
    var price_unity = $("#price_unity");
    var type_item = $("#type_item");
    var stop = false;

    if(parts.val() == "")
    {
        parts.addClass("has-error");
        $("#span_parts_description_status").css('display', 'block').text('Preencha o campo peça');
        stop = true;
    }
    if(quantity.val() == "")
    {
        quantity.addClass("has-error");
        $("#span_quantity_status").css('display', 'block').text("Preencha o campo quantidade");
        stop = true;
    }
    if(price_unity.val() == "")
    {
        price_unity.addClass("has-error");
        $("#span_price_unity_status").css('display', 'block').text("Preencha o campo valor unitário");
        stop = true;
    }
    if(type_item.val() == "")
    {
        type_item.addClass('has-error');
        $("#span_type_item_status").css('display', 'block').text("Preencha o campo tipo");
        stop = true;
    }

    if(stop)
        return;


    var price = price_unity.val().replace('R$', "");

    var append = "<tr>";

    append += "<th scope='row'>"+parts.val()+"</th>";
    append += "<td>"+quantity.val()+"</td>";
    append += "<td>"+price_unity.val()+"</td>";
    append += "<td>R$"+(parseFloat(price) * parseFloat(quantity.val())).toFixed(2)+"</td>";
    append += '<td><button class="btn btn-info btn-sm"><i class="fas fa-edit"></i></button>';
    append += '<button class="btn btn-danger btn-sm" style="margin-left: 5px;"><i class="fas fa-trash"></i></button></td>';
    append += "</tr>";

    $("tbody").append(append);

    parts.val("").removeClass('has-success').focus();
    price_unity.val("").removeClass('has-success');
    quantity.val("").removeClass('has-success');
    type_item.val("").removeClass('has-success');

}
