$(function () {

    $("#cpf").keyup(function (e){

        var i = 0;
        var temp = '';
        var loading = $('.loader-wrap');

        var cpf = $(this).val();

        var length = $(this)[0].value.length;

        if(length === 3 && e.which !== 8)
        {
            cpf = cpf + '.';

            $(this).val(cpf);
        }
        else if(length === 4)
        {
            if(cpf.charAt(3) !== '.')
            {
                while (i < length)
                {
                    if(i === 2)
                        temp = temp + cpf.charAt(i) + '.';

                    else
                        temp = temp + cpf.charAt(i);

                    i++;
                }

                $(this).val(temp);
            }
        }
        else if(length === 7 && e.which !== 8)
        {
            cpf = cpf + '.';

            $(this).val(cpf);
        }
        else if(length === 8)
        {
            if(cpf.charAt(7) !== '.')
            {
                i = 0
                temp = '';

                while (i < length)
                {
                    if(i === 6)
                        temp = temp + cpf.charAt(i) + '.';

                    else
                        temp = temp + cpf.charAt(i);

                    i++;
                }

                $(this).val(temp);
            }
        }
        else if(length === 11 && e.which !== 8)
        {
            cpf = cpf + '-';

            $(this).val(cpf);
        }
        else if(length === 12)
        {
            if(cpf.charAt(11) !== '-')
            {
                i = 0;
                temp = '';

                while (i < length)
                {
                    if(i === 10)
                        temp = temp + cpf.charAt(i) + '-';

                    else
                        temp = temp + cpf.charAt(i);

                    i++;
                }

                $(this).val(temp);
            }
        }
        else if(length === 14)
        {
            if(validate_cpf())
            {

                loading.css('display', 'block');

                if(location.pathname.search('editar') != -1)
                    allowed_cpf($(this).val());
                else
                    allowed_cpf($(this).val(), $("#person_id").val());


            }
            else{
                $("#cpf")
                    .removeClass('has-success')
                    .addClass('has-error');

                $("#span_cpf_status")
                    .addClass('text-danger')
                    .removeClass('text-success')
                    .css('display', 'block')
                    .text('Entre com um CPF válido');
            }

            setTimeout(function (){

                loading.css('display', 'none');
            }, 2000);
        }

    });
});



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

function allowed_cpf($cpf, $id)
{
    var url = $id ? 'cpf_exists/' +$cpf+ '/' + $id : 'cpf_exists/' + $cpf;

    $.ajax({
        url: url,
        method: 'GET',
        dataType: 'json',
        success: function (e){
            if(e.status)
            {
                $("#cpf")
                    .addClass('has-success')
                    .removeClass('has-error');

                $("#span_cpf_status")
                    .removeClass('text-danger')
                    .addClass('text-success')
                    .css('display', 'block')
                    .text('CPF válido');
            }
            else{
                $("#cpf")
                    .removeClass('has-success')
                    .addClass('has-error');

                $("#span_cpf_status")
                    .addClass('text-danger')
                    .removeClass('text-success')
                    .css('display', 'block')
                    .text('Este CPF já está em uso.');
            }
        },
        fail: function (e){
            console.log('fail', e);
            sweet_alert_error();
            return;
        }
    });
}

/*
 * Update pagination value
 */
function form_config()
{
    $.ajax({
        url: '/pagination',
        method: 'POST',
        dataType: 'json',
        data: {
            'pagination': $("#pagination").val()
        }

    }).done(function (e) {
        if(e.status)
            sweet_alert_success('Paginação alterada com sucesso');

        else
            sweet_alert_error();

    }).fail(function (e) {
        console.log('fail', e);
        sweet_alert_error();
    });
}
