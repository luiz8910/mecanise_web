
<div class="form-body">
    <div class="form-title">
        <p> @if($edit) Editar @else Novo @endif Carro</p>


    </div>

    <div class="form-options">
        <i class="fas fa-cog"></i>
    </div>

    <hr>

    <div class="form-wrapper">
        @if($edit)
            <form action="{{ route('cars.update', ['id' => $car->id]) }}" method="POST">
            @method('PUT')
        @else
            <form action="{{ route('cars.store') }}" method="POST">
        @endif

            <div class="row">
                <div class="col-md-8 col-xs-6">
                    <div class="form-group">
                        <label for="model">Modelo</label>
                        <input type="text" id="model" name="model" class="form-control"
                               required placeholder="Ex: Palio, Onix, Corsa" value="@if($edit){{ $car->model }}@else{{ old('model') }}@endif">
                        <span class="form-text text-danger" id="span_model_status" style="display:none;">Insira um modelo válido.</span>
                        <span id="span_valid_model">Ótimo, este carro ainda não existe na base de dados.</span>
                        <span id="span_invalid_model">Atenção, este carro já foi cadastrado.</span>
                    </div>
                </div>



            </div>

            <div class="row">
                <div class="col-md-4 col-xs-6">
                    <div class="form-group">
                        <label for="brand">Montadora</label>
                        <select id="brand" name="brand" class="form-control" required>
                            <option value="">Selecione um valor</option>
                            @foreach($brands as $brand)
                                @if($edit)
                                    <option value="{{ $brand->id }}" @if($brand->id == $car->brand) selected @endif >{{ $brand->name }}</option>
                                @else
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        <span class="form-text text-danger" id="span_brand_status" style="display:none;">Insira uma montadora válida.</span>
                    </div>
                </div>

                <div class="col-md-4 col-xs-6">
                    <div class="form-group">
                        <label for="start_year">Ano Inicial de Fabricação</label>
                        <input type="text" id="start_year" name="start_year" class="form-control"
                               placeholder="Ex: 2000" value="@if($edit){{ $car->start_year }}@else{{ old('start_year') }}@endif">
                        <span id="span_start_year_status" style="color: red; display:none;"></span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 col-xs-6">
                    <div class="form-group">
                        <label for="end_year">Ano Final de Fabricação</label>
                        <input type="text" id="end_year" name="end_year" class="form-control"
                               placeholder="Ex: 2010" value="@if($edit){{ $car->end_year }}@else{{ old('end_year') }}@endif">
                        <span id="span_end_year_status" style="color: red; display:none;"></span>
                    </div>
                </div>

                <div class="col-md-4 col-xs-6">
                    <div class="form-group">
                        <label for="version">Versão</label>
                        <input type="text" id="version" name="version" class="form-control"
                               placeholder="Ex: GTS Turbo" value="@if($edit){{ $car->version }}@else{{ old('version') }}@endif">
                        <span class="form-text text-danger" id="span_version_status" style="display: none;">Insira uma versão válida</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8 col-xs-6">
                    <div class="form-group">
                        <label for="fuel">Combustível</label>
                        <select name="fuel" id="fuel" class="form-control">
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
                    </div>
                </div>
            </div>

            <br><br>
            <div class="row">
                <div class="col-md-8 col-xs-6">
                    <button type="submit" class="btn btn-outline-dark btn-block btn-submit">
                        <i class="fas fa-check"></i>
                        Salvar
                    </button>
                </div>
            </div>

        </form>
    </div>



</div>
