<div class="container-contact100">
    <div class="wrap-contact100">
        @if($edit)
            <form class="contact100-form validate-form" id="form" method="POST" action="{{ route('cars.update', ['id' => $car->id]) }}">
                @method('PUT')
        @else
            <form class="contact100-form validate-form" id="form" method="POST" action="{{ route('cars.store') }}">
        @endif
            @csrf

            <span class="contact100-form-title">
                @if($edit) Editar @else Novo @endif Carro
            </span>

            <div class="wrap-input100 validate-input bg1" data-validate="Insira um valor válido">
                <span class="label-input100">Modelo</span>
                <input class="input100 tab-info" type="text" name="model"
                       id="model" placeholder="Ex: Palio, Gol, Onix" required value="@if($edit){{ $car->model }}@else{{ old('model') }}@endif">

                <div class="valid-feedback" id="span-valid-model" style="display:none;">Ótimo! Este carro ainda não existe na base de dados</div>
                <div class="invalid-feedback" id="span-invalid-model" style="display:none;"></div>
                <span class="form-text text-danger" id="span_model_status" style="display:none;">Insira o modelo.</span>
            </div>

            <div class="wrap-input100 validate-input bg1 rs1-wrap-input100" data-validate = "Insira um valor válido">
                <span class="label-input100">Montadora</span>
                <div>
                    <select name="brand" id="brand" class="select-style form-control select2" required>
                        <option value="">Selecione um valor</option>
                        @foreach($brands as $brand)
                            @if($edit)
                                <option value="{{ $brand->id }}" @if($brand->id == $car->brand) selected @endif >{{ $brand->name }}</option>
                            @else
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <span class="form-text text-danger" id="span_brand_status" style="display:none;">Insira uma montadora válida.</span>
            </div>

            <div class="wrap-input100 bg1 rs1-wrap-input100">
                <span class="label-input100">Ano Inicial de Fabricação</span>
                <input class="input100 tab-info number" type="text" name="start_year"
                       id="start_year" placeholder="Ex: 2000" maxlength="4" value="@if($edit){{ $car->start_year }}@else{{ old('start_year') }}@endif">

                <span id="span_start_year_status" style="color: red; display:none;"></span>
            </div>

            <div class="wrap-input100 bg1 rs1-wrap-input100">
                <span class="label-input100">Ano Final de Fabricação</span>
                <input class="input100 tab-info number" type="text" name="end_year" maxlength="4"
                       id="end_year" placeholder="Ex: 2000" value="@if($edit){{ $car->end_year }}@else{{ old('end_year') }}@endif">

                <span id="span_end_year_status" style="color: red; display:none;"></span>
            </div>

            <div class="wrap-input100 bg1 rs1-wrap-input100">
                <span class="label-input100">Versão</span>
                <input class="input100 tab-info" type="text" name="version"
                       id="version" placeholder="Ex: Fire, GTS Turbo" value="@if($edit){{ $car->version }}@else{{ old('version') }}@endif">

                <span class="form-text text-danger" id="span_version_status" style="display: none;">Insira uma versão válida</span>
            </div>

            <div class="wrap-input100 input100-select bg1 tab-info select-input">
                <span class="label-input100">Combustível</span>
                <div>
                    <select class="select-style form-control" name="fuel">
                        <option value="">Selecione um valor</option>
                        @foreach($fuels as $fuel)
                            @if($edit)
                                <option value="{{ $fuel->id }}" @if($fuel->id == $car->fuel) selected @endif>{{ $fuel->name }}</option>
                            @else
                                <option value="{{ $fuel->id }}">{{ $fuel->name }}</option>
                            @endif
                        @endforeach
                    </select>
                    <span class="form-text text-danger" id="span_fuel_status" style="display: none;">Selecione uma opção</span>
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



