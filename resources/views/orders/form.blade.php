<div class="modal fade" id="edit_item" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="code">

                <div class="row">
                    <div class="col-md-6">
                        <label for="modal_parts">Peça/Produto</label>
                        <input type="text" id="modal_parts" class="form-control">
                        <span class="span_modal_error" id="span_modal_parts" style="color: red; display:none;">
                            Preencha este campo
                        </span>
                    </div>

                    <div class="col-md-6">
                        <label for="modal_quantity">Quantidade</label>
                        <input type="text" id="modal_quantity" class="form-control">
                        <span class="span_modal_error" id="span_modal_quantity" style="color: red; display:none;">
                            Preencha este campo
                        </span>
                    </div>
                </div>

                <br>

                <div class="row">
                    <div class="col-md-6">
                        <label for="modal_price_unity">Valor Unitário</label>
                        <input type="text" id="modal_price_unity" class="form-control">
                        <span class="span_modal_error" id="span_modal_price_unity" style="color: red; display:none;">
                            Preencha este campo
                        </span>
                    </div>
                    <div class="col-md-6">
                        <label for="modal_type_item">Tipo</label>
                        <select id="modal_type_item" class="form-control">
                            <option value="Peça">Peça</option>
                            <option value="Produto">Produto</option>
                            <option value="Mão de Obra">Mão de Obra</option>
                        </select>
                        <span class="span_modal_error" id="span_modal_type_item" style="color:red; display:none;">
                            Escolha uma opção
                        </span>
                    </div>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" onclick="save_item();">Salvar</button>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="new_owner" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title text-center">Novo Proprietário</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <div class="modal-body">

                <div class="row">
                    <div class="col-md-6">
                        <label for="modal_name">Nome</label>
                        <input type="text" placeholder="Nome do Proprietário" name="name" id="modal_name" class="form-control" required>

                        <span style="color: red; display: none;" id="span_name_status">Preencha este campo</span>
                    </div>

                    <div class="col-md-6">
                        <label for="modal_cpf">CPF</label>
                        <input type="text" placeholder="CPF do Proprietário" name="cpf" minlength="11"
                               id="cpf" class="form-control modal_input number" required>
                        <span style="color: red; display: none;" id="span_cpf_status">Preencha este campo</span>
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-6">
                        <label for="modal_email">Email</label>
                        <input type="email" placeholder="Email do Proprietário" name="email" id="modal_email" class="form-control modal_input">
                        <span style="color: red; display: none;" id="span_email_status">Preencha este campo</span>
                    </div>

                    <div class="col-md-6">
                        <label for="modal_cel">Celular</label>
                        <input type="text" placeholder="Celular do Proprietário" name="cel" id="modal_cel" class="form-control modal_input phone" required>
                        <span style="color: red; display: none;" id="span_cel_status">Preencha este campo</span>
                    </div>
                </div>



                <div class="row">

                    <div class="col-md-6">
                        <label for="zip_code">CEP</label>

                        <div class="spinner_zip_code">
                            <input type="text" placeholder="Ex: 18000-000" name="zip_code" id="zip_code" maxlength="9"
                                   class="form-control modal_input">
                        </div>

                    </div>

                    <div class="col-md-6">
                        <label for="street">Logradouro</label>
                        <input type="text" placeholder="Ex: Rua 1" name="street" id="street" class="form-control modal_input">
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-6">
                        <label for="number">Número</label>
                        <input type="text" placeholder="Ex: 500" name="number" id="number" class="form-control modal_input number">
                    </div>

                    <div class="col-md-6">
                        <label for="district">Bairro</label>
                        <input type="text" placeholder="Bairro" name="district" id="district" class="form-control modal_input">
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-6">
                        <label for="city">Cidade</label>
                        <input type="text" placeholder="Ex: Sorocaba" name="city" id="city" class="form-control modal_input">
                    </div>

                    <div class="col-md-6">
                        <label for="state">UF</label>
                        <select name="state" id="state" class="form-control modal_input">
                            <option value="">Selecione um estado</option>
                            @foreach($states as $state)
                                <option value="{{ $state->initials }}">{{ $state->state }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fa fa-close"></i>
                    Fechar
                </button>

                <button type="button" class="btn btn-primary" onclick="new_owner()">
                    <i class="fa fa-check"></i>
                    Salvar
                </button>
            </div>


        </div>
    </div>
</div>


<div class="modal fade" id="new_vehicle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title text-center">Novo Veículo (Campos com * são obrigatórios)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <div class="modal-body">

                <div class="row">
                    <div class="col-md-6">
                        <label for="car_id_modal">Modelo *</label>
                        <select id="car_id_modal" class="form-control select2-modal">
                            <option value="">Selecione um valor</option>
                            @foreach($cars as $car)
                                <option value="{{ $car->id }}">{{ $car->model }}</option>
                            @endforeach
                        </select>
                        <span style="color: red; display: none;" id="span_car_id_modal_status">Preencha este campo</span>
                    </div>

                    <input type="hidden" id="brand">
                    <input type="hidden" id="version">

                    <div class="col-md-6">
                        <label for="license_plate">Placa</label>
                        <input type="text" placeholder="Ex: ABC-1234" maxlength="7"
                               id="license_plate" class="form-control modal_input">
                        <span style="color: red; display: none;" id="span_license_plate_status">Preencha este campo</span>
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-6">
                        <label for="chassis">Número do Chassis</label>
                        <input type="text" maxlength="17" placeholder="Exemplo: 5jA mM1g5C 3R Wg4610" id="chassis" class="form-control modal_input">
                        <span style="color: red; display: none;" id="span_chassis_status">Preencha este campo</span>
                    </div>

                    <div class="col-md-6">
                        <label for="km">KM</label>
                        <input type="text" placeholder="Ex: 150.000" id="km" class="form-control point-number modal_input">
                        <span style="color: red; display: none;" id="span_km_status">Preencha este campo</span>
                    </div>
                </div>


                <div class="row">

                    <div class="col-md-6">
                        <label for="year">Ano</label>
                        <select id="year" class="form-control">
                            <option value="">Selecione um valor</option>
                        </select>

                    </div>

                    <div class="col-md-6">
                        <label for="color">Cor</label>
                        <select id="color" class="form-control">
                            <option value="">Selecione uma cor</option>
                            @foreach($colors as $color)
                                <option value="{{ $color->id }}">{{ $color->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fa fa-close"></i>
                    Fechar
                </button>

                <button type="button" class="btn btn-primary" onclick="new_vehicle()">
                    <i class="fa fa-check"></i>
                    Salvar
                </button>
            </div>


        </div>
    </div>
</div>


<div class="form-body">
    <div class="form-title">
        <p> @if($edit) Editar Ordem de Serviço: #{{ $order->code }} @else Nova Ordem de Serviço @endif</p>
    </div>

    <div class="form-options">
        <div class="dropdown dropleft">
            <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Opções
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="javascript:" id="show_new_owner">
                    <i class="fas fa-user"></i> Novo Proprietário
                </a>
                <a class="dropdown-item" href="javascript:" id="show_new_vehicle">
                    <i class="fas fa-car"></i> Novo Veículo
                </a>
            </div>
        </div>
    </div>

    <hr>

    <div class="form-wrapper">
        @if($edit)
            <form action="{{ route('order.update', ['id' => $order->id]) }}" method="POST">
                @method('PUT')
                @else
                    <form action="{{ route('order.store') }}" method="POST">
                        @endif

                        <div class="row">

                            <div class="col-md-6 col-xs-6">
                                <div class="form-group">
                                    <label for="owner_id">Proprietário</label>
                                    <select class="form-control select2" name="owner_id" id="owner_id">
                                        <option value="">Selecione um proprietário</option>
                                        @foreach($people as $person)
                                            @if($edit)
                                                <option value="{{ $person->id }}" @if($person->id == $order->owner_id) selected @endif >{{ $person->name }}</option>
                                            @else
                                                <option value="{{ $person->id }}">{{ $person->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    {{--<div class="dropdown">
                                        <div id="dropdown_owner" class="dropdown-content">
                                            <input type="hidden" name="owner_id" id="owner_id" value="@if($edit){{ $order->owner_id }}@endif">
                                            <input type="text" placeholder="Pesquise por pessoas" id="input_owner" class="myInput"
                                                   style="margin-top: 3px;" value="@if($edit){{ $order->owner_name }}@endif">

                                            --}}{{--<a href="#about">About</a>
                                            <a href="#base">Base</a>
                                            <a href="#blog">Blog</a>
                                            <a href="#contact">Contact</a>
                                            <a href="#custom">Custom</a>--}}{{--
                                        </div>
                                    </div>--}}

                                    <span class="form-text text-danger" id="span_owner_id_status" style="display:none;">Escolha um veículo.</span>
                                </div>
                            </div>


                            {{--<div class="col-md-6 col-xs-6">
                                <div class="form-group">
                                    <label for="owner_id">Proprietário</label>
                                    <select id="owner_id" name="owner_id" class="form-control" required>
                                        <option value="">Selecione um valor</option>
                                        @foreach($people as $person)
                                            @if($edit)
                                                <option value="{{ $person->id }}" @if($person->id == $order->owner_id) selected @endif >{{ $person->name }}</option>
                                            @else
                                                <option value="{{ $person->id }}">{{ $person->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <span class="form-text text-danger" id="span_owner_id_status" style="display:none;">Escolha um proprietário.</span>
                                </div>
                            </div>--}}

                            <div class="col-md-6 col-xs-6">
                                <div class="form-group">
                                    <label for="car_id">Veículos</label>
                                    <select id="car_id" name="car_id" class="form-control" required>
                                        <option value="">Selecione um proprietário primeiro</option>
                                        @if($edit)
                                            @foreach($vehicles as $vehicle)
                                                @if($vehicle->id == $order->vehicle_id)
                                                    <option value="{{ $order->car_id }}" selected >{{ $vehicle->name }}</option>
                                                @else
                                                    <option value="{{ $vehicle->car_id }}">{{ $vehicle->name }}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                    <span class="form-text text-danger" id="span_car_id_status" style="display:none;">Escolha um veículo.</span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-xs-6">
                                <div class="form-group">
                                    <label for="done_at">Data de Abertura:</label>
                                    <input type="text" id="done_at" name="done_at" class="form-control date number" maxlength="10" required
                                           placeholder="Ex: Digite a data em que o serviço começou" value="@if($edit){{ $order->done_at }}@else{{ old('done_at') }}@endif">
                                    <span id="span_done_at_status" style="color: red; display:none;"></span>
                                </div>
                            </div>

                            <div class="col-md-6 col-xs-6">
                                <div class="form-group">
                                    <label for="conclusion_at">Finalizado em:</label>
                                    <input type="text" id="conclusion_at" name="conclusion_at" class="form-control date number"
                                           placeholder="Ex: Digite a data em que o serviço foi concluído" maxlength="10"
                                           value="@if($edit){{ $order->conclusion_at }}@else{{ old('conclusion_at') }}@endif">
                                    <span id="span_conclusion_at_status" style="color: red; display:none;"></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 col-xs-6">
                                <div class="form-group">
                                    <label for="parts_description">Peça / Produto</label>
                                    <input type="text" id="parts_description" class="form-control item_order" maxlength="200"
                                           placeholder="Digite o nome da peça" >
                                    <span id="span_parts_description_status" style="color: red; display:none;"></span>
                                </div>
                            </div>

                            <div class="col-md-1 col-xs-6">
                                <div class="form-group">
                                    <label for="quantity">Qtde.</label>
                                    <input type="text" id="quantity" class="form-control number item_order"
                                           placeholder="1,00" maxlength="10"
                                           value="">
                                    <span id="span_quantity_status" style="color: red; display:none;"></span>
                                </div>
                            </div>

                            <div class="col-md-3 col-xs-6">
                                <div class="form-group">
                                    <label for="price_unity">Valor Unitário</label>
                                    <input type="text" id="price_unity" class="form-control number item_order"
                                           placeholder="Ex: R$500,00" maxlength="10"
                                           value="">
                                    <span id="span_price_unity_status" style="color: red; display:none;"></span>
                                </div>
                            </div>

                            <div class="col-md-3 col-xs-6">
                                <div class="form-group">
                                    <label for="type_item">Tipo</label>
                                    <select id="type_item" class="form-control item_order">
                                        <option value="">Selecione uma opção</option>
                                        <option value="Peça">Peça</option>
                                        <option value="Produto">Produto</option>
                                        <option value="Mão de Obra">Mão de Obra</option>
                                    </select>
                                    <span id="span_type_item_status" style="color: red; display:none;"></span>
                                </div>
                            </div>

                            <div class="col-md-2 col-xs-6">
                                <div class="form-group">
                                    <label for=""></label>
                                    <button type="button" id="add_item" class="btn btn-primary btn-block" onclick="add_item_order();" style="display:block; margin-top: 37px;">
                                        <i class="fas fa-plus"></i>
                                        Adicionar
                                    </button>
                                </div>

                            </div>
                        </div>

                        <div class="row" id="items_table" @if($edit && count($order_item) > 0) style="display:block;" @else style="display: none;" @endif>
                            <div class="col-md-12 col-xs-6">
                                <div class="form-group">
                                    <br><br>
                                    <table class="table">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">Peça</th>
                                            <th scope="col">Quantidade</th>
                                            <th scope="col">Valor</th>
                                            <th scope="col">Valor Total</th>
                                            <th scope="col"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($edit && count($order_item) > 0)
                                            @foreach($order_item as $oi)
                                                <tr id="{{ $oi->code }}">
                                                    <input type="hidden" id="input_parts_item_{{ $oi->code }}" name="parts[]" value="{{ $oi->parts }}">
                                                    <input type="hidden" id="input_quantity_item_{{ $oi->code }}" name="quantity[]" value="{{ str_replace('.', ',', $oi->quantity) }}">
                                                    <input type="hidden" id="input_price_unity_item_{{ $oi->code }}" name="price_unity[]" value="{{ str_replace('.', ',', $oi->price_unity) }}">
                                                    <input type="hidden" id="type_item_{{ $oi->code }}" name="type[]" value="{{ $oi->type }}">
                                                    <th scope='row' id='parts_{{ $oi->code }}'>{{ $oi->parts }}</th>
                                                    <td id='quantity_{{ $oi->code }}'>{{ str_replace('.', ',', $oi->quantity) }}</td>
                                                    <td id="price_unity_{{ $oi->code }}">R${{ str_replace('.', ',', $oi->price_unity) }}</td>
                                                    <td id='td_total_{{ $oi->code }}'>R$ {{ str_replace('.', ',', number_format($oi->total, 2)) }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-info btn-sm" onclick="edit_item({!! $oi->code !!})"><i class="fas fa-edit"></i></button>
                                                        <button type="button" class="btn btn-danger btn-sm" onclick="delete_item({!! $oi->code !!})" style="margin-left: 5px;"><i class="fas fa-trash"></i></button>
                                                    </td>
                                                    <input type="hidden" id="type_item_{{ $oi->code }}" value="{{ $oi->type }}">
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                @if(isset($total) && $total > 0)
                                    <input type="hidden" id="hidden_total" value="{{ $total }}">
                                    <p id="total" class="p-total">R${{ str_replace('.', ',', number_format($total, 2)) }}</p>
                                @else
                                    <input type="hidden" id="hidden_total">
                                    <p id="total" class="p-total"></p>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-xs-6">
                                <div class="form-group">
                                    <label for="description">Descrição</label>
                                    <textarea type="text" id="description" name="description" class="form-control" rows="10"
                                              placeholder="Entre com informações relevantes para a Ordem de Serviço.">@if($edit){{ $order->description }}@else{{ old('description') }}@endif</textarea>
                                    <span class="form-text text-danger" id="span_description_status" style="display: none;"></span>
                                </div>
                            </div>
                        </div>


                        <br><br>
                        <div class="row">
                            <div class="col-md-12 col-xs-6">
                                <button type="submit" class="btn btn-outline-dark btn-block btn-submit">
                                    <i class="fas fa-check"></i>
                                    Salvar
                                </button>
                            </div>
                        </div>

                    </form>
    </div>



</div>


