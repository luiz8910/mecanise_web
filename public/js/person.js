$(function () {

    $("#email-hidden").css('display', 'none');

});

function delete_person(id)
{

    var data = {
        title: 'Atenção',
        text: 'Deseja excluir este usuário',
        icon: 'warning',
        button: 'Excluir',
        success_msg: 'Usuário excluído com sucesso',
        reload: false,
        id: id
    };

    var ajax = {
        url: '/person/' + id,
        method: 'DELETE'
    }

    sweet_alert(data, ajax);

}
