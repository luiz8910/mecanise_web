$(function (){

    $("body").keyup(function (e){
        if(e.which === 13 && $("#email").is(':focus'))
            forgot_password();
    });

    $("#password").keyup(function (){
        if(location.pathname.search('nova_senha') != -1)
            verify_password();
    });

    $("#password_confirm").keyup(function (){
        if(location.pathname.search('nova_senha') != -1)
            verify_password();
    });

});

function forgot_password()
{
    var email = $("#email").val();

    if(email === "")
        sweet_alert_error('Preencha o campo email');

    else{

        if(validateEmail(email))
        {
            $(".progress-bar").css('display', 'block');
            $(".progress").css('display', 'block');
            $("#forgot_password").css('display', 'none');

            $.ajax({
                url: '/send_link/' + email,
                method: 'GET',
                dataType: 'json',
                success: function (e){

                    if(e.status)
                        sweet_alert_success('Um email com instruções foi enviado para ' + email);

                    else
                        sweet_alert_error(e.msg);


                },
                fail: function (e){
                    sweet_alert_error();
                    console.log('fail', e);
                }

            }).always(function (){
                $("#email").val('');
                $(".progress").css('display', 'none');
                $(".progress-bar").css('display', 'none');
                $("#forgot_password").css('display', 'inline-block');
            });

        }
        else
            sweet_alert_error("Preencha um email válido");

    }
}

function verify_password()
{
    if($("#password").val() !== $("#password_confirm").val())
    {
        $("#password")
            .addClass('has-error-input')
            .removeClass('has-success-input');

        $("#password_confirm")
            .addClass('has-error-input')
            .removeClass('has-success-input');

        $("#password_span")
            .css('display', 'block')
            .css('color', 'red')
            .text('As senhas não são iguais');

        $("#btn_submit").attr('disabled', true);
    }
    else{

        if($("#password").val().length >= 8)
        {
            $("#password")
                .removeClass('has-error-input')
                .addClass('has-success-input');

            $("#password_confirm")
                .removeClass('has-error-input')
                .addClass('has-success-input');

            $("#password_span")
                .css('display', 'block')
                .css('color', 'green')
                .text('As senhas são iguais')


            $("#btn_submit").attr('disabled', null);
        }
        else{
            $("#password")
                .addClass('has-error-input')
                .removeClass('has-success-input');

            $("#password_confirm")
                .addClass('has-error-input')
                .removeClass('has-success-input');

            $("#password_span")
                .css('display', 'block')
                .css('color', 'red')
                .text('A sua nova senha deve ter pelo menos 8 caracteres');

            $("#btn_submit").attr('disabled', true);

        }

    }
}
