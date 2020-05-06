$(function () {

    $("#car_id").change(function () {

        const id = $(this).val();


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
                    console.log(e);

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
                    else{
                        append += '<option value="'+e.car.start_year+'" selected>'+e.car.start_year+'</option>';
                    }

                    $("#year").append(append);
                }
                else{
                    sweet_alert_error(e.msg);
                }
            });

            request.fail(function (e) {

                console.log('fail');
                console.log(e);
            });
        }
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

    $("#owner_id").change(function () {
        var value = $(this).val();

        $("#owner_id_input").val(value);
    });

    $(".column1").css('width', '24%');
    $(".column3").css('width', '18%');
    $(".column4").css('width', '8%');

    hide_elements();
});

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

    }

    sweet_alert()


    var request = $.ajax({
        url: '/vehicle/' + $id,
        method: 'DELETE',
        dataType: 'json'
    });

    request.done(function (e) {

        if(e.status)
        {
            $("#model_" + $id).remove();

            sweet_alert_success('O veículo foi excluído com sucesso');
        }
        else{
            sweet_alert_error();
        }
    });

    request.fail(function (e) {
        console.log('fail');
        console.log(e);
    })
}
