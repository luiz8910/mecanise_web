<div class="col-md-10">
    <p class="text-center" style="font-size: 30px;">Peças Cadastradas: {{ $qtde_model }}</p>
    <table class="table table-style table-hover">
        <thead class="">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Peça <i class="fas fa-chevron-down re-order" onclick="reorder('name')"></i></th>
            <th scope="col">Modelo <i class="fas fa-chevron-down re-order" onclick="reorder('model')"></i> </th>
            <th scope="col">Marca da Peça <i class="fas fa-chevron-down re-order" onclick="reorder('brand_name')"></i></th>
            <th scope="col">Sistema <i class="fas fa-chevron-down re-order" onclick="reorder('system_name')"></i></th>
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
                <td><a href="{{ route('parts.edit', ['id' => $part->id]) }}" class="car_model">{{ $part->name }}</a></td>
                <td><a href="{{ route('cars.edit', ['id' => $part->car_id]) }}">{{ $part->model }}</a></td>
                <td>{{ $part->brand_name }}</td>
                <td>{{ $part->system_name }}</td>
                <td>
                    <a href="{{ route('parts.edit', ['id' => $part->id]) }}" class="btn btn-sm btn-outline-info" title="Editar Peça">
                        <i class="fas fa-edit"></i>
                    </a>
                    <button class="btn btn-sm btn-outline-danger" onclick="delete_part({!! $part->id !!})" title="Excluir Peça">
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
