<div class="col-md-10">
    <p class="text-center" style="font-size: 30px;">Peças Cadastradas: {{ $qtde_model }}</p>
    <table class="table table-style table-hover">
        <thead class="">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Peça <i class="fas fa-chevron-down re-order" onclick="reorder('name')"></i></th>
            <th scope="col">Sistema <i class="fas fa-chevron-down re-order" onclick="reorder('system_name')"></i></th>
            <th scope="col">
                <button class="btn btn-success btn-sm" title="Criar Peça" onclick="part_name_modal()" style="margin-left: 30px; padding-right: 0px;">
                    <i class="fas fa-plus"></i>
                </button>
            </th>
        </tr>
        </thead>
        <tbody id="tbody-search" style="display:none;"></tbody>
        <tbody id="tbody-main">
        @foreach($parts as $part)
            <tr class="row100 body" id="model_{{ $part->id }}">
                <th scope="row">{{ $part->id }}</th>
                <td id="part_name_{{ $part->id }}">{{ $part->name }}</td>
                <td id="part_system_{{ $part->id }}">{{ $part->system_name }}</td>
                <td>
                    <button class="btn btn-sm btn-outline-info btn_part_name" title="Editar Peça"
                            onclick="part_name_modal({!! $part->id !!})">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger" onclick="delete_part_name({!! $part->id !!})" title="Excluir Peça">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="load-more">
        <button class="btn btn-default btn-outline-dark" id="load-more" onclick="load_more();">
            <i class="fas fa-spinner fa-spin" style="display:none;"></i>
            <i class="fas fa-download"></i>
            <span>Carregar mais resultados</span>
        </button>
    </div>

    <p class="no-results">Não há resultados para exibir, tente pesquisar novamente.</p>


    <input type="hidden" value="{{ $offset }}" id="offset">
</div>

<div class="modal fade" id="modal_part_name" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <label for="part_name">Peça</label>
                <input type="text" id="part_name" class="form-control" autocomplete="off" placeholder="Ex: Vela, Amortecedor, Filtro de Óleo">
                <span id="part_name_error" style="display:none; color: red;">Preencha o campo peça</span>

                <label for="system_id">Sistema</label>
                <select id="system_id" class="form-control">
                    <option value="">Selecione uma opção</option>
                    @foreach($systems as $system)
                        <option value="{{ $system->id }}">{{ $system->name }}</option>
                    @endforeach
                </select>
                <span id="system_error" style="display: none; color: red;">Escolha uma opção acima</span>
            </div>

            <input type="hidden" id="part_name_id" value="0">

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Fechar
                </button>
                <button type="button" class="btn btn-primary" onclick="part_name()">
                    <i class="fas fa-check"></i> Salvar
                </button>
            </div>

        </div>
    </div>
</div>
