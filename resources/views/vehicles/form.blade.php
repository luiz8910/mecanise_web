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
                    <input class="input100 tab-info" type="text" name="model"
                           id="model" placeholder="Ex: Palio, Gol, Onix" required value="@if($edit){{ $vehicle->model }}@else{{ old('model') }}@endif">

                    <div class="valid-feedback" id="span-valid-model" style="display:none;">Ótimo! Este carro ainda não existe na base de dados</div>
                    <div class="invalid-feedback" id="span-invalid-model" style="display:none;"></div>
                    <span class="form-text text-danger" id="span_model_status" style="display:none;">Insira o modelo.</span>
                </div>

                <div class="wrap-input100 validate-input bg1 rs1-wrap-input100" data-validate = "Insira um valor válido">
                    <span class="label-input100">Montadora</span>
                    <input class="input100 tab-info" type="text" name="brand"
                           id="brand" placeholder="Ex: Fiat, Chevrolet, Volkswagen " required value="@if($edit){{ $vehicle->brand }}@else{{ old('brand') }}@endif">

                    <span class="form-text text-danger" id="span_brand_status" style="display:none;">Insira uma montadora válida.</span>
                </div>

                <div class="wrap-input100 bg1 rs1-wrap-input100">
                    <span class="label-input100">Cor</span>
                    <div>
                        <select class="select-style form-control" name="color">
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
                    <input class="input100 tab-info number" type="text" name="license_plate" maxlength="8"
                           id="license_plate" placeholder="Ex: ABC-1234" required value="@if($edit){{ $vehicle->license_plate }}@else{{ old('license_plate') }}@endif">

                    <span id="span_license_plate_status" style="color: red; display:none;"></span>
                </div>

                <div class="wrap-input100 bg1 rs1-wrap-input100">
                    <span class="label-input100">Chassis</span>
                    <input class="input100 tab-info" type="text" name="chassis"
                           id="chassis" placeholder="Ex: 5jA mM1g5C 3R WG4610" required value="@if($edit){{ $vehicle->chassis }}@else{{ old('chassis') }}@endif">

                    <span class="form-text text-danger" id="span_chassis_status" style="display: none;">Insira um valor válido</span>
                </div>

                <div class="wrap-input100 bg1 rs1-wrap-input100">
                    <span class="label-input100">Km</span>
                    <input class="input100 tab-info number" type="text" name="km"
                           id="km" placeholder="Ex: 150000" required value="@if($edit){{ $vehicle->km }}@else{{ old('km') }}@endif">

                    <span class="form-text text-danger" id="span_km_status" style="display: none;">IInsira um valor válido</span>
                </div>

                <div class="wrap-input100 bg1 rs1-wrap-input100">
                    <span class="label-input100">Ano</span>
                    <input class="input100 tab-info number" type="text" name="year" maxlength="4"
                           id="year" placeholder="Ex: 2018" required value="@if($edit){{ $vehicle->year }}@else{{ old('year') }}@endif">

                    <span class="form-text text-danger" id="span_year_status" style="display: none;">Insira um valor válido</span>
                </div>

                <div class="wrap-input100 bg1 rs1-wrap-input90">
                    <span class="label-input100">Proprietário</span>
                    <div>
                        <select class="select-style form-control" name="owner_id">
                            <option value="">Selecione um valor</option>
                            @foreach($owners as $owner)
                                @if($edit)
                                    <option value="{{ $owner->id }}" @if($onwer->id == $vehicle->owner->id) selected @endif>{{ $onwer->name }}</option>
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
                    <button class="contact100-form-btn next-tab" onclick="next_tab(0, 'tab-info')" disabled>
                        <span>
                            Salvar
                            <i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
                        </span>
                    </button>
                </div>
        </form>
    </div>
</div>



