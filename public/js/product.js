
function delete_product(id)
{

    var request = $.ajax({
        url: '/product/' + id,
        method: 'DELETE',
        dataType: 'json'
    });

    request.done(function (e) {

        if(e.status)
        {
            var data = {
                title: 'Sucesso',
                text: 'O produto selecionado foi excluído',
                type: 'success',
                confirmButtonClass: 'btn btn-success'
            };

            swal(data);

        }else{

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
    });
}
