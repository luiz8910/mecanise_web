$(function () {

});

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
