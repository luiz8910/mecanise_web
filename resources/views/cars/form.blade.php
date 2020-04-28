
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
                Novo Carro
            </span>


            <div class="wrap-input100 validate-input bg1" data-validate="Insira um valor válido">
                <span class="label-input100">Modelo</span>
                <input class="input100 tab-info" type="text" name="model"
                       id="model" placeholder="Ex: Palio, Gol, Onix" required value="@if($edit){{ $car->model }}@else{{ old('model') }}@endif">
            </div>

            <div class="wrap-input100 validate-input bg1 rs1-wrap-input100" data-validate = "Insira um valor válido">
                <span class="label-input100">Montadora</span>
                <input class="input100 tab-info" type="text" name="brand"
                       id="brand" placeholder="Ex: Fiat, Chevrolet, Volkswagen " required value="@if($edit){{ $car->brand }}@else{{ old('brand') }}@endif">
            </div>

            <div class="wrap-input100 bg1 rs1-wrap-input100">
                <span class="label-input100">Ano Inicial de Fabricação</span>
                <input class="input100 tab-info" type="number" name="start_year"
                       id="start_year" placeholder="Ex: 2000" required value="@if($edit){{ $car->start_year }}@else{{ old('start_year') }}@endif">
            </div>

            <div class="wrap-input100 bg1 rs1-wrap-input100">
                <span class="label-input100">Ano Final de Fabricação</span>
                <input class="input100 tab-info" type="number" name="end_year"
                       id="end_year" placeholder="Ex: 2000" required value="@if($edit){{ $car->end_year }}@else {{ old('end_year') }} @endif">
            </div>

            <div class="wrap-input100 bg1 rs1-wrap-input100">
                <span class="label-input100">Versão</span>
                <input class="input100 tab-info" type="text" name="version"
                       id="version" placeholder="Ex: Fire, GTS Turbo" required value="@if($edit){{ $car->version }}@else{{ old('version') }}@endif">
            </div>

            <div class="wrap-input100 input100-select bg1 tab-info select-input">
                <span class="label-input100">Combustível</span>
                <div>
                    <select class="js-select2" name="fuel" required>
                        <option value="">Selecione um valor</option>
                        @foreach($fuels as $fuel)
                            <option value="{{ $fuel->id }}" @if($edit && $fuel->id == $car->fuel) selected @endif>{{ $fuel->name }}</option>
                        @endforeach
                    </select>
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



