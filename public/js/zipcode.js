$(function () {

    spinner_input(1, "spinner_zip_code");
    //Quando o campo cep perde o foco.
    $("#zip_code").keyup(function() {

        //Nova variável "cep" somente com dígitos.
        var zip = $(this).val().replace(/\D/g, '');

        if(zip.length === 8)
        {
            zip_code(zip);
        }
    });


});

function limpa_formulario_cep() {
    // Limpa valores do formulário de cep.
    $("#street").val("");
    $("#district").val("");
    $("#city").val("");
}

function zip_code($zip_code)
{

    //Verifica se campo cep possui valor informado.
    if ($zip_code !== "")
    {

        //Expressão regular para validar o CEP.
        var validacep = /^[0-9]{8}$/;

        //Valida o formato do CEP.
        if(validacep.test($zip_code)) {
            spinner_input(1, "spinner_zip_code");
            //Preenche os campos com "..." enquanto consulta webservice.

            /*$("#street").val("...");
             $("#neighborhood").val("...");
             $("#city").val("...");*/

            //Consulta o webservice viacep.com.br/
            $.getJSON("//viacep.com.br/ws/"+ $zip_code +"/json/?callback=?", function(dados) {

                if (!("erro" in dados)) {
                    //Atualiza os campos com os valores da consulta.
                    setTimeout(function () {
                        spinner_input(0, "spinner_zip_code");
                        $("#street").val(dados.logradouro);
                        $("#number").focus();
                        $("#district").val(dados.bairro);
                        $("#city").val(dados.localidade);
                        $("#state").val(dados.uf);
                    }, 2000);


                } //end if.
                else {
                    //CEP pesquisado não foi encontrado.
                    limpa_formulario_cep();
                    spinner_input(0, "spinner_zip_code");
                }
            });
        } //end if.
        else {
            //cep é inválido.
            limpa_formulario_cep();
            spinner_input(0, "spinner_zip_code");
        }
    } //end if.
    else {
        //cep sem valor, limpa formulário.
        spinner_input(0, "spinner_zip_code");
        limpa_formulario_cep();
    }
}

function loading_zip_code($status)
{

}
