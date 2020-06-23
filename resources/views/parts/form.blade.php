
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
            <form action="{{ route('parts.update', ['id' => $part->id]) }}" method="POST">
                @method('PUT')
                @else
                    <form action="{{ route('parts.store') }}" method="POST">
                        @endif

                        <div class="row">
                            <div class="col-md-10 col-xs-6">
                                <div class="form-group">
                                    <label for="brand_id">Montadora</label>
                                    <select name="brand_id" id="brand_id" class="">
                                        <option value="">Selecione uma montadora</option>
                                        @foreach($brands as $brand)
                                            @if($edit)
                                                <option value="{{ $brand->id }}" @if($brand->id == $chosen_brand_id) selected @endif>
                                                    {{ $brand->name }}
                                                </option>
                                            @else
                                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10 col-xs-6">
                                <div class="form-group">
                                    <label for="car_id">Modelo (Escolha uma montadora primeiro)</label>

                                    <select name="car_id[]" id="car_id" multiple class="form-control"
                                            readonly style="margin-top: 0px; height: 220px;">
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-5 col-xs-6">
                                <div class="form-group">
                                    <label for="system_id">Sistema</label>
                                    <select name="system_id" id="system_id" class="form-control">
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

                            <div class="col-md-5 col-xs-6">
                                <div class="form-group">
                                    <label for="part_id">Peça</label>

                                    @if($edit)<input type="hidden" id="hidden_part_id" value="{{ $part->id }}">@endif

                                    <select id="part_id" name="part_id" class="form-control" required>
                                        <option value="">Selecione um sistema ao lado</option>
                                    </select>
                                    <span class="form-text text-danger" id="span_part_id_status" style="display:none;">Insira uma peça válida.</span>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-5 col-xs-6">
                                <div class="form-group">
                                    <label for="brand_parts_id">Marca da Peça</label>
                                    <select name="brand_parts_id" id="brand_parts_id" class="form-control">
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
                            <div class="col-md-5 col-xs-6">
                                <div class="form-group">
                                    <label for="universal_code">Código Universal</label>
                                    <input type="text" name="universal_code" id="universal_code" class="form-control" placeholder="Ex: D8RTCMM-10"
                                           value="@if($edit){{ $part->universal_code }}@else{{ old('universal_code') }}@endif">
                                    <span id="span_universal_code_status" style="color: red; display:none;"></span>
                                </div>
                            </div>

                            <div class="col-md-5 col-xs-6">
                                <div class="form-group">
                                    <label for="type">Tipo</label>
                                    <input type="text" name="type" id="type" class="form-control" autocomplete="off" @if($edit) value="{{ $part->type }}" @endif
                                    placeholder="Insira alguma especificação da peça.">
                                    <span class="form-text text-danger" id="span_type_status" style="display:none;">Insira um tipo válido</span>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-5 col-xs-6">
                                <div class="form-group">
                                    <label for="start_year">Ano Inicial</label>
                                    <input type="text" name="start_year" id="start_year" class="form-control number" maxlength="4" placeholder="Ex: 2000"
                                           value="@if($edit){{ $part->start_year }}@else{{ old('start_year') }}@endif">
                                    <span id="span_start_year_status" style="color: red; display:none;"></span>
                                </div>
                            </div>

                            <div class="col-md-5 col-xs-6">
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
