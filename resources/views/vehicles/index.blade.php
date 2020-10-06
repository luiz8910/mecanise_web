<div class="col-md-10">
    <p class="text-center" style="font-size: 30px;">Veículos Cadastrados: {{ $qtde_model }}</p>

    <div class="text-center">
        <div class="btn-group">
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Ordenar
            </button>
            <div class="dropdown-menu">
                {{--<a class="dropdown-item" href="javascript:" onclick="reorder(null, 'os')">Mais Recentes</a>
                <a class="dropdown-item" href="javascript:" onclick="reorder('owner_name')">Por Proprietário</a>
                <a class="dropdown-item" href="javascript:" onclick="reorder('vehicle_name')">Por Veículo</a>
                <a class="dropdown-item" href="javascript:" onclick="reorder('conclusion_at')">Por data de término</a>--}}
            </div>
        </div>

        <div class="btn-group">
            <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false" style="margin-left: 10px;">
                Filtrar
            </button>
            <div class="dropdown-menu">
                {{--<a class="dropdown-item" href="javascript:" onclick="filter('opened', 'os')">OS em Aberto</a>
                <a class="dropdown-item" href="javascript:" onclick="filter('closed', 'os')">OS concluídas</a>
                <a class="dropdown-item" href="javascript:" style="color: red;">OS por proprietário</a>
                <a class="dropdown-item" href="javascript:" onclick="filter('this_week', 'os')">OS Concluídas nesta semana</a>
                <a class="dropdown-item" href="javascript:" onclick="filter('past_week', 'os')" >OS Concluídas na semana passada</a>
                <a class="dropdown-item" href="javascript:" onclick="filter('this_month', 'os')" >OS Concluídas neste mês</a>
                <a class="dropdown-item" href="javascript:" onclick="filter('past_month', 'os')">OS Concluídas no mês passado</a>
                <a class="dropdown-item" href="javascript:" style="color: red;">Escolha o período</a>--}}
            </div>
        </div>

        <a href="{{ route('vehicle.create') }}" class="btn btn-success" title="Criar Veículo" style="margin-left: 10px;">
            <i class="fas fa-plus"></i>
            Novo Veículo
        </a>
    </div>

    <table class="table table-style table-hover">
        <thead class="">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Modelo <i class="fas fa-chevron-down re-order" onclick="reorder('model')"></i></th>
            <th scope="col">Proprietário</th>
            <th scope="col">Veículo Cadastrado em<i class="fas fa-chevron-down re-order" onclick="reorder('created_at')"></i></th>
            <th scope="col">Último Serviço<i class="fas fa-chevron-down re-order" onclick="reorder('last_job')"></i></th>
            <th scope="col">Cód. OS</th>
            <th scope="col">

            </th>
        </tr>
        </thead>
        <tbody id="tbody-search" style="display:none;"></tbody>
        <tbody id="tbody-main">
        @foreach($vehicles as $vehicle)
            <tr class="row100 body" id="model_{{ $vehicle->id }}">
                <th scope="row"></th>
                <td><a href="{{ route('vehicle.edit', ['id' => $vehicle->id]) }}" class="car_model">{{ $vehicle->model }}</a></td>
                <td><a href="{{ route('person.edit', ['id' => $vehicle->owner_id]) }}"> {{ $vehicle->owner_name }}</a></td>
                <td>{{ date_format(date_create($vehicle->created_at), 'd/m/Y') }}</td>
                <td>{{ $vehicle->last_job }}</td>
                <td>
                    @if($vehicle->order_id)
                        <a href="{{ route('order.edit', ['id' => $vehicle->order_id]) }}">#{{ $vehicle->order }}</a>
                    @else
                        {{ $vehicle->order }}
                    @endif
                </td>
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
