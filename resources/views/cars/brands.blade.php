<div class="col-md-10">
    <p class="text-center" style="font-size: 30px;">Montadoras Cadastradas: {{ $qtde_model }}</p>
    <table class="table table-style table-hover">
        <thead class="">
        <tr>
            <th scope="col">Montadora</th>
            <th scope="col">Carros cadastrados</th>
            <th scope="col">
                <button class="btn btn-success btn-sm" title="Criar Montadora" id="new_brand">
                    <i class="fas fa-plus"></i>
                    Nova Montadora
                </button>
            </th>
        </tr>
        </thead>
        <tbody id="tbody-search" style="display:none;"></tbody>
        <tbody id="tbody-main">
            @foreach($brands as $brand)
                <tr class="row100 body" id="model_{{ $brand->id }}">
                    <td id="name_brand_{{ $brand->id }}">{{ $brand->name }}</td>
                    <td>{{ $brand->qtde }}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-info btn_brand" title="Editar Montadora" id="btn_brand_{{ $brand->id }}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger" onclick="feature_not_available();" title="Excluir Montadora">
                            <i class="fas fa-trash"></i>
                        </button>

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

<div class="modal fade" id="modal_brand" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_label"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <input type="text" class="form-control" id="name" placeholder="Ex: Audi, Chevrolet, Volkswagen" autocomplete="off">
                <span id="modal_error" style="display:none; color:red;"></span>
            </div>
            <input type="hidden" id="brand_id" value="">
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Fechar
                </button>
                <button type="button" class="btn btn-success" id="modal_submit">
                    <i class="fas fa-check"></i> Salvar
                </button>
            </div>
        </div>
    </div>
</div>
