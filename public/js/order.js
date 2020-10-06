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
        //$("#conclusion_at").val(today);
    }

    $("#owner_id").select2();

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

    //localStorage.removeItem('timestamp');


    /*$("#input_owner").keyup(function (e){

        $(".dropdown-content a").remove();
        $("#owner_id").val("");

        if($(this).val() != "")
        {

            $.ajax({
                url: '/search_people_all/' + $(this).val(),
                method: "GET",
                dataType: 'json',
                success: function (e){

                    if(e.status)
                    {
                        console.log(e.result);

                        var append = '';

                        for(var i = 0; i < e.result.length; i++)
                        {
                            append += '<a href="javascript:" id="result_' + e.result[i].id + '" onclick="select_owner(' + e.result[i].id + ')">' + e.result[i].name + '</a>';
                        }

                        $(".dropdown-content").append(append);

                        $(".dropdown-content a").css('display', 'block');

                    }

                },
                fail: function (e){
                    console.log('fail', e);
                    sweet_alert_error();
                }
            });
        }


        /!*var drop = $(".dropdown-content");

        if($(this).val() != "")
        {
            $(".dropdown-content a").remove();
            $("#owner_id").val("");

            //Digita rápido agora usuário corno Filha da puta do caraio
            //Timestamp UNIX
            var timestamp = new Date().getTime();

            console.log(timestamp);

            //Whether execute or not the ajax request
            //Verifica se deve executar a requisição ajax
            var request = false;

            //If timestamp was previously stored
            if(localStorage.getItem('timestamp'))
            {
                var ts_storage = localStorage.getItem('timestamp');

                console.log("ts_storage: " + ts_storage);

                //If 500 ms was passed since last character typed
                if(parseInt(timestamp) - parseInt(ts_storage) > 500)
                    request = true;


                console.log("result: " + (parseInt(timestamp) - parseInt(ts_storage)));

                localStorage.removeItem('timestamp');
                localStorage.setItem('timestamp', timestamp);

            }
            //If not, means the first character was typed, then the request is permitted
            else
            {
                localStorage.setItem('timestamp', timestamp);

                request = true;
            }

            console.log('request: ' + request);
            console.log('post timestamp: ' + localStorage.getItem('timestamp'));

            if(request)
            {

            }
            else
                return false;
        }
        else
            localStorage.clear();*!/

    })
        .blur(function (){

            //Fix blur and selected option
            setTimeout(function (){

                $(".dropdown-content a").css('display', 'none');
            }, 250);
        })
        .click(function (){
            if($(this).val())
                $(".dropdown-content a").css('display', 'block');
        })
    ;*/

    $("#car_id").change(function () {

        car_change();
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
                        append += '<option value="'+e.vehicles[i].car_id+'">'+e.vehicles[i].name+'</option>'
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
                            $("#new_vehicle").modal('show');

                    });
                }
            },
            fail: function (e){
                console.log('fail', e);
            }
        });
    });


    $("#quantity").maskMoney({thousands:'.', decimal:','});
    $("#price_unity").maskMoney({prefix:'R$ ', allowNegative: false, allowZero: true, thousands:'.', decimal:','});

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
    });

    $("body").keypress(function (e){
        //If any item_order class has focus and the user press enter,
        // the method add_item_order() will be fired.
        if(e.which == 13 && $(".item_order").is(":focus"))
        {
            e.preventDefault();
            $("#add_item").focus();
            add_item_order();
        }

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

    var owner_id = $("#owner_id").val() != "" ? $("#owner_id").val() : 0;

    if(model === "")
    {
        sweet_alert_error('Preencha o campo modelo');

        return;
    }

    console.log('model: ' + model);

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

            $("#car_id").val(model);

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

    //If error return false;
    if(stop)
        return;

    $("#items_table").css('display', 'block');
    $("#total").css("display", 'block');

    var price = price_unity.val().replace('R$', "");
    price = price.replace('.', '');
    price = price.replace(',', '.');
    //price = price.replace('-', ',');

    var q = quantity.val().replace(".", '');
    q = q.replace(',', '.');
    //q = q.replace('-', ',');

    var total = (parseFloat(price) * parseFloat(q)).toFixed(2);
    total = total.replace(',', '-');
    total = total.replace('.', ',');
    total = total.replace('-', '.');

    var code = (Math.floor(Math.random() * 10000) + 1).toString();
    var append = '<tr id="'+code+'">';

    append += "<th scope='row'>"+parts.val()+"</th>";
    append += "<td>"+quantity.val()+"</td>";
    append += "<td>"+price_unity.val()+"</td>";
    append += "<td id='td_total_"+code+"'>R$ "+total+"</td>";
    append += '<td><button type="button" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></button>';
    append += '<button type="button" class="btn btn-danger btn-sm" onclick="delete_item('+code+')" style="margin-left: 5px;"><i class="fas fa-trash"></i></button></td>';
    append += "</tr>";

    $("tbody").append(append);

    var value = $("#hidden_total").val() ? parseFloat($("#hidden_total").val()) : 0;

    value = parseFloat(value) + parseFloat(total);
    $("#hidden_total").val(value.toFixed(2));
    $("#total").text('Total: R$ ' + value.toFixed(2));

    parts.val("").removeClass('has-success').focus();
    price_unity.val("").removeClass('has-success');
    quantity.val("").removeClass('has-success');
    type_item.val("").removeClass('has-success');

}

function delete_item($code)
{
    var line_total = $("#td_total_" + $code).text();

    line_total = parseFloat(line_total.replace('R$', ""));

    var total = parseFloat($("#hidden_total").val());

    total -= line_total;

    $("#hidden_total").val(total);

    $("#total").text('Total: R$ ' + total.toFixed(2));

    $("#"+$code).remove();

    if($("tbody tr").length == 0)
    {
        $("#total").css("display", 'none');
        $("#items_table").css('display', 'none');
    }

}

function select_owner($id)
{
    var text = $("#result_"+$id).text();

    $("#owner_id").val($id).trigger('change');

    $("#input_owner").val(text);

    //car_change('car_id');
}

function search_owner($input)
{

}
