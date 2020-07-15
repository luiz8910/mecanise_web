
<div class="form-body">
    <div class="form-title">
        <p> @if($edit) Editar @else Nova @endif Peça</p>
    </div>

    <div class="form-options">

        <div class="dropdown">
            <button class="btn btn-success dropdown-toggle" type="button" id="dropdown-form-options" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Opções
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <h6 class="dropdown-header">Opções</h6>
                <a class="dropdown-item" href="javascript:" id="trigger_new_part_modal" data-toggle="modal" data-target="#new_part">
                    <i class="fas fa-wrench"></i>
                    Nova Peça
                </a>
                <a class="dropdown-item" href="javascript:" id="trigger_new_brand_modal" data-toggle="modal" data-target="#new_part_brand">
                    <i class="fas fa-copyright"></i>
                    Nova Marca
                </a>
            </div>
        </div>
    </div>

    <hr>


    <div class="form-wrapper">
        @if($edit)
            <form action="{{ route('update.part', ['id' => $part->id]) }}" method="POST">
                @method('PUT')
                @else
                    <form action="{{ route('store.part') }}" method="POST">
                        @endif

                        {{--<div class="row">
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

                        </div>--}}

                        <p style="color: red;">Campos com * são Obrigatórios</p>

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
                                                <option value="{{ $sys->id }}" @if($sys->id == 1) selected @endif>{{ $sys->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <span id="span_system_status" style="color: red; display:none;"></span>
                                </div>
                            </div>

                            <div class="col-md-5 col-xs-6">
                                <div class="form-group">
                                    <label for="part_id">Peça <span style="color: red;">*</span></label>


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
                                                <option value="{{ $pb->id }}" @if($pb->id === 1) selected @endif>{{ $pb->name }}</option>
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
                                    <select name="type" id="type" class="form-control">
                                        <option value="">Selecione uma opção</option>
                                        <option>Aplicação Original MM: 0,9/0,7</option>
                                        <option>Aplicação Original MM: 0,7</option>
                                        <option>Aplicação Original MM: 0,8</option>
                                        <option>NGK GREEN MM: 0,7</option>
                                        <option>G-POWER MM: 0,7</option>
                                        <option>NGK IRIDIUM MM: 0,7</option>
                                    </select>
                                    <span class="form-text text-danger" id="span_type_status" style="display:none;">Insira um tipo válido</span>
                                </div>
                            </div>

                        </div>
                        {{--<div class="row">
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
                        </div>--}}

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

<!-- Modal -->
<div class="modal fade" id="new_part" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nova Peça</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label for="modal_part_name">Nome da Peça</label>
                <input type="text" id="modal_part_name" class="form-control" placeholder="Digite aqui o nome da nova peça">

                <br>

                <label for="modal_system_id">Sistema</label>
                <select id="modal_system_id" class="form-control">
                    <option value="">Selecione uma opção</option>
                    @foreach($system as $sys)
                        <option value="{{ $sys->id }}">{{ $sys->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i>Fechar</button>
                <button class="buttonload" style="display:none;"><i class="fas fa-circle-notch fa-spin"></i>Carregando</button>
                <button type="button" class="btn btn-success" id="submit_new_part" onclick="new_part();"><i class="fas fa-check"></i>Salvar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="new_part_brand" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nova Marca de Peça</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label for="modal_part_name">Marca</label>
                <input type="text" id="modal_part_brand" class="form-control" placeholder="Digite aqui o nome da marca">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i>Fechar</button>
                <button class="buttonload" style="display:none;"><i class="fas fa-circle-notch fa-spin"></i>Carregando</button>
                <button type="button" class="btn btn-success" id="submit_new_brand" onclick="new_part_brand();"><i class="fas fa-check"></i>Salvar</button>
            </div>
        </div>
    </div>
</div>
