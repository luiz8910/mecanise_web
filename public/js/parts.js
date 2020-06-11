$(function () {

    $("#system_id").change(function () {

        $("#part_id option").remove();

        var request = $.ajax({
            url: '/system_parts/' + $(this).val(),
            method: 'GET',
            dataType: 'json'
        });

        request.done(function (e) {
            if(e.status)
            {
                var append = '<option value="">Selecione uma peça</option>';


                for(var i = 0; i < e.parts.length; i++)
                {
                    append += '<option value="'+e.parts[i].id+'">'+e.parts[i].name+'</option>';
                }

                $("#part_id").append(append);
            }
            else
                sweet_alert_error();

        });

        request.fail(function (e) {
            console.log('fail', e);
            sweet_alert_error();
        });
    });

    $("#universal_code").keyup(function () {
        $("#universal_code").val($(this).val().toUpperCase());
    });

    verify_system_parts();
});

function delete_part($id)
{
    var data = {
        title: 'Atenção',
        text: 'Deseja excluir esta peça?',
        icon: 'warning',
        button: 'Excluir',
        success_msg: 'A peça foi excluída',
        reload: false,
        id: $id
    }

    var ajax = {
        url: '/peca/' + $id,
        method: 'DELETE',
    };

    return sweet_alert(data, ajax);
}

function verify_system_parts()
{
    if(location.pathname.search('editar') !== -1)
    {
        $("#system_id").trigger('change');

        setTimeout(function () {
            $("#part_id").val($("#hidden_part_id").val());
        }, 500);
    }
}
