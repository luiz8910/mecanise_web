<div class="col-md-10">
    <p class="text-center" style="font-size: 30px;">Veículos Cadastrados: {{ $qtde_model }}</p>
    <table class="table table-style table-hover">
        <thead class="">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Modelo <i class="fas fa-chevron-down re-order" onclick="reorder('model')"></i></th>
            <th scope="col">Proprietário</th>
            <th scope="col">Veículo Cadastrado em<i class="fas fa-chevron-down re-order" onclick="reorder('created_at')"></i></th>
            <th scope="col">Último Serviço<i class="fas fa-chevron-down re-order" onclick="reorder('last_job')"></i></th>
            <th scope="col">
                <a href="{{ route('vehicle.create') }}" class="btn btn-success btn-sm" title="Criar Veículo" style="margin-left: 30px; padding-right: 0px;">
                    <i class="fas fa-plus"></i>
                </a>
            </th>
        </tr>
        </thead>
        <tbody id="tbody-search" style="display:none;"></tbody>
        <tbody id="tbody-main">
        @foreach($vehicles as $vehicle)
            <tr class="row100 body" id="model_{{ $vehicle->id }}">
                <th scope="row"></th>
                <td><a href="{{ route('vehicle.edit', ['id' => $vehicle->id]) }}" class="car_model">{{ $vehicle->model }}</a></td>
                <td><a href="{{ route('person.edit', ['id' => $vehicle->id]) }}"> {{ $vehicle->owner_name }}</a></td>
                <td>{{ date_format(date_create($vehicle->created_at), 'd/m/Y') }}</td>
                <td>{{ $vehicle->last_job }}</td>
                <td>
                    <a href="{{ route('vehicle.edit', ['id' => $vehicle->id]) }}" class="btn btn-sm btn-outline-info" title="Editar Veículo">
                        <i class="fas fa-edit"></i>
                    </a>
                    <button class="btn btn-sm btn-outline-danger" onclick="delete_vehicle({!! $vehicle->id !!})" title="Excluir Veículo">
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
