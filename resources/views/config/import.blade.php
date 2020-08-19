
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
                        <label for="system_id">Peça *</label>
                        <select name="system_id" id="system_id" class="form-control">
                            <option value="">Selecione uma opção</option>
                            @foreach($parts as $part)

                                <option value="{{ $part->id }}">{{ $part->name }}</option>

                            @endforeach
                        </select>
                        <span id="span_part_status" class="span-error">Escolha uma opção</span>
                    </div>
                </div>




                <div class="col-md-5 col-xs-6">
                    <div class="form-group">
                        <label for="brand_parts_id">Marca da Peça *</label>
                        <select name="brand_parts_id" id="brand_parts_id" class="form-control">
                            <option value="">Selecione uma opção</option>
                            @foreach($parts_brands as $pb)

                                <option value="{{ $pb->id }}" @if($pb->id === 1) selected @endif>{{ $pb->name }}</option>

                            @endforeach
                        </select>
                        <span id="span_parts_brands_status" class="span-error">Escolha uma opção.</span>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-md-10">
                    <div class="area-upload">
                        <label for="upload-file" class="label-upload">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <div class="texto">Clique ou arraste o arquivo</div>
                        </label>
                        <input type="file" id="upload-file" multiple/>

                        <div class="lista-uploads">
                        </div>
                    </div>
                </div>

            </div>



            <br><br>
            <div class="row">
                <div class="col-md-10 col-xs-6">
                    <button type="button" class="btn btn-outline-dark btn-block btn-submit" onclick="sub();">
                        <i class="fas fa-check"></i>
                        Salvar
                    </button>
                </div>
            </div>


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
                <button type="button" class="btn btn-success" id="submit_new_brand" onclick="new_part_brand();"><i class="fas fa-check"></i>Enviar</button>
            </div>
        </div>
    </div>
</div>
