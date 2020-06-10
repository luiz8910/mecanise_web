
<div class="form-body">
    <div class="form-title">
        <p> @if($edit) Editar @else Nova @endif Peça</p>


    </div>

    <div class="form-options">
        <i class="fas fa-cog"></i>
    </div>

    <hr>

    <div class="form-wrapper">
        @if($edit)
            <form action="" method="POST">
                @method('PUT')
                @else
                    <form action="" method="POST">
                        @endif

                        <div class="row">
                            <div class="col-md-10 col-xs-6">
                                <div class="form-group">
                                    <label for="car_id">Modelo</label>
                                    <select name="car_id" id="car_id" class="form-control">
                                        <option value="">Selecione um carro</option>
                                        @foreach($cars as $car)
                                            @if($edit)
                                                <option value="{{ $car->id }}" @if($car->id == $part->car_id) selected @endif>{{ $car->model }}</option>
                                            @else
                                                <option value="{{ $car->id }}">{{ $car->model }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-5 col-xs-6">
                                <div class="form-group">
                                    <label for="parts_name">Peça</label>
                                    <select id="parts_name" name="parts_name" class="form-control" required>
                                        <option value="">Selecione um valor</option>
                                        @foreach($parts_name as $pn)
                                            @if($edit)
                                                <option value="{{ $pn->id }}" @if($pn->id == $part->part_id) selected @endif >{{ $pn->name }}</option>
                                            @else
                                                <option value="{{ $pn->id }}">{{ $pn->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <span class="form-text text-danger" id="span_parts_status" style="display:none;">Insira uma peça válida.</span>
                                </div>
                            </div>

                            <div class="col-md-5 col-xs-6">
                                <div class="form-group">
                                    <label for="system">Sistema</label>
                                    <select name="system" id="system" class="form-control">
                                        <option value="">Selecione uma opção</option>
                                        @foreach($system as $sys)
                                            @if($edit)
                                                <option value="{{ $sys->id }}" @if($sys->id == $part->system_id) selected @endif>{{ $sys->name }}</option>
                                            @else
                                                <option value="{{ $sys->id }}">{{ $sys->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <span id="span_system_status" style="color: red; display:none;"></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-5 col-xs-6">
                                <div class="form-group">
                                    <label for="parts_brands">Marca da Peça</label>
                                    <select name="parts_brands" id="parts_brands" class="form-control">
                                        <option value="">Selecione uma opção</option>
                                        @foreach($parts_brands as $pb)
                                            @if($edit)
                                                <option value="{{ $pb->id }}" @if($pb->id == $part->brand_parts_id) selected @endif >{{ $pb->name }}</option>
                                            @else
                                                <option value="{{ $pb->id }}">{{ $pb->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <span id="span_parts_brands_status" style="color: red; display:none;"></span>
                                </div>
                            </div>

                            <div class="col-md-5 col-xs-6">
                                <div class="form-group">
                                    <label for="brand_code">Código da Marca</label>
                                    <input type="text" class="form-control" name="brand_code" id="brand_code" placeholder="Ex: U2003"
                                           value="@if($edit){{ $part->brand_code }}@else{{ old('brand_code') }}@endif">
                                    <span id="span_brand_code_status" style="color: red; display:none;"></span>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-4 col-xs-6">
                                <div class="form-group">
                                    <label for="universal_code">Código Universal</label>
                                    <input type="text" name="universal_code" id="universal_code" class="form-control" placeholder="Ex: D8RTCMM-10"
                                           value="@if($edit){{ $part->universal_code }}@else{{ old('universal_code') }}@endif">
                                    <span id="span_universal_code_status" style="color: red; display:none;"></span>
                                </div>
                            </div>

                            <div class="col-md-3 col-xs-6">
                                <div class="form-group">
                                    <label for="start_year">Ano Inicial</label>
                                    <input type="text" name="start_year" id="start_year" class="form-control number" maxlength="4" placeholder="Ex: 2000"
                                           value="@if($edit){{ $part->start_year }}@else{{ old('start_year') }}@endif">
                                    <span id="span_start_year_status" style="color: red; display:none;"></span>
                                </div>
                            </div>

                            <div class="col-md-3 col-xs-6">
                                <div class="form-group">
                                    <label for="end_year">Ano Final</label>
                                    <input type="text" name="end_year" id="end_year" class="form-control number" maxlength="4" placeholder="Ex: 2010"
                                           value="@if($edit){{ $part->end_year }}@else{{ old('end_year') }}@endif">
                                    <span id="span_end_year_status" style="color: red; display:none;"></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-10 col-xs-6">
                                <div class="form-group">
                                    <label for="notes">Observação</label>
                                    <textarea name="notes" id="notes" cols="30" rows="10" class="form-control">@if($edit){{ $part->notes }}@else{{ old('notes') }}@endif</textarea>
                                    <span id="span_brand_code_status" style="color: red; display:none;"></span>
                                </div>
                            </div>

                        </div>




                        <br><br>
                        <div class="row">
                            <div class="col-md-10 col-xs-6">
                                <button type="submit" class="btn btn-outline-dark btn-block btn-submit">
                                    <i class="fas fa-check"></i>
                                    Salvar
                                </button>
                            </div>
                        </div>

                    </form>
    </div>



</div>
