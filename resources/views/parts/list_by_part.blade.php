<div class="col-md-10">
    <p class="text-center" style="font-size: 30px;">{{ $part_name }} Cadastrados(as): {{ $qtde_model }}</p>
    <table class="table table-style table-hover">
        <thead class="">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Marca <i class="fas fa-chevron-down re-order" onclick="reorder('brand')"></i></th>
            <th scope="col">Cód Marca <i class="fas fa-chevron-down re-order" onclick="reorder('brand_code')"></i> </th>
            <th scope="col">Cód Universal <i class="fas fa-chevron-down re-order" onclick="reorder('universal_code')"></i></th>
            <th scope="col">Tipo <i class="fas fa-chevron-down re-order" onclick="reorder('type')"></i></th>
            <th scope="col">
                <a href="{{ route('parts.create') }}" class="btn btn-success btn-sm" title="Criar Peça" style="margin-left: 30px; padding-right: 0px;">
                    <i class="fas fa-plus"></i>
                </a>
            </th>
        </tr>
        </thead>
        <tbody id="tbody-search" style="display:none;"></tbody>
        <tbody id="tbody-main">
        @foreach($parts as $part)
            <tr class="row100 body" id="model_{{ $part->id }}">
                <th scope="row">{{ $part->id }}</th>
                <td><a href="javascript:" class="car_model">{{ $part->brand_name }}</a></td>
                <td>{{ $part->brand_code }}</td>
                <td><span>{{ $part->universal_code }}</span></td>
                <td>{{ $part->type }}</td>
                <td>
                    <button type="button" class="btn btn-info btn-sm notes" id="notes_{{ $part->id }}">
                        <i class="fas fa-file"></i>
                    </button>
                    <a href="javascript:" class="btn btn-sm btn-outline-info" onclick="feature_not_available();" title="Editar Peça">
                        <i class="fas fa-edit"></i>
                    </a>
                    <button class="btn btn-sm btn-outline-danger" onclick="delete_single_part({!! $part->id !!})" title="Excluir Peça">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
                <input type="hidden" id="notes_input_{{ $part->id }}" value="{{ $part->notes }}">
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

<<div class="modal fade" id="notes_modal" tabindex="-1" role="dialog" aria-labelledby="notes" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Observações</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <textarea name="" id="notes" cols="30" rows="10" class="form-control"></textarea>
                <input type="hidden" id="notes_modal_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-success" onclick="update_notes();">Salvar</button>
            </div>
        </div>
    </div>
</div>
