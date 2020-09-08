<div class="col-md-10">
<p class="text-center" style="font-size: 30px;">Clientes Cadastrados: {{ $qtde_model }}</p>
<table class="table table-style table-hover">
    <thead class="">
    <tr>
        <th scope="col">#</th>
        <th scope="col">Nome <i class="fas fa-chevron-down re-order" onclick="reorder('name')"></i></th>
        <th scope="col">Telefone  </th>
        <th scope="col">Email </th>
        <th scope="col">Cliente desde<i class="fas fa-chevron-down re-order" onclick="reorder('created_at')"></i></th>
        <th scope="col">Veículo</th>
        {{--<th scope="col">Último Serviço<i class="fas fa-chevron-down re-order" onclick="reorder('last_job')"></i></th>--}}
        <th scope="col">
            <a href="{{ route('person.create') }}" class="btn btn-success btn-sm" title="Criar Cliente" style="margin-left: 30px; padding-right: 0px;">
                <i class="fas fa-plus"></i>
            </a>
        </th>
    </tr>
    </thead>
    <tbody id="tbody-search" style="display:none;"></tbody>
    <tbody id="tbody-main">
    @foreach($people as $person)
        <tr class="row100 body" id="model_{{ $person->id }}">
            <th scope="row"></th>
            <td><a href="{{ route('person.edit', ['id' => $person->id]) }}" class="car_model">{{ $person->name }}</a></td>
            <td>{{ $person->cel }}</td>
            <td><a href="mailto:{{ $person->email }}"> {{ $person->email }}</a></td>
            <td>{{ date_format(date_create($person->created_at), 'd/m/Y') }}</td>
            <td><a href="{{ route('vehicle.edit', ['id' => $person->vehicle_id]) }}"> {{ $person->vehicle_name }}</a></td>
            <td>
                <a href="{{ route('person.edit', ['id' => $person->id]) }}" class="btn btn-sm btn-outline-info" title="Editar Cliente">
                    <i class="fas fa-edit"></i>
                </a>
                <button class="btn btn-sm btn-outline-danger" onclick="delete_person({!! $person->id !!})" title="Excluir Cliente">
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
