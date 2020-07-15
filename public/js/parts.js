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
                    if(e.parts[i].id === 1)
                        append += '<option value="'+e.parts[i].id+'" selected>'+e.parts[i].name+'</option>';

                    else
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

    }).trigger('change');

    $("#universal_code").keyup(function () {
        $("#universal_code").val($(this).val().toUpperCase());
    });

    $("#brand_id").change(function () {

        if($(this).val() !== "")
        {
            $("#car_id_fake").css('display', 'none');

            $("#car_id").css('display', 'block');

            list_cars_by_brand($(this).val());
        }

    });

    $("#selected_car").change(function () {

        if($(this).val() != "")
        {
            $(".form-body").css('display', 'block');
            car_details($(this).val());
        }
        else
            $(".form-body").css('display', 'none');
    });

    $(".dropdown-toggle").click(function () {
        $(this).addClass('active');
        $(".dropdown-menu").css('width', '100%');
        $(".dropdown-item").css('text-align', 'center');

        $("#nav-item-car").removeClass('active');
    });

    $("#nav-item-car").click(function () {
        $(this).addClass('active');
        $(".dropdown-toggle").removeClass('active');
        $(".car_details").css('display', 'none');
        $("#car_details").css('display', 'block');
        $(".dropdown-item").removeClass('disabled');
    });

    $(".dropdown-item").click(function () {
        $(".dropdown-item").removeClass('disabled');

        const text = $(this).text();

        $(".dropdown-toggle").text(text);

        $(this).addClass('disabled');

        const id = this.id;

        $("#car_details").css('display', 'none');
        $("#div_"+id).css('display', 'block');
    });

    $("#trigger_new_part_modal").click(function(){
        $(this).removeClass('disabled');
    });

    $("#trigger_new_brand_modal").click(function(){
        $(this).removeClass('disabled');
    });

    $(".notes").click(function () {
        var id = this.id.replace('notes_', "");

        notes_modal(id);
    });

    search_car();

    //slim_select_brand();

    verify_system_parts();

    //slim_select_brand_parts();

});

function slim_select_brand_parts()
{
    var select = new SlimSelect({
        select: '#brand_parts_id',
        placeholder: 'Escolha uma marca'
    })
}


function search_car()
{
    if(location.pathname === "pecas")
    {
        var select = new SlimSelect({
            select: '#selected_car',
            placeholder: 'Pesquisar'
        });

        select.setSearch("Nenhum resultado encontrado");
    }

}

function slim_select_brand()
{
    var select = new SlimSelect({
        select: '#brand_id',
        placeholder: 'Pesquisar'
    });

    select.setSearch('Nenhum resultado encontrado.');

    $("input[type=search]").attr('placeholder', 'Pesquisar');
}

function slim_select_car($brand_id)
{
    var select = new SlimSelect({
        select: '#car_id',
    });

    select.destroy();

    var request = $.ajax({
        url: '/teste/'+$brand_id,
        method: 'GET',
        dataType: 'json'
    });

    request.done(function (e) {

        if(e.status)
        {
            var values = [];

            for(var i = 0; i < e.cars.length; i++)
            {
                values.push({text: e.cars[i].model});
            }

            select = new SlimSelect({
                select: '#car_id',
                data: values
            });
        }
    });

    request.fail(function (e) {
        console.log('fail', e);
    });
}


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

//Listing cars by brand when input #brand changes
//Lista de carros por montadora
function list_cars_by_brand($brand_id)
{
    $("#car_id option").remove();

    var request = $.ajax({
        url: '/list_cars_by_brand/' + $brand_id,
        method: 'GET',
        dataType: 'json'
    });

    request.done(function (e) {
        if(e.status)
        {

            var append = "";

            for(var i = 0; i < e.cars.length; i++)
            {
                append += '<option value="'+e.cars[i].id+'">'+e.cars[i].model+'</option>';
            }

            $("#car_id").attr('readonly', null).append(append);
        }
        else{
            sweet_alert_error(e.msg);
        }
    });

    request.fail(function (e) {
        sweet_alert_error();
        console.log('fail', e);
    });
}

function delete_part_name($id)
{
    var data = {
        title: 'Atenção',
        text: 'Tem certeza que deseja excluir a peça selecionada',
        icon: 'warning',
        button: 'Excluir',
        success_msg: 'A peça foi excluída',
        reload: false,
        id: $id
    }

    var ajax = {
        url: 'part_name/' + $id,
        method: 'DELETE'
    }

    return sweet_alert(data, ajax);
}

