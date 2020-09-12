
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


<div class="form-body">
    <div class="form-title">
        <p> @if($edit) Editar Veículo: {{ $vehicle->model }} @else Novo Veículo @endif</p>
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
            </div>
        </div>
    </div>

    <hr>

    <div class="form-wrapper">
        @if($edit)
            <form action="{{ route('vehicle.update', ['id' => $vehicle->id]) }}" method="POST">
                @method('PUT')
                @else
                    <form action="{{ route('vehicle.store') }}" method="POST">
                        @endif

                        <div class="row">
                            <div class="col-md-6 col-xs-6">
                                <div class="form-group">
                                    <label for="owner_id">Proprietário</label>
                                    <select id="owner_id" name="owner_id" class="form-control">
                                        <option value="">Selecione um valor</option>
                                        @foreach($people as $person)
                                            @if($edit)
                                                <option value="{{ $person->id }}" @if($person->id == $vehicle->owner_id) selected @endif >{{ $person->name }}</option>
                                            @else
                                                <option value="{{ $person->id }}">{{ $person->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <span class="form-text text-danger" id="span_owner_id_status" style="display:none;">Escolha um proprietário.</span>
                                </div>
                            </div>

                            <div class="col-md-6 col-xs-6">
                                <div class="form-group">
                                    <label for="">Veículos</label>
                                    <div class="dropdown">
                                        <div id="myDropdown" class="dropdown-content">
                                            <input type="hidden" name="car_id" id="hidden_car_id">
                                            <input type="text" placeholder="Pesquise por veículos" id="myInput" style="margin-top: 3px;">
                                            {{--<a href="#about">About</a>
                                            <a href="#base">Base</a>
                                            <a href="#blog">Blog</a>
                                            <a href="#contact">Contact</a>
                                            <a href="#custom">Custom</a>--}}
                                        </div>
                                    </div>
{{--
                                    <label for="car_id">Veículos</label>
                                    <div class="input">
                                        <input type="text" class="div-input" style="margin-top: -4px;">
                                    </div>
                                    <div class="input-result"></div>--}}
                                    {{--<select id="car_id" name="car_id" class="form-control" required>
                                        <option value="">Selecione um veículo</option>

                                            @foreach($cars as $car)
                                                @if($edit)
                                                    <option value="{{ $vehicle->id }}" @if($car->id == $vehicle->car_id) selected @endif >{{ $car->model }}</option>
                                                @else
                                                    <option value="{{ $car->id }}">{{ $car->model }}</option>
                                                @endif
                                            @endforeach

                                    </select>--}}
                                    <span class="form-text text-danger" id="span_car_id_status" style="display:none;">Escolha um veículo.</span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Cor</label>
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

                            <div class="col-md-6 col-sm-6">
                                <label>Km</label>
                                <input class="form-control number" type="text" name="km"
                                       id="km" placeholder="Ex: 150000" value="@if($edit){{ $vehicle->km }}@else{{ old('km') }}@endif">

                                <span class="form-text text-danger" id="span_km_status" style="display: none;">Insira um valor válido</span>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-4 col-sm-6">
                                <label>Placa</label>
                                <input class="form-control" type="text" name="license_plate" maxlength="8"
                                       id="license_plate" placeholder="Ex: ABC-1234" value="@if($edit){{ $vehicle->license_plate }}@else{{ old('license_plate') }}@endif">

                                <span id="span_license_plate_status" style="color: red; display:none;"></span>
                            </div>

                            <div class="col-md-4 col-sm-6">
                                <label>Chassis</label>
                                <input class="form-control" type="text" name="chassis"
                                       id="chassis" placeholder="Ex: 5jA mM1g5C 3R WG4610" value="@if($edit){{ $vehicle->chassis }}@else{{ old('chassis') }}@endif">

                                <span class="form-text text-danger" id="span_chassis_status" style="display: none;">Insira um valor válido</span>
                            </div>

                            <div class="col-md-4 col-sm-6">
                                <label>Ano</label>
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
                        </div>



                        <div class="row">
                            <div class="col-md-12 col-xs-6">
                                <div class="form-group">
                                    <label for="description">Descrição</label>
                                    <textarea type="text" id="description" name="description" class="form-control" rows="10"
                                              placeholder="Entre com informações relevantes do veículo.">@if($edit){{ $vehicle->description }}@else{{ old('description') }}@endif</textarea>
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
