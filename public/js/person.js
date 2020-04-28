$(function () {

    $("#email-hidden").css('display', 'none');

});

function delete_person(id)
{
    var request = $.ajax({
        url: '/person/' + id,
        method: 'DELETE',
        dataType: 'json'
    });

    var data = '';

    request.done(function (e) {
        if(e.status)
        {
            data = {
                title: 'Sucesso',
                text: 'O usuário foi excluído',
                type: 'success',
                confirmButtonClass: 'btn btn-secondary'
            };

            swal(data);
        }
        else{

            data = {
                title: 'Atenção',
                text: 'Um erro ocorreu, tente novamente mais tarde',
                type: 'danger',
                confirmButtonClass: 'btn btn-danger'
            };

            swal(data);
        }
    });

    request.fail(function (e) {
        console.log('fail');
        console.log(e);

        data = {
            title: 'Atenção',
            text: 'Um erro ocorreu, tente novamente mais tarde',
            type: 'danger',
            confirmButtonClass: 'btn btn-danger'
        };

        swal(data);
    })
}