function part_name_modal($id)
{
    if($id) {
        $("#part_name_id").val($id);
        $("#title").text('Editar Peça: ' + $("#part_name_"+$id).text());
        $("#part_name").val($("#part_name_"+$id).text());
        $("#system_id option").filter(function () {
            return this.text == $("#part_system_"+$id).text();
        }).attr('selected', true);
    }
    else {
        $("#part_name_id").val("0");
        $("#title").text("Nova Peça");
        $("#part_name").val('');
        $("#system_id").val('');
    }

    $("#modal_part_name").modal('show');
}

//Submits a new part_name or edit an existing one
//Cadastra ou altera uma peça
function part_name()
{
    var id = $("#part_name_id").val();
    var url = '/part_name';
    var p_error = $("#part_name_error");
    var s_error = $("#system_error");

    p_error.css('display', 'none');
    s_error.css('display', 'none');

    if($("#part_name").val() === "")
    {
        p_error.css('display', 'block');
        return false;
    }

    if($("#system_id").val() === "")
    {
        s_error.css('display', 'block');
        return false;
    }

    if(id === "0")
    {
        $.ajax({
            url: url,
            method: 'POST',
            dataType: 'json',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8'
            },
            data:{
                'name': $("#part_name").val(),
                'system_id': $("#system_id").val()
            }
        }).done(function (e) {
            if(e.status)
            {
                sweet_alert_success('A peça foi cadastrada com sucesso');

                setTimeout(function () {
                    location.reload();
                }, 3000);
            }
            else
                sweet_alert_error(e.msg);

        }).fail(function (e) {
            sweet_alert_error();
            console.log('fail', e);
        });
    }
    else
    {
        $.ajax({
            url: url + '/' + id,
            method: 'PUT',
            dataType: 'json',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8'
            },
            data:{
                'name': $("#part_name").val(),
                'system_id': $("#system_id").val(),
            }

        }).done(function (e) {
            if(e.status)
            {
                sweet_alert_success('A peça foi alterada com sucesso');

                $("#part_name_"+id).text($("#part_name").val());
                $("#part_system_"+id).text(
                    $("#system_id option[value="+$("#system_id").val()+"]").text());

                $("#modal_part_name").modal('hide');
            }
            else
                sweet_alert_error(e.msg);

        }).fail(function (e) {
            sweet_alert_error();
            console.log('fail', e);
        });
    }
}

//Pagination part_name / Paginação na página de peças
function load_more_part_name($e)
{
    var append = '';

    for (var i = 0; i < $e.model.length; i++)
    {
        append += '<tr class="row100 body" id="model_'+$e.model[i].id+'">';
        append += '<td>'+$e.model[i].name+'</td>';
        append += '<td>'+$e.model[i].system_name+'</td>';
        append += '<td><button class="btn btn-sm btn-outline-info" title="Editar Peça" onclick="part_name_modal('+$e.model[i].id+')"><i class="fas fa-edit"></i></button>';
        append += '<button class="btn btn-sm btn-outline-danger" onclick="feature_not_available();" title="Excluir Peça"><i class="fas fa-trash"></i></button></td>';
        append += '</tr>';
    }

    return append;
}

//Pagination parts / Paginação na página de carros x peças
function load_more_parts($e)
{
    var append = '';

    for (var i = 0; i < $e.model.length; i++)
    {
        append += '<tr class="row100 body" id="model_'+$e.model[i].id+'">';
        append += '<td>'+$e.model[i].name+'</td>';
        append += '<td>'+$e.model[i].brand_name+'</td>';
        append += '<td><button class="btn btn-sm btn-outline-info" title="Editar Peça"><i class="fas fa-edit"></i></button>';
        append += '<button class="btn btn-sm btn-outline-danger" onclick="feature_not_available();" title="Excluir Peça"><i class="fas fa-trash"></i></button></td>';
        append += '</tr>';
    }

    return append;
}

//Detalhes do carro escolhido
function car_details($id)
{
    var request = $.ajax({
        url: 'car_details/' + $id,
        method: 'GET',
        dataType: 'json',
    });

    request.done(function (e) {
        if(e.status)
        {
            $("#car_model").text('Modelo: ' + e.car.model);
            $("#car_brand").text('Montadora: ' + e.car.brand);
            $("#car_fuel").text('Combustível: ' + e.car.fuel);
            $("#car_details").css('display', 'block').css('margin-top', '50px');
        }
        else{
            $(".car_details").css('display', 'none');
            sweet_alert_error(e.msg);
        }
    });

    request.fail(function (e) {
        console.log('fail', e);
        sweet_alert_error();
    });
}

