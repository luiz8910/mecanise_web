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
            //console.log(cpf.search('.'));
            if(cpf.search('.') == 0)
            {
                temp = '';

                for(i = 0; i < 11; i++)
                {
                    if(!isNaN(cpf.charAt(i)))
                        temp += cpf.charAt(i);

                }

                console.log(temp);

                cpf = temp.charAt(0) + temp.charAt(1) + temp.charAt(2) + '.' + temp.charAt(3) + temp.charAt(4) + temp.charAt(5) + '.'
                    + temp.charAt(6) + temp.charAt(7) + temp.charAt(8) + '-' + temp.charAt(9) + temp.charAt(10);

                $(this).val(cpf);

                if(cpf.length == 14)
                    cpf_full_length();
            }
            else{
                cpf = cpf + '-';

                $(this).val(cpf);
            }

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
            cpf_full_length();


    });


    $("#cnpj").keyup(function (e){

        if($(this).val().length == 14 || ($(this).val().length == 18))
        {
            if(validate_cnpj($(this).val())){
                $(this).addClass('has-success').removeClass('has-error');

                $("#span_cnpj_status")
                    .removeClass('text-danger')
                    .addClass('text-success')
                    .css('display', 'block')
                    .text('CNPJ Válido');
            }


            else{
                $(this).addClass('has-error').removeClass('has-success');

                $("#span_cnpj_status")
                    .addClass('text-danger')
                    .removeClass('text-success')
                    .css('display', 'block')
                    .text('CNPJ Inválido');
            }
        }
    });


});

function cpf_full_length()
{
    var loading = $('.loader-wrap');

    //var cpf = $input_id ? $("#" + $input_id).val() : $("#cpf").val();

    if(validate_cpf())
    {
        $("#new_owner").modal('hide');
        loading.css('display', 'block');

        if(location.pathname.search('veiculo') != -1)
        {
            if(location.pathname.search('editar') != -1)
                allowed_cpf($("#cpf").val());
            else
                allowed_cpf($("#cpf").val(), $("#person_id").val());

        }
        else
            allowed_cpf($("#cpf").val());

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
        $("#new_owner").modal('show');
    }, 2000);
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

function validate_cnpj(cnpj) {

    cnpj = cnpj.replace(/[^\d]+/g,'');

    if(cnpj == '')
        return false;

    if (cnpj.length != 14)
        return false;

    // Elimina CNPJs invalidos conhecidos
    if (cnpj == "00000000000000" ||
        cnpj == "11111111111111" ||
        cnpj == "22222222222222" ||
        cnpj == "33333333333333" ||
        cnpj == "44444444444444" ||
        cnpj == "55555555555555" ||
        cnpj == "66666666666666" ||
        cnpj == "77777777777777" ||
        cnpj == "88888888888888" ||
        cnpj == "99999999999999")
        return false;

    // Valida DVs
    tamanho = cnpj.length - 2
    numeros = cnpj.substring(0,tamanho);
    digitos = cnpj.substring(tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
        soma += numeros.charAt(tamanho - i) * pos--;
        if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(0))
        return false;

    tamanho = tamanho + 1;
    numeros = cnpj.substring(0,tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
        soma += numeros.charAt(tamanho - i) * pos--;
        if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(1))
        return false;

    return true;

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

function validateEmail($email)
{
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test($email);
}

