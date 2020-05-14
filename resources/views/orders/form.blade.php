<div class="container-contact100">
    <div class="wrap-contact100">
        @if($edit)
            <form class="contact100-form validate-form" id="form" method="POST" action="{{ route('order.update', ['id' => $order->id]) }}">
                @method('PUT')
                @else
                    <form class="contact100-form validate-form" id="form" method="POST" action="{{ route('order.store') }}">
                @endif
                        @csrf

                        <span class="contact100-form-title">@if($edit) Editar @else Nova @endif OS</span>

                        <a href="javascript:" class="btn btn-outline-success btn-left" data-target="#new_owner" data-toggle="modal">
                            <i class="fas fa-user"></i>
                            Novo Proprietário
                        </a>

                        <a href="javascript:" class="btn btn-outline-info btn-right" data-target="#new_vehicle" data-toggle="modal">
                            <i class="fas fa-car"></i>
                            Novo veículo
                        </a>


                        @if($edit)
                            <div class="wrap-input100 validate-input bg1 rs1-wrap-input100" data-validate = "Insira um valor válido">
                                <span class="label-input100">Código OS</span>
                                <input class="input100 tab-info" type="text"
                                       id="code" required readonly value="{{ $order->code }}">
                            </div>
                        @endif

                        @if($edit)
                            <div class="wrap-input100 bg1 rs1-wrap-input100">
                                @foreach($owners as $owner)
                                    @if($owner->id == $order->owner_id)
                                        <input type="hidden" value="{{ $owner->id }}" id="owner_id_input" name="owner_id">
                                        @break
                                    @endif
                                @endforeach
                            @else
                                <div class="wrap-input100 bg1">
                                <input type="hidden" value="" id="owner_id_input" name="owner_id">
                            @endif


                            <span class="label-input100">Proprietário</span>
                            <div>
                                <select class="select-style form-control select2" id="owner_id" name="owner_id" required>
                                    <option value="">Selecione um valor</option>
                                    @foreach($owners as $owner)
                                        @if($edit)
                                            <option value="{{ $owner->id }}" @if($owner->id == $order->owner_id) selected @endif>{{ $owner->name }}</option>
                                        @else
                                            <option value="{{ $owner->id }}">{{ $owner->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <span class="form-text text-danger" id="span_owner_id_status" style="display: none;">Selecione uma opção</span>
                                <div class="dropDownSelect2"></div>
                            </div>

                        </div>

                        <input type="hidden" id="car_id_input" name="car_id" value="@if($edit){{ $order->car_id }}@endif">
                        <input type="hidden" id="vehicle_id_input" value="@if($edit){{ $order->vehicle_id }}@endif" name="vehicle_id">


                        <div class="wrap-input100 validate-input bg1" data-validate="Insira um valor válido">
                            <span class="label-input100">Veículo</span>
                            <div>
                                <select id="car_id" class="form-control select-style" required>
                                    <option value="">Selecione um proprietário primeiro</option>
                                    @if($edit)
                                        @foreach($vehicles as $vehicle)
                                            <option value="{{ $vehicle->id }}" @if($vehicle->id == $order->vehicle_id) selected @endif>{{ $vehicle->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="invalid-feedback" id="span-invalid-model" style="display:none;"></div>
                            <span class="form-text text-danger" id="span_model_status" style="display:none;">Insira o veículo.</span>
                        </div>

                        <div class="wrap-input100 validate-input bg1 rs1-wrap-input100" data-validate = "Insira um valor válido">
                            <span class="label-input100">Realizado em:</span>
                            <input class="input100 tab-info date number" type="text" name="done_at"
                                   id="done_at" required
                                   value="@if($edit){{ $order->done_at }}@else{{ old('done_at') }}@endif">

                            <span class="form-text text-danger" id="span_brand_status" style="display:none;">Insira uma data.</span>
                        </div>

                        <div class="wrap-input100 validate-input bg1 rs1-wrap-input100" data-validate = "Insira um valor válido">
                            <span class="label-input100">Finalizado em:</span>
                            <input class="input100 tab-info date number" type="text" name="conclusion_at"
                                   id="conclusion_at" required
                                   value="@if($edit){{ $order->conclusion_at }}@else{{ old('conclusion_at') }}@endif">

                            <span class="form-text text-danger" id="span_brand_status" style="display:none;">Insira uma data.</span>
                        </div>

                        <div class="wrap-input100 validate-input bg0 rs1-alert-validate" data-validate = "Descreva o serviço executado">
                            <span class="label-input100">Descrição</span>
                            <textarea class="input100" name="description" placeholder="Descreva o serviço executado">@if($edit){{ $order->description }}@else{{ old('description') }}@endif</textarea>
                        </div>


                        <div class="container-contact100-form-btn">

                            <button type="button" class="contact50-form-btn next-tab" onclick="next_tab(0, 'tab-info')" disabled>
                                <span>
                                    Salvar
                                    <i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
                                </span>
                            </button>
                        </div>
                    </form>
    </div>
</div>

<br><br><br>




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

                        <span style="color: red; display: none;" id="span_name">Preencha este campo</span>
                    </div>

                    <div class="col-md-6">
                        <label for="modal_cpf">CPF</label>
                        <input type="text" placeholder="CPF do Proprietário" name="cpf" minlength="11"
                               id="modal_cpf" class="form-control modal_input number" required>
                        <span style="color: red; display: none;" id="span_cpf">Preencha este campo</span>
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-6">
                        <label for="modal_email">Email</label>
                        <input type="email" placeholder="Email do Proprietário" name="email" id="modal_email" class="form-control modal_input">
                    </div>

                    <div class="col-md-6">
                        <label for="modal_cel">Celular</label>
                        <input type="text" placeholder="Celular do Proprietário" name="cel" id="modal_cel" class="form-control modal_input phone" required>
                        <span style="color: red; display: none;" id="span_cel">Preencha este campo</span>
                    </div>
                </div>



                <div class="row">

                    <div class="col-md-6">
                        <label for="zip_code">CEP</label>

                        <div class="spinner_zip_code">
                            <input type="text" placeholder="Ex: 18000-000" name="zip_code" id="zip_code" class="form-control modal_input">
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
                        <input type="text" placeholder="Ex: 500" name="number" id="number" class="form-control modal_input">
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
                        <select id="car_id_modal" class="form-control">
                            <option value="">Selecione um valor</option>
                            @foreach($cars as $car)
                                <option value="{{ $car->id }}">{{ $car->model }}</option>
                            @endforeach
                        </select>
                        <span style="color: red; display: none;" id="span_car_id_modal">Preencha este campo</span>
                    </div>

                    <input type="hidden" id="brand">
                    <input type="hidden" id="version">

                    <div class="col-md-6">
                        <label for="license_plate">Placa</label>
                        <input type="text" placeholder="Ex: ABC-1234" minlength="8"
                               id="license_plate" class="form-control modal_input number">
                        <span style="color: red; display: none;" id="span_license_plate">Preencha este campo</span>
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-6">
                        <label for="chassis">Chassis</label>
                        <input type="email" placeholder="Exemplo: 5jA mM1g5C 3R Wg4610" id="chassis" class="form-control modal_input">
                        <span style="color: red; display: none;" id="span_chassis">Preencha este campo</span>
                    </div>

                    <div class="col-md-6">
                        <label for="km">KM</label>
                        <input type="text" placeholder="Ex: 150.000" id="km" class="form-control number modal_input">
                        <span style="color: red; display: none;" id="span_cel">Preencha este campo</span>
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