function new_part()
{
    var part_name = $("#modal_part_name").val();
    var system = $("#modal_system_id").val();

    $(".buttonload").css('display', 'block');
    $("#submit_new_part").css('display', 'none');

    if(part_name === "")
    {
        $("#modal_part_name").css('border', '1px solid red');
        sweet_alert_error("Preencha o nome da peça");
        $(".buttonload").css('display', 'none');
        $("#submit_new_part").css('display', 'block');
        return;
    }

    if(system === "")
    {
        $("#modal_system_id").css('border', '1px solid red');
        sweet_alert_error("Escolha um sistema");
        $(".buttonload").css('display', 'none');
        $("#submit_new_part").css('display', 'block');
        return;
    }

    var request = $.ajax({
        url: '/part_exists/' + part_name,
        method: 'GET',
        dataType: 'json',
    });

    request.done(function(e){
        if(!e.status)
        {
            $.ajax({
                url: '/store_part_name',
                method: 'POST',
                dataType: 'json',
                data:{
                    'name': part_name,
                    'system_id': system,
                },
                success: function(e){
                    sweet_alert_success('A Peça foi cadastrada com sucesso');

                    var append = '<option value="'+e.id+'" selected>'+part_name+'</option>';

                    $("#part_id").append(append);
                    $('#system_id').val(system);

                },
                fail: function(e){
                    sweet_alert_error(e.msg);

                }

            }).always(function(e){
                    $(".buttonload").css('display', 'none');
                    $("#submit_new_part").css('display', 'block');
                    $("#modal_part_name").val('');
                    $("#modal_system_id").val('');
                    $("#new_part").modal('hide');
                });
        }
        else{
            sweet_alert_error(e.msg);
            $(".buttonload").css('display', 'none');
            $("#submit_new_part").css('display', 'block');
            return;
        }

    });

    request.fail(function(e){
        console.log('fail', e);
        sweet_alert_error();
        return true;
    });

}

function new_part_brand()
{
    var brand = $("#modal_part_brand").val();

    $(".buttonload").css('display', 'block');
    $("#submit_new_brand").css('display', 'none');

    if(brand === "")
    {
        sweet_alert_error('Preencha o campo Marca');
        $("#modal_part_brand").css('border', '1px solid red');
        $(".buttonload").css('display', 'none');
        $("#submit_new_brand").css('display', 'block');
        return;
    }
    else{
        $.ajax({
            url: '/store_part_brand',
            method: 'POST',
            dataType: 'json',
            data:{'name': brand},
            success:function(e){
                if(e.status)
                {
                    sweet_alert_success('A Marca ' + brand + ' foi cadastrada com sucesso');

                    $("#new_part_brand").modal('hide');

                    var append = '<option value="'+e.id+'" selected>'+brand+'</option>';
                    $("#brand_parts_id").append(append);
                }
                else
                    sweet_alert_error(e.msg);

            },
            fail: function(e) {
                console.log('fail', e);
                sweet_alert_error();
            }
        }).always(function(e) {
            $(".buttonload").css('display', 'none');

            $("#submit_new_brand").css('display', 'block');

            $("#modal_part_brand").val('');
        });
    }
}

function notes_modal($id)
{
    var notes = $("#notes_input_" + $id).val();

    $('#notes_modal').modal('show');

    $("#notes").text(notes);

    $("#notes_modal_id").val($id);

}

function update_notes()
{

    var notes = $("#notes").val();

    $.ajax({
        url: '/update_notes/' + $("#notes_modal_id").val(),
        method: 'POST',
        dataType: 'json',
        data: {'notes': notes},
        success: function (e) {
            if(e.status)
                sweet_alert_success('Alteração cadastrada com sucesso');

            else
                sweet_alert_error(e.msg);

        },fail: function (e) {
            console.log('fail', e);
            sweet_alert_error();
        }
    }).always(function (e) {
        $("#notes_modal").modal('hide');
    });
}

function delete_single_part($id)
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
        url: '/single_part/' + $id,
        method: 'DELETE',
    };

    return sweet_alert(data, ajax);
}
