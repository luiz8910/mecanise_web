$(function () {

    $("#model").change(function () {

        var model = $("#model");
        var span_valid = $("#span_valid_model");
        var span_invalid = $("#span_invalid_model");

        model.removeClass('is-valid is-invalid');
        span_invalid.css('display', 'none');
        span_valid.css('display', 'none');

        if(model.val() !== "")
        {
            spinner_input(1, 'model');

            var id = null;

            if (location.pathname.search('editar') !== -1)
                id = $("#car_id").val();


            var request = $.ajax({
                url: '/car_exists/' + model.val() + '/' + id,
                method: 'GET',
                dataType: 'json'
            });

            request.done(function (e) {
                if(e.status)
                {
                    model.addClass('is-valid');
                    spinner_input(0, 'model');

                    if(!e.id)
                        span_valid.css('display', 'block');

                }
                else{
                    model.addClass('is-invalid');
                    spinner_input(0, 'model');
                    span_invalid.css('display', 'block').text(e.msg);
                }

            });

            request.fail(function (e) {
                console.log('fail');
                console.log(e);

                spinner_input(0, 'model');
                span_invalid.css('display', 'block').text('Um erro ocorreu, tente novamente mais tarde');
            })
        }

    });

    $("#start_year").keyup(function (e) {

        var end = $("#end_year").val();
        var start = $(this).val();

        if(start.length === 4)
        {
            var today = new Date();

            if((today.getFullYear() - start) < 0)
            {
                $("#span_start_year_status").css('display', 'block').text('Insira um valor menor que o ano atual');
            }
            else{
                $("#span_start_year_status").css('display', 'none').text('Insira um ano válido');

                if(end !== "" && end < start)
                    $("#span_end_year_status").css('display', 'block').text('Insira um ano final de fabricação maior que o ano de início');

                else
                    $("#end_year").focus();
            }
        }

        else
            $("#span_start_year_status").css('display', 'block').text('Insira mais ' + (4 - ($(this).val().length)) + ' caracteres');
    });

    $("#end_year").keyup(function (e) {

        var end = $(this).val();
        var start = $("#start_year").val();


        if(end.length === 4)
        {
            var today = new Date();

            if((today.getFullYear() - end) < 0)
            {
                $("#span_end_year_status").css('display', 'block').text('Insira um valor menor que o ano atual');
            }
            else{
                $("#span_end_year_status").css('display', 'none').text('Insira um ano válido');

                if(start !== "" && end < start)
                {
                    $("#span_end_year_status").css('display', 'block').text('Insira um ano final de fabricação maior que o ano de início');
                }
            }
        }
        else{

            $("#span_end_year_status").css('display', 'block').text('Insira mais ' + (4 - ($(this).val().length)) + ' caracteres');
        }
    });

});

function delete_car($id)
{

    var data = {
        title: 'Atenção',
        text: 'Deseja excluir este carro?',
        icon: 'warning',
        button: 'Excluir',
        success_msg: 'O Carro foi excluído',
        reload: false,
        id: $id
    }

    var ajax = {
        url: '/carro/' + $id,
        method: 'DELETE',
    };

    return sweet_alert(data, ajax);

}



