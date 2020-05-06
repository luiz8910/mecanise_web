<div class="container-contact100">
    <div class="wrap-contact100">
        @if($edit)
            <form class="contact100-form validate-form" id="form" method="POST" action="{{ route('vehicle.update', ['id' => $vehicle->id]) }}">
                @method('PUT')
        @else
            <form class="contact100-form validate-form" id="form" method="POST" action="{{ route('vehicle.store') }}">
        @endif
            @csrf

                <span class="contact100-form-title">
                    @if($edit) Editar @else Novo @endif Veículo
                </span>

                <div class="wrap-input100 validate-input bg1" data-validate="Insira um valor válido">
                    <span class="label-input100">Modelo</span>
                    <div>
                        <select name="car_id" id="car_id" class="form-control select-style select2" required>
                            <option value="">Selecione um valor</option>
                            @foreach($cars as $car)
                                @if($edit)
                                    <option value="{{ $car->id }}" @if($vehicle->car_id == $car->id) selected @endif>{{ $car->model }}</option>
                                @else
                                    <option value="{{ $car->id }}">{{ $car->model }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="valid-feedback" id="span-valid-model" style="display:none;">Ótimo! Este carro ainda não existe na base de dados</div>
                    <div class="invalid-feedback" id="span-invalid-model" style="display:none;"></div>
                    <span class="form-text text-danger" id="span_model_status" style="display:none;">Insira o modelo.</span>
                </div>

                <div class="wrap-input100 validate-input bg1 rs1-wrap-input100" data-validate = "Insira um valor válido">
                    <span class="label-input100">Montadora</span>
                    <input class="input100 tab-info" type="text" name="brand"
                           id="brand" placeholder="Ex: Fiat, Chevrolet, Volkswagen " required readonly
                           value="@if($edit){{ $vehicle->brand_name }}@else{{ old('brand') }}@endif">

                    <span class="form-text text-danger" id="span_brand_status" style="display:none;">Insira uma montadora válida.</span>
                </div>

                <div class="wrap-input100 bg1 rs1-wrap-input100">
                    <span class="label-input100">Cor</span>
                    <div>
                        <select class="select-style form-control select2" name="color">
                            <option value="">Selecione um valor</option>
                            @foreach($colors as $color)
                                @if($edit)
                                    <option value="{{ $color->id }}" @if($color->id == $vehicle->color) selected @endif>{{ $color->name }}</option>
                                @else
                                    <option value="{{ $color->id }}">{{ $color->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        <span class="form-text text-danger" id="span_color_status" style="display: none;">Selecione uma opção</span>
                        <div class="dropDownSelect2"></div>
                    </div>
                </div>

                <div class="wrap-input100 bg1 rs1-wrap-input100">
                    <span class="label-input100">Placa</span>
                    <input class="input100 tab-info" type="text" name="license_plate" maxlength="8"
                           id="license_plate" placeholder="Ex: ABC-1234" value="@if($edit){{ $vehicle->license_plate }}@else{{ old('license_plate') }}@endif">

                    <span id="span_license_plate_status" style="color: red; display:none;"></span>
                </div>

                <div class="wrap-input100 bg1 rs1-wrap-input100">
                    <span class="label-input100">Chassis</span>
                    <input class="input100 tab-info" type="text" name="chassis"
                           id="chassis" placeholder="Ex: 5jA mM1g5C 3R WG4610" value="@if($edit){{ $vehicle->chassis }}@else{{ old('chassis') }}@endif">

                    <span class="form-text text-danger" id="span_chassis_status" style="display: none;">Insira um valor válido</span>
                </div>

                <div class="wrap-input100 bg1 rs1-wrap-input100">
                    <span class="label-input100">Km</span>
                    <input class="input100 tab-info number" type="text" name="km"
                           id="km" placeholder="Ex: 150000" value="@if($edit){{ $vehicle->km }}@else{{ old('km') }}@endif">

                    <span class="form-text text-danger" id="span_km_status" style="display: none;">Insira um valor válido</span>
                </div>

                <div class="wrap-input100 bg1 rs1-wrap-input100">
                    <span class="label-input100">Ano</span>
                    <div>
                        <select name="year" id="year" class="form-control select-style select2">
                            <option value="">Insira um valor</option>
                            @if($edit)
                                @if(count($years) > 1)
                                    @foreach($years as $year)
                                        <option value="{{ $year }}" @if($vehicle->year == $year) selected @endif>{{ $year }}</option>
                                    @endforeach
                                @else
                                    <option value="{{ $years[0] }}" selected>{{ $years[0] }}</option>
                                @endif
                            @endif
                        </select>
                    </div>

                    <span class="form-text text-danger" id="span_year_status" style="display: none;">Insira um valor válido</span>
                </div>

                <div class="wrap-input100 bg1">
                    @if($edit)
                        @foreach($owners as $owner)
                            @if($owner->id == $vehicle->owner->id)
                                <input type="hidden" value="{{ $owner->id }}" id="owner_id_input" name="owner_id">
                                @break
                            @endif
                        @endforeach
                    @else
                        <input type="hidden" value="" id="owner_id_input" name="owner_id">
                    @endif


                    <span class="label-input100">Proprietário</span>
                    <div>
                        <select class="select-style form-control select2" id="owner_id" required>
                            <option value="">Selecione um valor</option>
                            @foreach($owners as $owner)
                                @if($edit)
                                    <option value="{{ $owner->id }}" @if($owner->id == $vehicle->owner->id) selected @endif>{{ $owner->name }}</option>
                                @else
                                    <option value="{{ $owner->id }}">{{ $owner->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        <span class="form-text text-danger" id="span_owner_id_status" style="display: none;">Selecione uma opção</span>
                        <div class="dropDownSelect2"></div>
                    </div>


                </div>



                <div class="container-contact100-form-btn">
                    <button type="button" class="btn btn-success btn-outline-info contact50-form-btn" data-target="#new_owner" data-toggle="modal"
                            style="background-color: #28a745 !important;">
                        <i class="fas fa-user"></i>
                        <span style="padding-left: 10px;">Novo Proprietário</span>
                    </button>

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
