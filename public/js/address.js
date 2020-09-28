$(function () {

    //Quando o campo cep muda.
    //When zipCode changes
    $("#zip_code").keyup(function(e) {

        //var $cep = $(this).val().replace(/\D/g, '');

        var cep = $(this).val();

        var zip = $(this)[0].value.length;

        if(zip === 9)
        {

            read_only(true);

            find_cep(cep);
        }
        else if(zip === 5)
        {

            if(e.which !== 8)
            {
                cep = cep + '-';

                $(this).val(cep);
            }
        }

    });


});

function clean_fields() {
    // Limpa valores do formulário de cep.
    $("#street").val("");
    $("#number").val("");
    $("#address_reference").val("");
    $("#district").val("");
    $("#city").val("");
    $("#state").val("");


}

function read_only($status)
{
    if($status)
    {
        $("#street").attr('disabled', true);
        $("#number").attr('disabled', true);
        $("#address_reference").attr('disabled', true);
        $("#district").attr('disabled', true);
        $("#city").attr('disabled', true);
        $("#state").attr('disabled', true);
    }
    else{
        $("#street").attr('disabled', null);
        $("#number").attr('disabled', null);
        $("#address_reference").attr('disabled', null);
        $("#district").attr('disabled', null);
        $("#city").attr('disabled', null);
        $("#state").attr('disabled', null);
    }



}

function find_cep($cep)
{

    var loading = $('.loader-wrap');

    loading.css('display', 'block');
    $("#new_owner").modal('hide');

    //Verifica se campo cep possui valor informado.
    if ($cep !== "") {

        $cep = $cep.replace('-', '');

        //Expressão regular para validar o CEP.
        var validacep = /^[0-9]{8}$/;

        //Valida o formato do CEP.
        if(validacep.test($cep)) {
            //$(".input-address").css('display', 'none');
            //$(".div-loading").css('display', 'block');
            //Preenche os campos com "..." enquanto consulta webservice.

            /*$("#street").val("...");
             $("#neighborhood").val("...");
             $("#city").val("...");*/

            //Consulta o webservice viacep.com.br/
            $.getJSON("//viacep.com.br/ws/"+ $cep +"/json/?callback=?", function(dados) {

                if (!("erro" in dados)) {
                    //Atualiza os campos com os valores da consulta.
                    setTimeout(function () {
                        loading.css('display', 'none');
                        $("#new_owner").modal('show');
                        //$(".input-address").css('display', 'block');
                        $("#street").val(dados.logradouro);
                        $("#number").val('').focus();
                        $("#district").val(dados.bairro);
                        $("#city").val(dados.localidade);
                        $("#state").val(dados.uf);
                    }, 2000);

                } //end if.
                else {
                    //CEP pesquisado não foi encontrado.
                    clean_fields();
                    loading.css('display', 'none');
                    $("#new_owner").modal('show');
                    //$(".input-address").css('display', 'block');
                }
            });
        } //end if.
        else {
            //cep é inválido.
            clean_fields();
            loading.css('display', 'none');
            $("#new_owner").modal('show');
            //$(".input-address").css('display', 'block');
        }
    } //end if.
    else {
        //cep sem valor, limpa formulário.
        loading.css('display', 'none');
        $("#new_owner").modal('show');
        //$(".input-address").css('display', 'block');
        clean_fields();
    }

    read_only(null);
}
